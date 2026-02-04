<?php

use Illuminate\Support\Facades\Broadcast;

// Private chat channel untuk setiap user berdasarkan session_id
Broadcast::channel('chat.{sessionId}', function ($user, $sessionId) {
    // Allow jika session_id cocok
    return session()->getId() === $sessionId;
});
