<?php
namespace app\common\model;
use think\Model;

use traits\model\SoftDelete;


class Article extends Model
{
    protected $pk = 'id';//默认主键
    protected $table = 'zh_article';

    protected $autoWriteTimestamp = true;//自动时间戳
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    protected $dateFormat = 'Y年m月d日';

//开启自动完成设置
protected $auto = [];
//仅仅新增有效
protected $insert = ['create_time','status'=>1,'is_top'=>0,'is_hot'=>0];
//仅更新
protected $update = ['update_time'];



}