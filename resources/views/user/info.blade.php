<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>个人中心</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/common.css">
    <style>
    </style>
</head>
<body>
<div class="content">
    <div class="top_row_line">
        <a style="float: left" href="{{url('Admin/index')}}" class="orange_button">返回首页</a>
        <span class="grey_button" style="float: right" id="logout">退出</span>
        <span style="float: right; display: inline-block; border-bottom: 1px solid #0085ff; line-height: 29px; margin-right: 10px; padding: 0 5px;">欢迎&nbsp;{{session('uname')}}&nbsp;!</span>
    </div>

    <div>
        <div class="layer_div" style="margin-top: 30px;">
            <div class="div_row">
                <div class="div_left">账号：</div>
                <div class="div_right">
                    {$data['account']}
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">姓名：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="name" value="{$data['name']}">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">电话：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="phone" value="{$data['phone']}">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">邮箱：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="email" value="{$data['email']}">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">性别：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="sex" value="{$data['sex']}">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">状态：</div>
                <div class="div_right">
                    {$data['status_show']}
                </div>
            </div>
            <hr>
            <div class="div_row">
                <div class="div_left" style="width: 120px;">新密码：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="new_password" value="" placeholder="不修改密码请不要动该选项">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left" style="width: 120px;">确认新密码：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="new_password_repeat" value="" placeholder="不修改密码请不要动该选项">
                </div>
            </div>
            <hr>
            <div class="div_row" style="margin-top: 30px;">
                <div class="div_left"></div>
                <div class="div_right">
                    <span class="blue_button" id="save">保存修改</span>
                </div>
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
        //添加
        $("#save").click(function(){
            var name = $("#name").val();
            var phone = $("#phone").val();
            var email = $("#email").val();
            var sex = $("#sex").val();
            var new_password = $("#new_password").val();
            var new_password_repeat = $("#new_password_repeat").val();
            if (new_password != new_password_repeat) {
                layer.msg('两次密码不一致', { icon: 5, time: 1000 });
                return false;
            }
            $.ajax({
                url : '{{url("User/editInfo")}}',
                data: {
                    name:name,
                    phone:phone,
                    email:email,
                    sex:sex,
                    password:new_password
                },
                type:'POST',
                dataType:'JSON',
                success:function (res) {
                    if(res.code == 200){
                        layer.msg(res.message, { icon: 1, time: 1000 },function () {
                            window.location.reload();
                        });
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