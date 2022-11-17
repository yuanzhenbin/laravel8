<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\TestJob;
use Illuminate\Support\Facades\DB;

class TestQueueController extends Controller
{
    //
    public function index()
    {
        return view("test_queue.index");
    }

    public function send()
    {
        $message = request('message');
        $data = [
            'uid' => session('uid'),
            'uname' => session('uname'),
            'message' => $message,
            'status' => 1,//已发送，未送达
            'create_time' => time(),//已发送，未送达
        ];
        $message_id = DB::table('message')->insertGetId($data);
        //消费命令 php artisan queue:work --queue=LaravelMessageQueueOne
        TestJob::dispatch($message_id)->onQueue('LaravelMessageQueueOne');
        data_log(2,'消息队列执行成功','LaravelMessageQueueOne 入队');
        return_ajax([],200,'发送成功');
    }
}
