<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>秒杀</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/common.css">
    <style>
    </style>
</head>
<body>
<div class="content">
    <div class="top_row_line">
        <a style="float: left" href="{:url('User/admin')}" class="orange_button">返回首页</a>
        <span class="grey_button" style="float: right" id="logout">退出</span>
        <a class="blue_button" style="float: right" href="{:url('User/info')}">个人中心</a>
        <span style="float: right; display: inline-block; border-bottom: 1px solid #0085ff; line-height: 29px; margin-right: 10px; padding: 0 5px;">欢迎&nbsp;{:session('uname')}&nbsp;!</span>
    </div>

    <div>
        <div class="layer_div" style="margin-top: 30px;">
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">当前存货：</div>
                <div class="div_right">
                    {$stock}
                </div>
            </div>
            <hr>
            <div class="div_row" style="margin-top: 30px;">
                <div class="div_left"></div>
                <div class="div_right" style="width: 500px;">
                    <span class="blue_button" id="send_one">单次秒杀</span>
                    <span class="blue_button" id="send">轮询秒杀按钮</span>
                    <span class="blue_button" id="clear">清除秒杀缓存</span>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<script src="/static/jquery/jquery-3.6.0.min.js"></script>
<script src="/static/layui/layui.js"></script>
<script type="text/html" id="operation">
    <a href="javascript:;" lay-event="edit">修改</a>|<a href="javascript:;" lay-event="del">删除</a>
</script>
<script>
    layui.use(['form', 'laydate', 'table', 'layer'], function(){
        var table = layui.table,
            form = layui.form,
            layer = layui.layer,
            laydate = layui.laydate;
        //秒杀
        $("#send_one").click(function(){
            $.ajax({
                url : '{:url("Seckill/send")}',
                data: {},
                type:'POST',
                dataType:'JSON',
                success:function (res) {
                    if(res.code == 200){
                        layer.msg(res.message, { icon: 1, time: 1000 });
                        $("#message").val('');
                    } else {
                        layer.msg(res.message, { icon: 5, time: 1000 });
                    }

                },
                error:function () {
                    layer.msg('网络异常', { icon: 5, time: 1000 });
                }
            });
        });
        $("#send").click(function(){
            //js轮询模拟秒杀
            var send = setInterval(function () {
                $.ajax({
                    url : '{:url("Seckill/send")}',
                    data: {},
                    type:'POST',
                    dataType:'JSON',
                    success:function (res) {
                        if(res.code == 200){
                            layer.msg(res.message, { icon: 1, time: 1000 });
                            $("#message").val('');
                        } else {
                            layer.msg(res.message, { icon: 5, time: 3000 });
                            clearInterval(send);
                        }
                    },
                    error:function () {
                        layer.msg('网络异常', { icon: 5, time: 1000 });
                    }
                });
            }, 100);
        });
        //清除秒杀缓存
        $("#clear").click(function(){
            $.ajax({
                url : '{:url("Seckill/clear")}',
                data: {},
                type:'POST',
                dataType:'JSON',
                success:function (res) {
                    if(res.code == 200){
                        layer.msg(res.message, { icon: 1, time: 1000 });
                        $("#message").val('');
                    } else {
                        layer.msg(res.message, { icon: 5, time: 1000 });
                    }

                },
                error:function () {
                    layer.msg('网络异常', { icon: 5, time: 1000 });
                }
            });
            return false;
        });

        //退出
        $("#logout").click(function(){
            $.ajax({
                url : '{:url("Login/logout")}',
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