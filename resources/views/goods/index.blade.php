<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品管理</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/common.css">
    <style>
    </style>
</head>
<body>
<div class="content">
    <div style="width: 100%;">
        <div class="top_row">
            <a style="float: left" href="{:url('User/admin')}" class="orange_button">返回首页</a>
            <span style="float: right" class="blue_button" id="add_btn">添加商品</span>
            <span style="float: right;" class="grey_button" id="search_btn">搜索</span>
            <input type="text" id="search" style="float: right; height: 28px; margin-right: 5px;">
        </div>
        <div>
            <table class="layui-hide" id="data_table" lay-filter="data_table"></table>
        </div>
    </div>

    <!-- 添加商品 -->
    <div id="add_goods" class="layui-form" style="display: none;">
        <div class="layer_div" style="margin-top: 30px; margin-left: 50px;">
            <div class="div_row">
                <div class="div_left">商品名称：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="name" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">商品价格：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="price" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">库存：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="stock" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">销量：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="sales" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">状态：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="status" value="">
                </div>
            </div>
        </div>
    </div>

    <!-- 修改商品信息 -->
    <div id="edit_goods" class="layui-form" style="display: none;">
        <div class="layer_div" style="margin-top: 30px; margin-left: 50px;">
            <div class="div_row">
                <div class="div_left">商品编号：</div>
                <div class="div_right">
                    <span id="goods_number"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">商品名称：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="goods_name" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">价格：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="goods_price" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">库存：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="goods_stock" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">销量：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="goods_sales" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">状态：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="goods_status" value="">
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
        table.render({
            elem: '#data_table'
            ,id: 'data_table'
            ,method: 'post'
            ,url: '{:url("Goods/index")}'
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
                ,{field:'number', title: '商品编号', align: 'center',width: '20%'}
                ,{field:'price', title: '价格', align: 'center'}
                ,{field:'stock', title: '库存', align: 'center'}
                ,{field:'sales', title: '销量', align: 'center'}
                ,{field:'status_show', title: '状态', align: 'center'}
                ,{templet:'#operation', title: '操作', align: 'center'}
            ]]
        });

        table.on('tool(data_table)', function (obj) {
            var row_data = obj.data;
            var id = row_data.id;
            if(obj.event == 'edit'){
                //修改
                layer.open({
                    type:1,
                    content:$('#edit_goods'),
                    area:['700px','400px'],
                    title:'修改商品信息',
                    btn:['保存','取消'],
                    yes:function(index){
                        var goods_name = $("#goods_name").val();
                        var goods_price = $("#goods_price").val();
                        var goods_stock = $("#goods_stock").val();
                        var goods_sales = $("#goods_sales").val();
                        var goods_status = $("#goods_status").val();
                        $.ajax({
                            url : '{:url("Goods/editGoods")}',
                            data: {
                                id:id,
                                name:goods_name,
                                price:goods_price,
                                stock:goods_stock,
                                sales:goods_sales,
                                status:goods_status
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
                        $("#goods_name").val(row_data.name);
                        $("#goods_price").val(row_data.price);
                        $("#goods_stock").val(row_data.stock);
                        $("#goods_sales").val(row_data.sales);
                        $("#goods_status").val(row_data.status);
                        $("#goods_number").html(row_data.number);
                    }
                })
            } else if(obj.event == 'del'){
                //删除
                layer.confirm('确定要删除该商品？', {
                    title: '删除商品',
                    btn: ['确认', '取消'] ,
                }, function(index){
                    $.ajax({
                        url : '{:url("Goods/delGoods")}',
                        data: {id:id},
                        type:'POST',
                        dataType:'JSON',
                        success:function (res) {
                            layer.closeAll();
                            if(res.code == 200){
                                layer.msg(res.message, { icon: 1, time: 1000 });
                                table.reload('data_table', {
                                    where: {},
                                });
                            } else {
                                layer.msg(res.message, { icon: 5, time: 1000 });
                            }
                        }
                    })
                });
            }
        });
        //添加
        $("#add_btn").click(function(){
            layer.open({
                type:1,
                content:$('#add_goods'),
                area:['700px','400px'],
                title:'添加',
                btn:['保存','取消'],
                yes:function(index){
                    var name = $("#name").val();
                    var price = $("#price").val();
                    var stock = $("#stock").val();
                    var sales = $("#sales").val();
                    var status = $("#status").val();
                    $.ajax({
                        url : '{:url("Goods/addGoods")}',
                        data: {
                            name:name,
                            price:price,
                            stock:stock,
                            sales:sales,
                            status:status,
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
                    $("#name").val('');
                    $("#price").val('');
                    $("#stock").val('');
                    $("#sales").val('');
                    $("#status").val('');
                }
            })
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