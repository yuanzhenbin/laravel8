<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>支付宝-电脑网站支付</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/common.css">
    <style>
        .div_left{
            width: 120px;
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

    <div>
        <form name=alipayment action="{:url('AliPay/pay')}" method=post target="_blank">
        <div class="layer_div" style="margin-top: 30px;">
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">订单名称：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" name="name" id="name">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">付款金额：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" name="amount" id="amount">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">商品描述：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" name="describe" id="describe">
                </div>
            </div>
            <hr>
            <div class="div_row" style="margin-top: 30px;">
                <div class="div_left"></div>
                <div class="div_right" style="width: 500px;">
                    <button class="blue_button">付款</button>
                </div>
            </div>
        </div>
        </form>
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
        //添加
        $("#send").click(function(){
            var name = $("#name").val();
            var amount = $("#amount").val();
            var describe = $("#describe").val();

            $.ajax({
                url : '{:url("AliPay/pay")}',
                data: {
                    name:name,
                    amount:amount,
                    describe:describe,
                },
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