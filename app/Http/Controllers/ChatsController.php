<?php

namespace App\Http\Controllers;

use App\Chat;
use App\ChatParticipants;
use App\Events\SendMessage;
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
        $chats = Chat::get();
        return view('chat');
    }
    public function fetchConversations()
    {
        $user = Auth::user();
        $chat_participations = ChatParticipants::select('chatId')->where('userId', $user->id)->get();
        $conversations = Chat::with(['participants' => function($query)use($user) {
            $query->join('users', 'users.id', '=', 'chat_participants.userId')
                ->select('chat_participants.*', 'users.name')
                ->where('users.id', '!=', $user->id)->get();
        }, 'last_message'])->whereIn('id', $chat_participations->pluck('chatId'))->get();

        return compact('conversations');
    }

    public function fetchMessages()
    {
        return Chat::with(['participations', 'messages'])->get();
    }


    public function createConversation(Request $request){

        $user = Auth::user();
        $conversation = Chat::create();
        ChatParticipants::create(['chatId' => $conversation->id, 'userId' => $user->id]);
        ChatParticipants::create(['chatId' => $conversation->id, 'userId' => $request->get('userId')]);
        return [];
    }

    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $message = $user->messages()->create([
            'type' => "text",
            'chatParticipantId' => $user->id,
            'chatId' => $request->input('chatId'),
            'message' => $request->input('message')
        ]);

        broadcast(new SendMessage($user, $message))->toOthers();

        return ['status' => 'Message Sent!'];
    }



}
