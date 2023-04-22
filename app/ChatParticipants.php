<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatParticipants extends Model
{
    protected $table = 'chat_participants';
    protected $fillable = ['userId', 'chatId'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'chatId');
    }
}
