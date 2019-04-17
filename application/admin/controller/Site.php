<?php
/**
 * Created by PhpStorm.
 * User: 64989
 * Date: 2019/4/17
 * Time: 15:25
 */

namespace app\admin\controller;
use app\admin\common\controller\Base;
use app\admin\common\model\Site as SiteModel;
use think\Db;
use think\facade\Request;
use think\facade\Session;
class Site extends Base
{
    //站点管理首页
 public function index()
 {
     $siteInfo = SiteModel::get(['status'=>1]);
     $this->assign('siteInfo',$siteInfo);
     return $this->fetch();
 }
 public function save()
 {
     $data = Request::param();
     if (SiteModel::update($data)){
         $this->success('更新成功','index');
     }else{
         $this->error('更新失败');
     }

 }

}