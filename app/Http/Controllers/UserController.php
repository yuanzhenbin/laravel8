<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UserModel;

class UserController extends BaseController
{
    public $sex_list = [0=>'未知', 1=>'男', 2=>'女'];
    public $status_list = [0=>'未知', 1=>'正常', 2=>'删除'];

    public function index(Request $request)
    {
        $page = 1;
        $limit = 10;
        $first_row = (($page - 1) * $limit);

        $data = Db::table('user')->offset($first_row)->limit($limit)->orderBy('id', 'desc')->get();
        foreach ($data as $k => $v) {
            $data[$k]->sex_show = isset($this->sex_list[$v->sex])?$this->sex_list[$v->sex]:'未知';
            $data[$k]->status_show = isset($this->status_list[$v->status])?$this->status_list[$v->status]:'未知';
        }

        return view("user.index",['data'=>$data]);
    }

    public function indexAjax(Request $request)
    {
        $page = $request->input('page',1);
        $limit = $request->input('limit',10);
        $first_row = (($page - 1) * $limit);

        $search = request('search');
        $where = [];
        $orWhere = [];
        $where[] = ['id','>',0];
        if ($search) {
            $orWhere = function($query) use ($search){
                $query->orwhere('name','like','%'.$search.'%')
                    ->orwhere('phone','like','%'.$search.'%');
            };
        }

        $where = [];
        $count = Db::table('user')->where($where)->orWhere($orWhere)->count();
        $data = Db::table('user')->where($where)->orWhere($orWhere)->offset($first_row)->limit($limit)->orderBy('id', 'asc')->get();

        foreach ($data as $k => $v) {
            $data[$k]->sex_show = isset($this->sex_list[$v->sex])?$this->sex_list[$v->sex]:'未知';
            $data[$k]->status_show = isset($this->status_list[$v->status])?$this->status_list[$v->status]:'未知';
        }
        return_ajax($data,0,'',$count);
    }

    public function addUser()
    {
        $account = request('account');
        if (!$account) {
            return_ajax([],0,'账号必填！');
        }
        $check = Db::table('user')->where('account',$account)->first();
        if ($check) {
            return_ajax([],0,'账号已存在！');
        }
        $add_data = [];
        $add_data['account'] = $account;
        $add_data['name'] = request('name','');
        $add_data['phone'] = request('phone','');
        $add_data['email'] = request('email','');
        $add_data['sex'] = request('sex',0);
        $add_data['status'] = request('status',1);
        $add_data['create_time'] = time();

        //不返回id 返回布尔值
        $ret = Db::table('user')->insert($add_data);
        //返回id
//        $ret = Db::table('user')->insertGetId($add_data);

//        $user = new UserModel();
//        $ret = $user->add($add_data);

        if ($ret !== false) {
            return_ajax([$ret],200,'添加成功');
        } else {
            return_ajax([],0,'添加失败');
        }
    }

    public function editUser()
    {
        $id = request('id');
        $name = request('name','');
        $phone = request('phone','');
        $email = request('email','');
        $sex = request('sex',0);
        $status = request('status',1);
        if(!$id) {
            return_ajax([],0,'缺少参数');
        }
        $ret = Db::table('user')
            ->where('id',$id)
            ->update(['name' => $name,'phone' => $phone,'email' => $email,'sex' => $sex,'status' => $status,'update_time'=>time()]);

        if ($ret !== false) {
            return_ajax([],200,'修改成功');
        } else {
            return_ajax([],0,'修改失败');
        }
    }

    public function delUser()
    {
        $id = request('id');
        //update效率比save高
        $ret = Db::table('user')->where('id',$id)->update(['status' => 2]);
//        $ret = Db::table('user')->where('id',$id)->delete();
        if ($ret !== false) {
            return_ajax([],200,'删除成功');
        } else {
            return_ajax([],0,'删除失败');
        }
    }

    //验证器测试
    public function check()
    {
//        $data = request()->param();
////        var_dump($data);die;
//        try {
//            validate(UserValidate::class)->check($data);
//            return_ajax([],200,'验证通过');
//        } catch (ValidateException $e) {
//            // 验证失败 输出错误信息
//            return_ajax([],0,$e->getError());
//        }
    }

    //个人中心
    public function info()
    {
        $where = [];
        $where[] = ['id',1];

        //以下两种效果一致
//        $info1 = DB::table('user')->find(1);
        $info = DB::table('user')->where($where)->first();

        $info->sex_show = isset($this->sex_list[$info->sex])?$this->sex_list[$info->sex]:'未知';
        $info->status_show = isset($this->status_list[$info->status])?$this->status_list[$info->status]:'未知';

        return view('user/info',['data'=>$info]);
    }
}
