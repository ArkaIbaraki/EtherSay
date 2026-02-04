<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OnlineUser;
use App\Events\UserOnline;
use Carbon\Carbon;

class SetUsername extends Component
{
    public $username = '';

    public function setUsername()
    {
        $this->validate([
            'username' => 'required|min:3|max:20|alpha_dash',
        ]);

        // Simpan username ke session
        session([
            'username' => $this->username,
            'session_id' => session()->getId(),
        ]);

        // Tambahkan user ke online users
        $onlineUser = OnlineUser::updateOrCreate(
            ['session_id' => session()->getId()],
            [
                'username' => $this->username,
                'last_seen' => Carbon::now()
            ]
        );

        // Broadcast user online ke semua (termasuk self untuk trigger refresh)
        broadcast(new UserOnline($onlineUser));

        // Redirect ke chat
        return redirect()->route('chat');
    }

    public function render()
    {
        return view('livewire.set-username');
    }
}
