<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redis;

class TestRedisController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        echo "Cache redis：";
        echo "<br>";
        $redis = Cache::store('redis');
        $redis->set('lar1','111');
        echo $redis->get('lar1');
        echo "<br>";
        $redis->put('lar2','222', 10);
        echo $redis->get('lar2');
        echo "<br>";
        echo "<br>";

        echo "Cache：";
        echo "<br>";
        //这个会生成缓存文件 Cache不设置store好像影响不到redis
        Cache::put('c1','ccc');
        Cache::put('c2','c22');
        echo Cache::get('c1');
        echo "<br>";
        var_dump(Cache::add('c1','c1c1c1'));
        echo "<br>";
        var_dump(Cache::forget('lar1'));
        echo "<br>";
        var_dump(Cache::forget('c2'));
        echo "<br>";
        echo "<br>";

        $redis->set('arr1',['data'=>'数据','code'=>200,'message'=>'消息']);
        var_dump($redis->get('arr1'));
        echo "<br>";
        Cache::put('arr1',['data'=>'数据','code'=>200,'message'=>'消息']);
        var_dump(Cache::get('arr1'));
        echo "<br>";
        echo "<br>";

        //默认有前缀 laravel_datatbase_
        echo "原生redis：";
        echo "<br>";
        $redis = app("redis.connection");
        $redis->set('s1','111');
        echo $redis->get('s1');
        echo "<br>";
        $redis->setex('s2', 10, '222');
        echo $redis->get('s2');
        echo "<br>";
        $redis->hset('h1', 'f1', '111');
        $redis->hset('h1', 'f2', '222');
        echo $redis->hget('h1','f1');
        echo "<br>";
        $redis->del('l1');
        $redis->lpush('l1', 1);
        $redis->lpush('l1', 2);
        $redis->rpush('l1', 0);
        var_dump($redis->lrange('l1',0,-1));
        echo "<br>";
        echo $redis->lpop('l1');
        echo "<br>";
        echo $redis->lpop('l1');
        echo "<br>";
        var_dump($redis->lrange('l1',0,-1));
    }
}
