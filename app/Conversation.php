<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'user_id',
        'ticket_id',
        'reply',
        'file',
    ];

    // لازم يكون في ريليشن مشان user_id, ticket_id,
}
