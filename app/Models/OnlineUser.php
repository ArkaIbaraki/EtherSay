<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OnlineUser extends Model
{
    protected $fillable = [
        'session_id',
        'username',
        'last_seen'
    ];

    protected $casts = [
        'last_seen' => 'datetime',
    ];

    public function scopeOnline($query)
    {
        // User dianggap online jika last_seen dalam 5 menit terakhir
        return $query->where('last_seen', '>=', Carbon::now()->subMinutes(5));
    }

    public function updateLastSeen()
    {
        $this->update(['last_seen' => Carbon::now()]);
    }
}
