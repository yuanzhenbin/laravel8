<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $message_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message_id)
    {
        $this->message_id = $message_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::table('message')->where('id', $this->message_id)->update(['status' => 2, 'send_time' => time()]);
            data_log(2, '消息队列执行成功321', 'LaravelMessageQueueOne 出队');
        } catch (\Throwable $e){
            var_dump($e);
        }
    }
}
