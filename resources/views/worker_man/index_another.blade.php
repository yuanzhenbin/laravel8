<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WorkerMan-聊天室(js)</title>
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
                <div class="tip_row"><span style="color: red;">*</span>本页面与WorkerMan-聊天室使用的参数有差别，两个页面之间不能进行私聊，这是正常现象</div>
            </div>
            <div class="bottom">
                <div class="div_row" style="margin-top: 10px;">
                    <div style="width: 500px;min-height: 100px;display: inline-block;vertical-align: top;">
                        <textarea rows="6" cols="60" id="message" placeholder="message..." style="padding: 5px; margin-top: 10px; margin-left: 30px;"></textarea>
                    </div>
                    <div style="width: 200px;min-height: 100px;display: inline-block;vertical-align: top;">
                        <button style="margin-top: 10px;" class="blue_button" id="send">发送</button>
                        <input style="width: 100px; display: block; margin-top: 10px; margin-bottom: 10px; display: none;" type="text" name="room_id" id="room_id" value="{$room_id}">
                        <select name="client_list" id="client_list" style="width: 107px; display: none;">
                        </select>
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
<script src="/static/js/web_socket.js"></script>
<script type="text/html" id="operation">
    <a href="javascript:;" lay-event="edit">修改</a>|<a href="javascript:;" lay-event="del">删除</a>
</script>
<script>
    var ws;
    var client_list = {};
    var user_list = {};
    var room_id = $("#room_id").val();
    var oneself_name = "{:session('uname')}";
    // 连接服务端
    function connect() {
        // 创建websocket
        ws = new WebSocket("ws://127.0.0.1:7272");
        // 当socket连接打开时，输入用户名
        ws.onopen = onopen;
        // 当有消息时根据消息类型显示不同信息
        ws.onmessage = onmessage;
        ws.onclose = function() {
            console.log("连接关闭，定时重连");
            connect();
        };
        ws.onerror = function() {
            console.log("出现错误");
        };
        //每次连接更新room_id
        room_id = $("#room_id").val();
    }
    // 连接建立时发送登录信息
    function onopen()
    {
        // 登录
        var login_data = '{"type":"login","uname":"'+oneself_name.replace(/"/g, '\\"')+'","room_id":'+room_id+'}';
        ws.send(login_data);
    }
    // 服务端发来消息时
    function onmessage(e)
    {
        console.log(e.data);
        var data = JSON.parse(e.data);
        switch(data['type']){
            //心跳检测
            case 'ping':
                ws.send('{"type":"pong"}');
                break;
            //登录 更新用户列表
            case 'login':
                var uname = data['uname'];
                if(uname == oneself_name) {
                    uname = '你';
                }
                client_list = data['client_list'];
                user_list = data['user_list'];
                say('tip_row',  uname+' 加入了聊天室');
                flush_client_list();
                flush_user_list();
                break;
            // 发言
            case 'say':
                var type;
                if (data['from_uname'] == oneself_name) {
                    type = 'my_row';
                } else {
                    type = 'other_row';
                }

                say(type, data['content'], data['from_uname'], data['time']);
                break;
            // 用户退出 更新用户列表
            case 'logout':
                say('tip_row',data['from_uname']+' 退出了聊天室');
                delete client_list[data['from_uid']];
                delete user_list[data['uid']];
                flush_client_list();
                flush_user_list();
        }
    }
    //刷新在线用户
    function flush_client_list(){
        var user_list = $("#user_list");
        user_list.empty();
        for(var index in client_list){
            user_list.append('<div class="user_name">'+client_list[index]+'</div>');
        }
    }
    //刷新可以私聊的用户
    function flush_user_list(){
        var html = '<option value="all" selected>所有人</option>';
        for(var index in user_list){
            html += '<option value="'+index+'">'+user_list[index]+'</option>';
        }
        $("#client_list").html(html);
    }
    //发言后在页面添加数据
    function say(type,content,name = '',time = '') {
        if (type == 'tip_row'){
            var html = '<div class="'+type+'">'+content+'</div>';
        } else {
            var html = '<div class="'+type+'"><div class="name_row">'+name+'（'+time+'）：</div><div>'+content+'</div></div>';
        }

        $("#message_box").append(html);
    }

    connect();

    layui.use(['form', 'laydate', 'table', 'layer'], function(){
        var table = layui.table,
            form = layui.form,
            layer = layui.layer,
            laydate = layui.laydate;
        $("#send").click(function(){
            var message = $("#message").val();
            if (!message) {
                layer.msg('消息不能为空', { icon: 5, time: 1000 });
                return false;
            }

            ws.send('{"type":"say","to_uid":"all","to_uname":"所有人","content":"'+message.replace(/"/g, '\\"').replace(/\n/g,'\\n').replace(/\r/g, '\\r')+'"}');
            $("#message").val('');
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