<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SUCCESS</title>
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
        <h1 style="font-size: 50px;">{$code}</h1>
        <h1 style="font-size: 50px;">{$message}</h1>
        <hr>
        <h3>成功！稍后自动跳转~</h3>
        <h2>o(￣▽￣)o</h2>
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