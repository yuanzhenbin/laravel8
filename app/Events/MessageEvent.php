<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     * 指定广播频道(对应前端的频道)
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        return ['my-channel'];
        return new PrivateChannel('my_channel');
    }

    /**
     * 指定广播事件(对应前端的事件)
     * @return string
     */
    public function broadcastAs()
    {
        return 'my_event';
    }

    /**
     * 获取广播数据,默认是广播的public属性的数据
     */
    public function broadcastWith()
    {
        return ['message' => $this->message];
    }
}
