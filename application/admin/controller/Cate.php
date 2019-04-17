<?php
/**
 * Created by PhpStorm.
 * User: 64989
 * Date: 2019/4/17
 * Time: 11:14
 */

namespace app\admin\controller;
use app\admin\common\controller\Base;
use app\admin\common\model\Cate as CateModel;
use think\facade\Request;
use think\facade\Session;

class Cate extends Base
{
public function index()
{
    //检查用户是否登录
    $this->isLogin();
    //登陆成功
    return $this->redirect('cateList');
}
public function cateList()
{
    $this->isLogin();
    $cateList = CateModel::all();
    $this->assign('title','分类管理');
    $this->assign('empty','<span style="color:red">没有分类</span>');
    $this->assign('cateList',$cateList);
    return $this->fetch();
}
public function cateEdit()
{
    $cateId = Request::param('id');
    $cateInfo = CateModel::where('id',$cateId)->find();
    $this->assign('title','编辑分类');
    $this->assign('cateInfo',$cateInfo);
    return $this->fetch();


}
public function doEdit()
{
    $data = Request::param();
    $id = $data['id'];
    unset($data['id']);
    if (CateModel::where('id',$id)->data($data)->update()){
        $this->success('更新成功','cateList');
    }else{
        $this->error('没有更新或者更新失败');
    }
}
public function doDelete()
{
    $cateId = Request::param('id');
    $cateDelete = CateModel::where('id',$cateId)->delete();
    if ($cateDelete){
        $this->success('删除成功','cateList');
    }else{
        $this->error('删除失败');
    }
}
public function cateAdd()
{
    $this->isLogin();
    $this->assign('title','添加栏目');
    return $this->fetch();
}
public function doAdd()
{
    $data = Request::param();
    $map[] = ['name','=',$data['name']];
    $map[] = ['sort','=',$data['sort']];
    $map[] = ['status','=',$data['status']];
    if (CateModel::create($data)){
        $this->success('添加成功','cateList');
    }else{
        $this->error('没有添加或者添加失败');
    }
}
}