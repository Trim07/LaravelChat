<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessages extends Model
{
    protected $table = 'chat_messages';
    protected $fillable = ['message', 'type', 'chatParticipantId', 'chatId'];

    public function participants()
    {
        return $this->hasMany(ChatParticipants::class, 'id', 'chatParticipantId');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'chatParticipantId');
    }
}
