<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>管理后台</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/common.css">
    <style>
    </style>
</head>
<body>
<div class="content">
    <div class="top_row_line">
        <span class="grey_button" style="float: right" id="logout">退出</span>
        <a class="blue_button" style="float: right" href="{{url('User/info')}}">个人中心</a>
        <span style="float: right; display: inline-block; border-bottom: 1px solid #0085ff; line-height: 29px; margin-right: 10px; padding: 0 5px;">欢迎&nbsp;{{session('uname')}}&nbsp;!</span>
    </div>
    {{--<div class="div_col">--}}
        {{--<div class="div_row div_line">技术测试</div>--}}
        {{--<div class="div_row"><a href="{{url('Message/index')}}">redis消息队列</a></div>--}}
        {{--<div class="div_row"><a href="{{url('Seckill/index')}}">redis秒杀</a></div>--}}
        {{--<div class="div_row"><a href="{{url('RedisPublish/index')}}">redis发布订阅</a></div>--}}
        {{--<div class="div_row"><a href="{{url('Goods/info')}}">商品详情缓存(redis)</a></div>--}}
        {{--<div class="div_row"><a href="{{url('AliPay/index')}}">支付宝支付</a></div>--}}
        {{--<div class="div_row"><a href="{{url('WorkerMan/index')}}">workerman聊天室</a></div>--}}
        {{--<div class="div_row"><a href="{{url('WorkerMan/indexAnother')}}">workerman聊天室(js)</a></div>--}}
        {{--<div class="div_row"><a href="{{url('Swoole/index')}}">Swoole聊天室</a></div>--}}
    {{--</div>--}}
    <div class="div_col">
        <div class="div_row div_line">系统管理</div>
        <div class="div_row"><a href="{{url('User/index')}}">用户管理</a></div>
        {{--<div class="div_row"><a href="{{url('Department/index')}}">部门管理</a></div>--}}
    </div>
    {{--<div class="div_col">--}}
        {{--<div class="div_row div_line">商城管理</div>--}}
        {{--<div class="div_row"><a href="{{url('Goods/index')}}">商品管理</a></div>--}}
        {{--<div class="div_row"><a href="{{url('AliPay/order')}}">支付宝订单</a></div>--}}
    {{--</div>--}}
    {{--<div class="div_col">--}}
        {{--<div class="div_row div_line">tp6功能测试</div>--}}
        {{--<div class="div_row"><a href="{{url('TestMiddleWare/index')}}">中间件</a></div>--}}
        {{--<div class="div_row"><a href="{{url('TestModel/index')}}">Model</a></div>--}}
        {{--<div class="div_row"><a href="{{url('TestRedis/index')}}">Redis</a></div>--}}
        {{--<div class="div_row"><a href="{{url('TestRoute/index')}}">路由</a></div>--}}
        {{--<div class="div_row"><a href="{{url('TestService/index')}}">服务</a></div>--}}
        {{--<div class="div_row"><a href="{{url('TestEvent/index')}}">事件监听订阅</a></div>--}}
    {{--</div>--}}
    <div class="div_col">
        <div class="div_row div_line">laravel8.5功能测试</div>
        <div class="div_row"><a href="{{url('Pusher/index')}}">Pusher广播</a></div>
        <div class="div_row"><a href="{{url('TestRedis/index')}}">Redis</a></div>
        <div class="div_row"><a href="{{url('RedisSubscribe/index')}}">Redis发布订阅</a></div>
    </div>
</div>
</body>

<script src="/static/jquery/jquery-3.6.0.min.js"></script>
<script src="/static/layui/layui.js"></script>
<script>
    layui.use(['form', 'laydate', 'table', 'layer'], function(){
        var table = layui.table,
            form = layui.form,
            layer = layui.layer,
            laydate = layui.laydate;
        //退出
        $("#logout").click(function(){
            $.ajax({
                url : '{{url("Login/logout")}}',
                data: {},
                type:'POST',
                dataType:'JSON',
                success:function (res) {
                    if(res.code == 200){
                        layer.msg(res.message, { icon: 1, time: 1000 });
                        window.location.reload();
                    } else {
                        layer.msg(res.message, { icon: 5, time: 1000 });
                    }
                },
                error:function () {
                    layer.msg('网络异常', { icon: 5, time: 1000 });
                }
            });

        });
    });
</script>

</html>