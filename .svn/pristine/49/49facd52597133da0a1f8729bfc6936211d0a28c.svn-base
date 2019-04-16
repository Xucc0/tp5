<?php
/**
 * Created by PhpStorm.
 * User: 64989
 * Date: 2019/4/16
 * Time: 16:33
 */
namespace app\admin\common\controller;
use think\Controller;
use think\facade\Session;

class Base  extends Controller
{
    public function initialize()
    {

    }
    //检查用户是否登录
    public function isLogin()
    {
        if (!Session::has('admin_id')){
            $this->error('请先登录','admin/user/login');
        }
    }
}