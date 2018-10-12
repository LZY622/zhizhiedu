<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Adminuser extends Model
{
    //    1. 关联的数据表
    public $table = 'admin_users';

//    2. 主键
    public $primaryKey = 'id';

//    3. 允许批量操作的字段

    public $guarded = [];//表示所有字段

//    4. 是否维护crated_at 和 updated_at字段

    public $timestamps = false;
}
