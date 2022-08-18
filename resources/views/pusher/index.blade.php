<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pusher广播</title>
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
        <a style="float: left" href="{{url('Admin/index')}}" class="orange_button">返回首页</a>
        <span class="grey_button" style="float: right" id="logout">退出</span>
        <a class="blue_button" style="float: right" href="{{url('User/info')}}">个人中心</a>
        <span style="float: right; display: inline-block; border-bottom: 1px solid #0085ff; line-height: 29px; margin-right: 10px; padding: 0 5px;">欢迎&nbsp;{{session('uname')}}&nbsp;!</span>
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
        {{--<div class="big_div_right">--}}
            {{--<div style="border-bottom: 1px solid #ff0085;font-size: 20px; text-align: center;color: #ff0085">当前在线</div>--}}
            {{--<div id="user_list">--}}

            {{--</div>--}}
        {{--</div>--}}
    </div>
</div>
</body>

<script src="/static/jquery/jquery-3.6.0.min.js"></script>
<script src="/static/layui/layui.js"></script>
<script src="/static/js/pusher.min.js"></script>

<script>
    var uid = '{{session('uid')}}';
    Pusher.logToConsole = true;

    var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        cluster: '{{env('PUSHER_APP_CLUSTER')}}',
        encrypted: true
    });

    var channel = pusher.subscribe('my_channel');
    channel.bind('my_event', function(data) {
        if(uid == data.from_id) {
            say('my_row', data.message, data.from, data.time);
        } else {
            say('other_row', data.message, data.from, data.time);
        }
    });

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

            $.ajax({
                url : '{{url("Pusher/send")}}',
                data: {
                    message:message,
                },
                type:'POST',
                dataType:'JSON',
                success:function (res) {
                    if(res.code == 200){
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