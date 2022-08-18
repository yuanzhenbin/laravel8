<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>用户管理</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <link rel="stylesheet" href="/static/css/common.css">
    <style>
    </style>
</head>
<body>
<div class="content">
    <table border="1" cellspacing="0" style="position: absolute; left: 10px; top: 10px; z-index: 999">
        <tr>
            <td>ID</td>
            <td>姓名</td>
            <td>电话</td>
            <td>性别</td>
            <td>状态</td>
            <td>操作</td>
        </tr>
        @foreach ($data as $k=>$v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->name}}</td>
            <td>{{$v->phone}}</td>
            <td>{{$v->sex_show}}</td>
            <td>{{$v->status_show}}</td>
            <td>
                <!--<a href="">修改</a>|-->
                <!--<a href="">删除</a>-->
            </td>
        </tr>
        @endforeach
    </table>

    <div style="width: 100%;">
        <div class="top_row">
            <a style="float: left" href="{{url('Admin/index')}}" class="orange_button">返回首页</a>
            {{--<span style="float: left" class="blue_button" id="check_btn">验证器</span>--}}
            <span style="float: right" class="blue_button" id="add_btn">添加用户</span>
            <span style="float: right;" class="grey_button" id="search_btn">搜索</span>
            <input type="text" id="search" style="float: right; height: 28px; margin-right: 5px;" placeholder="账号/电话">
        </div>
        <div>
            <table class="layui-hide" id="data_table" lay-filter="data_table"></table>
        </div>
    </div>

    <!-- 添加用户 -->
    <div id="add_user" class="layui-form" style="display: none;">
        <div class="layer_div" style="margin-top: 30px; margin-left: 50px;">
            <div class="div_row">
                <div class="div_left">账号：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="account" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">姓名：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="name" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">电话：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="phone" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">邮箱：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="email" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">性别：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="sex" value="">
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

    <!-- 修改用户信息 -->
    <div id="edit_user" class="layui-form" style="display: none;">
        <div class="layer_div" style="margin-top: 30px; margin-left: 50px;">
            <div class="div_row">
                <div class="div_left">账号：</div>
                <div class="div_right">
                    <span id="user_account"></span>
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">姓名：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="user_name" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">电话：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="user_phone" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">邮箱：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="user_email" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">性别：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="user_sex" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">状态：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="user_status" value="">
                </div>
            </div>
        </div>
    </div>

    <!-- 验证器 -->
    <div id="check_user" class="layui-form" style="display: none;">
        <div class="layer_div" style="margin-top: 30px; margin-left: 50px;">
            <div class="div_row">
                <div class="div_left">姓名：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="check_name" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">电话：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="check_phone" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">邮箱：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="check_email" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">性别：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="check_sex" value="">
                </div>
            </div>
            <div class="div_row">
                <div class="div_left">状态：</div>
                <div class="div_right">
                    <input type="text" autocomplete="off" id="check_status" value="">
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
            ,url: '{{url("User/index")}}'
            ,cellMinWidth: 120
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
                ,{field:'account', title: '账号', align: 'center'}
                ,{field:'name', title: '用户名', align: 'center'}
                ,{field:'phone', title: '电话', align: 'center'}
                ,{field:'email', title: '邮箱', align: 'center'}
                ,{field:'sex_show', title: '性别', align: 'center'}
                ,{field:'status_show', title: '城市', align: 'center'}
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
                    content:$('#edit_user'),
                    area:['700px','400px'],
                    title:'修改用户信息',
                    btn:['保存','取消'],
                    yes:function(index){
                        var user_name = $("#user_name").val();
                        var user_phone = $("#user_phone").val();
                        var user_email = $("#user_email").val();
                        var user_sex = $("#user_sex").val();
                        var user_status = $("#user_status").val();
                        $.ajax({
                            url : '{{url("User/editUser")}}',
                            data: {
                                id:id,
                                name:user_name,
                                phone:user_phone,
                                email:user_email,
                                sex:user_sex,
                                status:user_status
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
                        $("#user_name").val(row_data.name);
                        $("#user_phone").val(row_data.phone);
                        $("#user_email").val(row_data.email);
                        $("#user_sex").val(row_data.sex);
                        $("#user_status").val(row_data.status);
                        $("#user_account").html(row_data.account);
                    }
                })
            } else if(obj.event == 'del'){
                //删除
                layer.confirm('确定要删除该用户？', {
                    title: '删除用户',
                    btn: ['确认', '取消'] ,
                }, function(index){
                    $.ajax({
                        url : '{{url("User/delUser")}}',
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
                content:$('#add_user'),
                area:['700px','400px'],
                title:'添加',
                btn:['保存','取消'],
                yes:function(index){
                    var name = $("#name").val();
                    var phone = $("#phone").val();
                    var email = $("#email").val();
                    var sex = $("#sex").val();
                    var status = $("#status").val();
                    var account = $("#account").val();
                    $.ajax({
                        url : '{{url("User/addUser")}}',
                        data: {
                            name:name,
                            phone:phone,
                            email:email,
                            sex:sex,
                            status:status,
                            account:account,
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
                    $("#phone").val('');
                    $("#email").val('');
                    $("#sex").val('');
                    $("#status").val('');
                    $("#account").val('');
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
        //验证器测试
        $("#check_btn").click(function(){
            layer.open({
                type:1,
                content:$('#check_user'),
                area:['700px','400px'],
                title:'添加',
                btn:['保存','取消'],
                yes:function(index){
                    var name = $("#check_name").val();
                    var phone = $("#check_phone").val();
                    var email = $("#check_email").val();
                    var sex = $("#check_sex").val();
                    var status = $("#check_status").val();
                    $.ajax({
                        url : '{{url("User/check")}}',
                        data: {
                            name:name,
                            phone:phone,
                            email:email,
                            sex:sex,
                            status:status
                        },
                        type:'POST',
                        dataType:'JSON',
                        success:function (res) {
                            if(res.code == 200){
                                layer.msg(res.message, { icon: 1, time: 1000 });
                                table.reload('data_table', {
                                    where: {},
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
                },
                btn2:function(index){
                    layer.closeAll();
                },
                success:function(){

                }
            })
        })
    });
</script>


</html>