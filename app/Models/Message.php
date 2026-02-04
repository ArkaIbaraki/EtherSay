<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    protected $fillable = [
        'sender_session_id',
        'sender_username',
        'receiver_session_id',
        'receiver_username',
        'message',
        'is_system_message',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'is_system_message' => 'boolean',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function fileShare(): HasOne
    {
        return $this->hasOne(FileShare::class);
    }

    public function scopePrivate($query, $sessionId1, $sessionId2)
    {
        return $query->where(function ($q) use ($sessionId1, $sessionId2) {
            $q->where('sender_session_id', $sessionId1)
              ->where('receiver_session_id', $sessionId2);
        })->orWhere(function ($q) use ($sessionId1, $sessionId2) {
            $q->where('sender_session_id', $sessionId2)
              ->where('receiver_session_id', $sessionId1);
        });
    }

    public function scopeGlobal($query)
    {
        return $query->whereNull('receiver_session_id');
    }
}
