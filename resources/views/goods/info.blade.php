<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品详情</title>
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
        <span style="float: right; display: inline-block; border-bottom: 1px solid #0085ff; line-height: 29px; margin-right: 10px; padding: 0 5px;">欢迎&nbsp;{:session('uname')}&nbsp;!</span>
    </div>

    <div>
        <div class="layer_div" style="margin-top: 30px;">
            <div class="div_row">
                <div class="div_left">商品编号：</div>
                <div class="div_right">
                    <span id="number"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">商品名称：</div>
                <div class="div_right">
                    <span id="name"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">价格：</div>
                <div class="div_right">
                    <span id="price"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">库存：</div>
                <div class="div_right">
                    <span id="stock"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">销量：</div>
                <div class="div_right">
                    <span id="sales"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">状态：</div>
                <div class="div_right">
                    <span id="status_show"></span>
                </div>
            </div>
            <hr>
            <div class="div_row">
                <div class="div_left">当前时间：</div>
                <div class="div_right">
                    <span id="now_time"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">数据时间：</div>
                <div class="div_right">
                    <span id="data_time"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">数据来源：</div>
                <div class="div_right">
                    <span id="source"></span>
                </div>
            </div>
            <hr>
            <div class="div_row" style="margin-top: 30px;">
                <div class="div_left"></div>
                <div class="div_right" style="width: 500px">
                    <input type="text" style="height: 28px" id="id" value="" placeholder="输入要查找的商品id">
                    <span class="blue_button" id="search" style="margin-left: 10px">查找</span>
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
        //查找
        $("#search").click(function(){
            var id = $("#id").val();
            $.ajax({
                url : '{:url("Goods/info")}',
                data: {
                    id:id,
                },
                type:'POST',
                dataType:'JSON',
                success:function (res) {
                    if(res.code == 200){
                        layer.msg(res.message, { icon: 1, time: 1000 });
                        $('#number').html(res.data.number);
                        $('#name').html(res.data.name);
                        $('#price').html(res.data.price);
                        $('#stock').html(res.data.stock);
                        $('#sales').html(res.data.sales);
                        $('#status_show').html(res.data.status_show);
                        $('#source').html(res.data.source);
                        $('#now_time').html(res.data.now_time);
                        $('#data_time').html(res.data.data_time);
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
    });
</script>


</html>