<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public $sex_list = [0=>'未知', 1=>'男', 2=>'女'];
    public $status_list = [0=>'未知', 1=>'正常', 2=>'删除'];

    public function index()
    {
        return view("user.index");
    }

    public function indexAjax(Request $request)
    {
        $page = $request->input('page',1);
        $limit = $request->input('limit',10);
        $first_row = (($page - 1) * $limit);

        $search = $request->input('search');
        $where = [];
        $where[] = ['id','>',0];
        if ($search) {
            $where[] = ['name|phone','like','%'.$search.'%'];
        }

        $where = [];
        $count = Db::table('user')->where($where)->count();
        $data = Db::table('user')->where($where)->offset($first_row)->limit($limit)->orderBy('id', 'asc')->select()->get();
//        foreach ($data as &$v) {
//            $v['sex_show'] = isset($this->sex_list[$v['sex']])?$this->sex_list[$v['sex']]:'未知';
//            $v['status_show'] = isset($this->status_list[$v['status']])?$this->status_list[$v['status']]:'未知';
//        }
//        return_ajax($data,0,'',$count);

        return json_encode(['data'=>$data,'code'=>0,'count'=>$count,'msg'=>'']);
    }

    public function object_to_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = $this->object_to_array($value);
            }
        }
        return $array;
    }
}
