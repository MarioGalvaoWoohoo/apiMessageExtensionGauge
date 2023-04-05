<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageViewed extends Model
{
    use HasFactory;

    protected $table = 'messages_viewed';

    protected $fillable = ['unknown_user', 'message_id'];

    public $timestamps = false;

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

}
