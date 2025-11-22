<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class SiswaJoinedTournament implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $turnamenId;
    public $user;

    public function __construct($turnamenId, $user)
    {
        $this->turnamenId = $turnamenId;
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new Channel('tournament.' . $this->turnamenId);
    }

    public function broadcastAs()
    {
        return 'siswa.joined';
    }
}
