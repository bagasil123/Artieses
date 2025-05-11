<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping1 implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $message;
    public $comstoriesid;
    public $improfil;
    public $timeAgo;
    public $balcomid;

    public $broadcastQueue = false;

    public function __construct($username, $message = null, $improfil, $timeAgo, $comstoriesid, $balcomid)
    {
        $this->username = $username;
        $this->message = $message;
        $this->comstoriesid = $comstoriesid;
        $this->improfil = $improfil;
        $this->timeAgo = $timeAgo;
        $this->balcomid = $balcomid;
    }
    public function broadcastOn()
    {
        return new Channel('typing-channel');
    }

    public function broadcastAs()
    {
        return 'user.typing';
    }
    public function broadcastWith()
    {
        return [
            'username' => $this->username,
            'message' => $this->message,
            'balcomid' => $this->balcomid,
            'improfil' => $this->improfil,
            'timeAgo' => $this->timeAgo,
            'comstoriesid' => $this->comstoriesid,
        ];
    }
}

