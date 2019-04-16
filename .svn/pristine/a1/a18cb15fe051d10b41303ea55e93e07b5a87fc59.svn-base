<?php
/**
 * Created by PhpStorm.
 * User: 64989
 * Date: 2019/4/16
 * Time: 16:24
 */
namespace app\admin\controller;
use app\admin\common\controller\Base;

class Index extends Base
{
public function index()
{
    //判断用户是否登录
    $this->isLogin();
    return $this->fetch('user/userList');
}

}