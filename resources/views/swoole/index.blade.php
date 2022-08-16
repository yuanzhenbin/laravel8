<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Swoole-聊天室</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/common.css">
    <style>
        .other_row{
            width: 760px;
            line-height: 20px;
            padding: 10px;
            margin-bottom: 5px;
            background: #efefef;
            /*border: 1px dashed #0085ff;*/
            border-radius: 4px;
        }
        .my_row{
            width: 760px;
            line-height: 20px;
            padding: 9px;
            margin-bottom: 5px;
            background: #f5f5f5;
            border: 1px solid #85ff85;
            border-radius: 4px;
        }
        .tip_row{
            width: 760px;
            font-size: 12px;
            line-height: 12px;
            color: #6f6f6f;
            margin-bottom: 5px;
        }
        .name_row{
            color: #0085ff;
            font-size: 12px;
        }
        .big_div_left{
            border: 1px solid #ff8500;
            width: 800px;
            height: 500px;
            display: inline-block;
            padding: 10px;
            vertical-align: top;
        }
        .big_div_right{
            margin-left: 30px;
            border: 1px solid #ff0085;
            width: 250px;
            height: 500px;
            display: inline-block;
            padding: 10px;
            vertical-align: top;
        }
        .top{
            height: 350px;
            overflow-x: hidden;
            overflow-y: scroll;
        }
        .bottom{
            border-top: 1px solid #ff8500;
        }
        .user_name{
            margin-top: 5px;
        }
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

    <div class="layer_div" style="margin-top: 30px; width: 1155px;">
        <div class="big_div_left">
            <div class="top" id="message_box">

            </div>
            <div class="bottom">
                <div class="div_row" style="margin-top: 10px;">
                    <div style="width: 500px;min-height: 100px;display: inline-block;vertical-align: top;">
                        <textarea rows="6" cols="60" id="message" placeholder="message..." style="padding: 5px; margin-top: 10px; margin-left: 30px;"></textarea>
                    </div>
                    <div style="width: 200px;min-height: 100px;display: inline-block;vertical-align: top;">
                        <button style="margin-top: 10px;" class="blue_button" id="send">发送</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="big_div_right">
            <div style="border-bottom: 1px solid #ff0085;font-size: 20px; text-align: center;color: #ff0085">当前在线</div>
            <div id="user_list">

            </div>
        </div>
    </div>
</div>
</body>

<script src="/static/jquery/jquery-3.6.0.min.js"></script>
<script src="/static/layui/layui.js"></script>
<!--<script src="/static/js/web_socket.js"></script>-->
<script src="/static/js/socket.io-1.4.4.js"></script>
<script type="text/html" id="operation">
    <a href="javascript:;" lay-event="edit">修改</a>|<a href="javascript:;" lay-event="del">删除</a>
</script>
<script>
    var uname = "{:session('uname')}";
    var uid = "{:session('uid')}";
    // const socket = io('http://192.168.109.30:9502');
    var wsServer = 'ws://192.168.109.30:9502';
    var websocket = new WebSocket(wsServer);
    websocket.onopen = function (evt) {
        $("#status").html("连接到websocket服务");
    };

    websocket.onopen = function (evt) {
        console.log('open',evt);
        say('tip_row', '连接到websocket服务');
    };

    websocket.onclose = function (evt) {
        console.log('close',evt);
        say('tip_row', '断开连接');
    };

    websocket.onmessage = function (evt) {
        console.log('message',evt);
        say('other_row', evt.data);
    };

    websocket.onerror = function (evt, e) {
        console.log('Error occured: ' + evt.data);
    };

    // // 初始化
    // socket.on('connectcallback', function(res){
    //     say('tip_row', res.msg);
    // });
    //
    // // 发送消息
    // socket.on("sendmsgcallback", function (res) {
    //     say('other_row', res.msg, res.name);
    // });
    //
    // // 关闭聊天室
    // socket.on('closecallback',function(res){
    //     say('tip_row', res.msg);
    // });

    //发言后在页面添加数据
    function say(type, content, name = '',time = '') {
        if (type == 'tip_row'){
            var html = '<div class="'+type+'">'+content+'</div>';
        } else {
            var html = '<div class="'+type+'"><div class="name_row">'+name+'（'+time+'）：</div><div>'+content+'</div></div>';
        }

        $("#message_box").append(html);
    }

    layui.use(['form', 'laydate', 'table', 'layer'], function(){
        var table = layui.table,
            form = layui.form,
            layer = layui.layer,
            laydate = layui.laydate;
        //发言
        $("#send").click(function(){
            var message = $("#message").val();
            if (!message) {
                layer.msg('消息不能为空', { icon: 5, time: 1000 });
                return false;
            }
            $("#message").val('');
            // user.msg = message;
            say('my_row', message, uname);
            websocket.send(message);
            // socket.emit("sendmsg", user);
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