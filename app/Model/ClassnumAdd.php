<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ClassnumAdd extends Model
{
	//    1. 关联的数据表
    public $table = 'classnum_add';

//    2. 主键
    public $primaryKey = 'jid';

//    3. 允许批量操作的字段

//    public $fillable = ['user_name','user_pass','email','phone'];
    public $guarded = [];//表示所有字段

//    4. 是否维护crated_at 和 updated_at字段

    public $timestamps = false;
}
