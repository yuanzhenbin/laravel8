<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>支付宝订单</title>
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
    <div style="width: 100%;">
        <div class="top_row">
            <a style="float: left" href="{:url('User/admin')}" class="orange_button">返回首页</a>
            <a style="float: right" class="blue_button" href="{:url('AliPay/index')}" target="_blank">发起支付</a>
            <span style="float: right;" class="grey_button" id="search_btn">搜索</span>
            <input type="text" id="search" style="float: right; height: 28px; margin-right: 5px;">
        </div>
        <div>
            <table class="layui-hide" id="data_table" lay-filter="data_table"></table>
        </div>
    </div>

    <div id="info" class="layui-form" style="display: none">
        <div class="layer_div" style="margin-top: 30px;">
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">商品订单号：</div>
                <div class="div_right">
                    <span id="number"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">支付宝订单号：</div>
                <div class="div_right">
                    <span id="ali_number"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">订单名称：</div>
                <div class="div_right">
                    <span id="name"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">付款金额：</div>
                <div class="div_right">
                    <span id="amount"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">商品描述：</div>
                <div class="div_right">
                    <span id="describe"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">付款人：</div>
                <div class="div_right">
                    <span id="buyer_logon_id"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">支付时间：</div>
                <div class="div_right">
                    <span id="send_pay_date"></span>
                </div>
            </div>
        </div>
    </div>

    <div id="refund" class="layui-form" style="display: none">
        <div class="layer_div" style="margin-top: 30px;">
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">商品订单号：</div>
                <div class="div_right">
                    <span id="refund_number"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">退款金额：</div>
                <div class="div_right">
                    <span id="refund_amount"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left" style="vertical-align: top;">退款原因：</div>
                <div class="div_right">
                    <input id="refund_reason" autocomplete="off" type="text" name="refund_reason">
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<script src="/static/jquery/jquery-3.6.0.min.js"></script>
<script src="/static/layui/layui.js"></script>
<script type="text/html" id="operation">
    {{# if (d.status == 1){ }}
    <a href="javascript:;" lay-event="pay">支付</a>
    {{# }else{ }}
    <a href="javascript:;" lay-event="info">查看详情</a>
    {{# } }}

    {{# if (d.status == 2){ }}
    <a href="javascript:;" lay-event="refund">退款</a>
    {{# } }}
</script>
<script>
    var pay_url = "{:url('AliPay/pay')}";
    layui.use(['form', 'laydate', 'table', 'layer'], function(){
        var table = layui.table,
            form = layui.form,
            layer = layui.layer,
            laydate = layui.laydate;
        table.render({
            elem: '#data_table'
            ,id: 'data_table'
            ,method: 'post'
            ,url: '{:url("AliPay/order")}'
            ,cellMinWidth: 100
            ,where: {}
            ,page: {
                limit: 10,//默认每页几条
                groups: 10,//连续显示几页
                layout: ['count', 'limit', 'prev', 'page', 'next', 'skip'],//分页位置
                first: "首页",
                last: "尾页",
                theme: "#0085ff"
            }
            ,cols: [[
                {field:'id', title: 'ID', sort: true, align: 'center'}
                ,{field:'name', title: '商品名', align: 'center'}
                ,{field:'number', title: '编号', align: 'center',width: '20%'}
                ,{field:'ali_number', title: '支付宝订单编号', align: 'center',width: '20%'}
                ,{field:'amount', title: '金额', align: 'center'}
                ,{field:'status_show', title: '状态', align: 'center'}
                ,{templet:'#operation', title: '操作', align: 'center'}
            ]]
        });

        table.on('tool(data_table)', function (obj) {
            var row_data = obj.data;
            var id = row_data.id;
            if(obj.event == 'pay'){
                var href = pay_url+'?number='+row_data.number;
                //模拟a链接
                var a = document.createElement('a');
                a.setAttribute('href', href);
                a.setAttribute('target', '_blank');
                a.setAttribute('id', 'js_a');
                //防止反复添加
                if(document.getElementById('js_a')) {
                    document.body.removeChild(document.getElementById('js_a'));
                }
                document.body.appendChild(a);
                a.click();
            } else if(obj.event == 'info') {
                $.ajax({
                    url: '{:url("AliPay/info")}',
                    data: {id: id},
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (res) {
                        var data = res.data;
                        if (res.code == 200) {
                            $("#number").html(data.number);
                            // $("#ali_number").html(data.out_trade_no);
                            $("#ali_number").html(data.ali_number);
                            $("#name").html(data.name);
                            $("#amount").html(data.amount);
                            $("#describe").html(data.describe);
                            $("#buyer_logon_id").html(data.buyer_logon_id);
                            $("#send_pay_date").html(data.send_pay_date);
                            layer.open({
                                type: 1,
                                content: $('#info'),
                                area: ['700px', '400px'],
                                title: '查看详情',
                                btn: ['关闭'],
                                yes: function (index) {
                                    layer.closeAll();
                                },
                                success: function () {

                                }
                            })
                        } else {
                            layer.msg(res.message, { icon: 5, time: 1000 });
                        }
                    }
                })
            } else if(obj.event == 'refund'){
                $("#refund_number").html(row_data.number);
                $("#refund_amount").html(row_data.amount);
                $("#refund_reason").val('');
                layer.open({
                    type:1,
                    content:$('#refund'),
                    area:['700px','400px'],
                    title:'退款',
                    btn:['保存','取消'],
                    yes:function(index){
                        var refund_reason = $("#refund_reason").val();
                        $.ajax({
                            url : '{:url("AliPay/refund")}',
                            data: {
                                id:id,
                                refund_reason:refund_reason,
                            },
                            type:'POST',
                            dataType:'JSON',
                            success:function (res) {
                                if(res.code == 200){
                                    layer.msg(res.message, { icon: 1, time: 1000 });
                                    table.reload('data_table', {
                                        where: {},
                                    });
                                    layer.closeAll();
                                } else {
                                    layer.msg(res.message, { icon: 5, time: 1000 });
                                }
                            },
                            error:function () {
                                layer.msg('网络异常', { icon: 5, time: 1000 });
                            }
                        });
                        return false;
                    },
                    btn2:function(index){
                        layer.closeAll();
                    },
                    success:function(){
                    }
                })
            }
        });
        //搜索
        $("#search_btn").click(function(){
            var search = $("#search").val();
            table.reload('data_table', {
                where: {
                    search:search,
                },
                page: {
                    curr: 1, //重新从第 1 页开始
                    limit: 10,//默认每页几条
                    groups: 10,//连续显示几页
                    layout: ['count', 'limit', 'prev', 'page', 'next', 'skip'],//分页位置
                    first: "首页",
                    last: "尾页",
                    theme: "#0085ff"
                }
            });
        });
    });
</script>


</html>