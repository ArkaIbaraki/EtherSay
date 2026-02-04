<?php

use Illuminate\Support\Facades\Route;
use App\Models\OnlineUser;
use App\Events\UserOffline;

Route::get('/', function () {
    if (session()->has('username')) {
        return redirect()->route('chat');
    }
    return view('index');
})->name('home');

Route::get('/chat', function () {
    if (!session()->has('username')) {
        return redirect()->route('home');
    }
    return view('chat');
})->name('chat');

Route::post('/heartbeat', function () {
    if (session()->has('username')) {
        \App\Models\OnlineUser::where('session_id', session()->getId())
            ->update(['last_seen' => \Carbon\Carbon::now()]);
    }
    return response()->json(['status' => 'ok']);
})->name('heartbeat');

Route::post('/logout', function () {
    $sessionId = session()->getId();
    $username = session('username');
    
    // Remove from online users
    OnlineUser::where('session_id', $sessionId)->delete();
    
    // Broadcast user offline
    broadcast(new UserOffline($sessionId, $username));
    
    // Clear session
    session()->flush();
    
    return redirect()->route('home');
})->name('logout');
