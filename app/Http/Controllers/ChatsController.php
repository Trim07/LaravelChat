<?php

namespace App\Http\Controllers;

use App\Chat;
use App\ChatMessages;
use App\ChatParticipants;
use App\Events\ChatNotification;
use App\Events\SendMessage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('chat');
    }
    public function fetchConversations()
    {
        try {
            $user = Auth::user();
            $chat_participations = ChatParticipants::select('chatId')->where('userId', $user->id)->get();
            $conversations = Chat::with(['participants' => function($query)use($user) {
                $query->join('users', 'users.id', '=', 'chat_participants.userId')
                    ->select('chat_participants.*', 'users.name')
                    ->where('users.id', '!=', $user->id)->get();
            }, 'last_message'])->withCount('unreadMessages')->whereIn('id', $chat_participations->pluck('chatId'))->get();

            return compact('conversations');
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    public function fetchMessages(Request $request)
    {
        try {
            $user = Auth::user();
            if(!empty($request->conversationId)){
                $messages = Chat::with(['participants' => function($query)use($user) {
                    $query->join('users', 'users.id', '=', 'chat_participants.userId')
                            ->select('chat_participants.*', 'users.name')
                            ->where('chat_participants.userId', '!=', $user->id)
                            ->get();
                    }, 'messages' => function($query) {
                        $query->join('users', 'users.id', '=', 'chat_messages.chatParticipantId')
                            ->select('chat_messages.*', 'users.name')->orderBy('id', 'asc')->get();
                    }])
                    ->where('id', $request->get('conversationId'))->first();

            }elseif(!empty($request->userId)){
                $participation1 = ChatParticipants::where('userId', $user->id)->get()->pluck('chatId');
                $participation2 = ChatParticipants::where('userId', $request->userId)->get()->pluck('chatId');
                $checkIfConversationExists = array_values(array_intersect($participation1->toArray(), $participation2->toArray()));

                $messages = Chat::with(['participants' => function($query) {
                    $query->join('users', 'users.id', '=', 'chat_participants.userId')
                        ->select('chat_participants.*', 'users.name')->get();
                    }, 'messages' => function($query) {
                        $query->join('users', 'users.id', '=', 'chat_messages.chatParticipantId')
                            ->select('chat_messages.*', 'users.name')->orderBy('id', 'asc')->get();
                    }])->where('id', $checkIfConversationExists[0])->first();
            }

            $messages->updateUnreadMessages();

            return compact('messages');
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }


//    public function createConversation(Request $request){
//
//        try {
//            $user = Auth::user();
//            $conversation = Chat::create();
//            ChatParticipants::create(['chatId' => $conversation->id, 'userId' => $user->id]);
//            ChatParticipants::create(['chatId' => $conversation->id, 'userId' => $request->get('userId')]);
//            return [];
//        }catch (\Exception $e){
//            dd($e->getMessage());
//        }
//    }

    public function sendMessage(Request $request)
    {
        try {
            $participant1 = Auth::user();
            $participant2 = User::find($request->conversationUser);
            $conversationId = $request->input('conversationId', null);

            if(empty($conversationId)){
                $conversation = Chat::create();
                ChatParticipants::create(['chatId' => $conversation->id, 'userId' => $participant1->id]);
                ChatParticipants::create(['chatId' => $conversation->id, 'userId' => $participant2->id]);
                $conversationId = $conversation->id;
            }

            $message = ChatMessages::create([
                'type' => "text",
                'chatId' => $conversationId,
                'chatParticipantId' => $participant1->id,
                'message' => $request->input('message'),
                'read' => 'N',
            ]);

            broadcast(new SendMessage($participant1, $participant2, $message))->toOthers();
            broadcast(new ChatNotification($participant1, $participant2, $message))->toOthers();

            return ['status' => 'Message Sent!'];
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    public function readMessage(Request $request){

    }
}
