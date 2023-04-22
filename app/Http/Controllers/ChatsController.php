<?php

namespace App\Http\Controllers;

use App\Chat;
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
    public function fetchChats()
    {
        $user = Auth::user();
        $chats = Chat::with(array('participations' => function($query)use($user) {
            $query->where('userId', '=', $user->id);
        }))->get();
        return compact('chats');
    }

    public function fetchMessages()
    {
        return Chat::with(['participations', 'messages'])->get();
    }


    public function createChat(Request $request){



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
