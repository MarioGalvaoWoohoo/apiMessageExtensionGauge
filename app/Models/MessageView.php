<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageView extends Model
{
    use HasFactory;

    protected $fillable = ['unknown_user', 'message_id'];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

}
