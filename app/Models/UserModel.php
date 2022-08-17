<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    //表名
    protected $table = 'user';

    //主键 默认id
    protected $primaryKey = 'id';

    public function getOne($where)
    {
        return $this->where($where)->first();
    }

    public function add($data)
    {
        return $this->insert($data);
    }
}
