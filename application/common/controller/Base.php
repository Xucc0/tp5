<?php
/**
 * Created by PhpStorm.
 * User: 64989
 * Date: 2019/4/10
 * Time: 13:57
 */

namespace app\common\controller;
use think\Controller;
use think\facade\Session;
use app\common\model\ArtCate;
class Base extends Controller
{
   protected function initialize()
   {
       //显示分类导航
       $this->showNav();
   }
   //防止重复登录
    public function logined()
    {
        if (Session::has('user_id')){
           $this->error('你已经登录了','index/index');
       }
    }
    //检查用户是否登录
    public function isLogin()
    {
        if (!Session::has('user_id')){
            $this->error('你没有登录','user/login');
        }
    }
    //显示分类导航
    protected function showNav()
    {
        //查询分类表
        $cateList = ArtCate::all(function ($query){
            $query->where('status',1)->order('sort','asc');
        });
        //将分类赋值模板
        $this->assign('cateList',$cateList);
    }

}