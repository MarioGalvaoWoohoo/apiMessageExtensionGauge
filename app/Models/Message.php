<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'message', 'type', 'status', 'start_date', 'end_date', 'user_id'];

    protected $appends = ['is_read'];

    public function getIsReadAttribute()
    {
        return $this->messagesViewed !== null;
    }

    public function messagesViewed()
    {
        return $this->hasOne(MessageViewed::class);
    }
}
