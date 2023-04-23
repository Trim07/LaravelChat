<?php

namespace App\Http\Controllers;

use App\Chat;
use App\ChatMessages;
use App\ChatParticipants;
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
            }, 'last_message'])->whereIn('id', $chat_participations->pluck('chatId'))->get();

            return compact('conversations');
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    public function fetchMessages(Request $request)
    {
        try {
            $messages = Chat::with(['participants' => function($query) {
                    $query->join('users', 'users.id', '=', 'chat_participants.userId')
                            ->select('chat_participants.*', 'users.name')->get();
                    }, 'messages' => function($query) {
                        $query->join('users', 'users.id', '=', 'chat_messages.chatParticipantId')
                            ->select('chat_messages.*', 'users.name')->orderBy('id', 'asc')->get();
                    }])
                ->where('id', $request->get('chatId'))->get();

//            $messages = ChatMessages::with('participants')
//                ->join('users', 'users.id', '=', 'chat_messages.chatParticipantId')
//                ->where('chatId', $request->get('chatId'))->get();
            return compact('messages');
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }


    public function createConversation(Request $request){

        try {
            $user = Auth::user();
            $conversation = Chat::create();
            ChatParticipants::create(['chatId' => $conversation->id, 'userId' => $user->id]);
            ChatParticipants::create(['chatId' => $conversation->id, 'userId' => $request->get('userId')]);
            return [];
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    public function sendMessage(Request $request)
    {
        try {
            $user = Auth::user();

            $message = $user->messages()->create([
                'type' => "text",
                'chatParticipantId' => $user->id,
                'chatId' => $request->input('chatId'),
                'message' => $request->input('message')
            ]);

            broadcast(new SendMessage($user, $message))->toOthers();

            return ['status' => 'Message Sent!'];
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}
