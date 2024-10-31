<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class Websocket implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $to;
    public $about;
    public $content;

    /**
     * Create a new event instance.
     */
    public function __construct($to, $about, $content)
    {
        $this->to = $to;
        $this->about = $about;
        $this->content = $content;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            $this->to
        ];
    }

    public function broadcastAs()
    {
        return "event";
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        switch($this->about){
            case "interested":
                return [
                    "about" => $this->about,
                    "offer" => $this->content["offer"],
                    "offername" => $this->content["offername"],
                    "interesteeid" => $this->content["interesteeid"],
                    "interesteename" => $this->content["interesteename"]
                ];break;
            case "incomingmessage":
                return [
                    "about" => $this->about,
                    "offer" => $this->content["offer"],
                    "fromid" => $this->content["fromid"],
                    "fromname" => $this->content["fromname"],
                    "message" => $this->content["message"],
                    "timestamp" => $this->content["timestamp"]
                ];break;
            case "thanked":
                return [
                    "about" => $this->about,
                    "from" => $this->content
                ];break;
            case "grantproposal":
                return [
                    "about" => $this->about,
                    "fromname" => $this->content["fromname"],
                    "offername" => $this->content["offername"],
                ];
            break;
        }
    }
}
