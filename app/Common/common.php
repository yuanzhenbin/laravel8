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