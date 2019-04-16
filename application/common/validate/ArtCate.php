<?php
namespace app\common\validate;
use think\Validate;
class ArtCate extends Validate
{
    //经过分析,用户注册需要提供:用户名,邮箱,手机号和密码
    protected $rule = [
        'name|栏目名称'=> 'require|length:3,20|chsAlpha',

    ];





}