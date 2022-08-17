<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoginController extends BaseController
{
    public function index(Request $request)
    {
        //助手函数session()设置的时候需要以数组形式设置
        if($request->session()->get('uaccount')) {
            return redirect(url('Admin/index'));
        } else {
            return view('login/index');
        }
    }

    //登录
    public function login(Request $request)
    {
        $account = $request->input('account');
        $password = $request->input('password');
        if (!$account) {
            return_ajax([],0,'账号或密码错误！');
        }

        $uinfo = Db::table('user')->where('account',$account)->first();
        if (!$uinfo) {
            return_ajax([],0,'账号或密码错误！');
        }
//        var_dump(md5($password),$uinfo['password']);die;

        if ((!isset($uinfo->password) && !$password) || ($uinfo->password == md5($password.$uinfo->salt))) {
            session(['uid'=>$uinfo->id]);
            session(['uname'=>$uinfo->name]);
            //以下两种作用一致
            session(['uaccount'=>$uinfo->account]);
//            $request->session()->put('uaccount',$uinfo->account);
            $salt = rand(10000,99999);
            $password_salt = md5($password.$salt);

            //自动事务，无异常自动提交，异常自动回滚
//            DB::transaction(function() use($account,$password_salt,$salt) {
//                //保证密码和盐的一致性
//                Db::table('user')->where('account',$account)->update(['password'=>$password_salt,'salt'=>$salt]);
//            }, 3);
            //手动事务
            DB::beginTransaction();
            try{
                //保证密码和盐的一致性
                Db::table('user')->where('account',$account)->update(['password'=>$password_salt,'salt'=>$salt]);
                Db::commit();
            } catch (\Throwable $e){
                Db::rollBack();
                Db::table('log')->insert(['content'=>'自动更新密码失败|'.$e->getMessage(),'create_time'=>time()]);
            }

            echo json_encode(['data'=>[],'code'=>200,'message'=>'登录成功']);
        } else {
            echo json_encode(['data'=>[],'code'=>0,'message'=>'账号或密码错误！']);
        }
//        设置session之后不能使用die或exit,否则设置不成功 ？？
//        return_ajax([]);
    }

    //注册
    public function register()
    {

    }

    //退出
    public function logout(Request $request)
    {
        $request->session()->flush();
        echo json_encode(['data'=>[],'code'=>200,'message'=>'退出成功']);
    }
}
