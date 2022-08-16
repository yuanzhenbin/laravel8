<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/common.css">
    <style>

    </style>
</head>
<body>
<div class="content">
    <div style="width: 50%; margin-top: 150px; height: 200px; margin-left: 25%; border: 1px double #8500ff;">
        <div class="layer_div" style="margin:50px 50px;">
            <div style="width: 70%; display: inline-block; vertical-align: top;">
                <div class="div_row">
                    <div class="div_left">账号：</div>
                    <div class="div_right">
                        <input type="text" autocomplete="off" id="account" value="">
                    </div>
                </div>
                <div class="div_row">
                    <div class="div_left">密码：</div>
                    <div class="div_right">
                        <input type="password" autocomplete="off" placeholder="未设置请不要填写此项" id="password" value="">
                    </div>
                </div>
                <div class="div_row">
                    <div class="div_left"></div>
                    <div class="div_right">
                        <span class="grey_button" id="register">注册</span>
                        <span class="blue_button" id="login">登录</span>
                    </div>
                </div>
            </div>
            <div style="width: 25%; height: 90px; vertical-align: top; display: inline-block; position: relative;">
                <img src="/photo/snowflake.ico" alt="" width="120" height="120" style="position: absolute; top: -15px; left: -10px">
            </div>
        </div>
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
        //登录
        $("#login").click(function(){
            var account = $("#account").val();
            var password = $("#password").val();

            $.ajax({
                url : '{:url("Login/login")}',
                data: {
                    account:account,
                    password:password,
                },
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
        //注册
        $("#register").click(function(){
            window.location.reload();
        });
    });
</script>


</html>