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
        return $this->belongsTo(ChatParticipants::class);
    }
    public function messages()
    {
        return $this->belongsTo(ChatMessages::class);
    }


}
