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
use app\admin\common\model\Site;
use think\facade\Request;
use app\admin\common\model\Article;

class Base extends Controller
{
   protected function initialize()
   {
       //显示分类导航
       $this->showNav();
       $this->is_open();
       $this->getHotArt();

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
    public function is_open()
    {
        //获取站点状态
        $isOpen = Site::where('status',1)->value('is_open');
        if ($isOpen==0 && Request::module()=='index') {
            //或者写上:此域名出售
            $info = <<<'INFO'
            <body style="background-color:#333">
            <h1 style="color:#eee;text-align:center;margin:200px">站点维护中...</h1>
            </body>
INFO;
            exit($info);
        }
        }
        public function is_reg()
        {
            $isReg = Site::where('status',1)->value('is_reg');
            if ($isReg == 0){
                $this->error('注册关闭','index/index/insert');
            }
        }
        public function getHotArt()
        {
            $hotArtList = Article::where('status',1)->order('pv','desc')->limit(12)->select();
            $this->assign('hotArtList',$hotArtList);
        }


}