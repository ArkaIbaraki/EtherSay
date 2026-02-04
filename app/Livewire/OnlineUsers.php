<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OnlineUser;
use Carbon\Carbon;

class OnlineUsers extends Component
{
    public $onlineUsers = [];

    protected $listeners = [
        'refreshOnlineUsers' => '$refresh',
        'echo:online-users,UserOnline' => 'userJoined',
        'echo:online-users,UserOffline' => 'userLeft',
    ];

    public function mount()
    {
        $this->loadOnlineUsers();
    }

    public function userJoined($event)
    {
        $this->loadOnlineUsers();
    }

    public function userLeft($event)
    {
        $this->loadOnlineUsers();
    }

    public function loadOnlineUsers()
    {
        // Clean up users yang sudah offline (tidak update > 5 menit)
        OnlineUser::where('last_seen', '<', Carbon::now()->subMinutes(5))->delete();

        $this->onlineUsers = OnlineUser::online()
            ->where('session_id', '!=', session()->getId())
            ->get()
            ->toArray();
    }

    public function render()
    {
        $this->loadOnlineUsers();
        return view('livewire.online-users');
    }

    public function selectUser($index)
    {
        if (isset($this->onlineUsers[$index])) {
            $user = $this->onlineUsers[$index];
            $this->dispatch('startPrivateChat', 
                sessionId: $user['session_id'], 
                username: $user['username']
            );
        }
    }
}
