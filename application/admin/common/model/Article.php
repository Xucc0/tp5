<?php
/**
 * Created by PhpStorm.
 * User: 64989
 * Date: 2019/4/17
 * Time: 12:35
 */


namespace app\admin\common\model;
use think\Model;

class Article extends Model
{
    protected $pk = 'id';
    protected $table = 'zh_article';
}