<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    protected $table = 'chats';

    // app/Message.php

    /**
     * A message belong to a user
     *
     * @return BelongsTo
     */
    public function participants()
    {
        return $this->belongsTo(ChatParticipants::class, 'id', 'chatId');
    }
    public function messages()
    {
        return $this->hasMany(ChatMessages::class, 'chatId', 'id');
    }

    public function last_message()
    {
        return $this->hasOne(ChatMessages::class, 'chatId', 'id')
            ->orderBy('chat_messages.id', 'desc');
    }


}
