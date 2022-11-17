<?php

function hello_php(){
    echo "hello world! hello php!";
}

function return_ajax($data, $code = 200, $message = "success", $count = 0){
    exit(json_encode([
        "data" => $data,
        "code" => $code,
        "message" => $message,
        "count" => $count
    ]));
}

function data_log($type, $content, $title = "", $create_time = 0){
    \Illuminate\Support\Facades\DB::table('log')->insert([
        'type' => $type,
        'content' => $content,
        'title' => $title,
        'create_time' => $create_time?:time()
    ]);
}