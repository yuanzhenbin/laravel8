<?php

namespace App\Http\Controllers;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Pusher\Pusher;

class PusherController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view("pusher.index");
    }

    public function send()
    {
        $message = request('message','');

        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), array('cluster' =>  env('PUSHER_APP_CLUSTER')));
        $data = ['message'=>$message, 'time'=>date('Y-m-d H:i:s'), 'from'=>session('uname'), 'from_id'=>session('uid')];
        $response = $pusher->trigger('my_channel', 'my_event', $data);

        if ($response) {
            return_ajax([$response]);
        } else {
            return_ajax([],0);
        }
    }
}
