<?php
/**
 * Created by PhpStorm.
 * User: 64989
 * Date: 2019/4/16
 * Time: 16:48
 */

namespace app\admin\controller;
use app\admin\common\controller\Base;
use app\admin\common\model\User as UserModel;
use think\facade\Request;
use think\facade\Session;

class User extends Base
{
    private $password = '';  //临时存放用户密码
   public function login()
   {
       $this->assign('title','管理员登录');
       return  $this->fetch();
   }
   public function checkLogin()
   {
       $data = Request::param();
       $map[] = ['email','=',$data['email']];
       $map[] = ['password','=',sha1($data['password'])];
       $result = UserModel::where($map)->find();
       if ($result){
           Session::set('user_id',$result['id']);
           Session::set('user_name',$result['name']);
           Session::set('is_admin',$result['is_admin']);
           $this->success('登录成功','admin/user/userList');
       }else{
           $this->error('邮箱或密码错误请重新登录','admin/user/login');
       }

   }
   public function logout()
   {
       Session::clear();
       $this->success('退出成功','admin/user/login');
   }
    public function userList()
    {
        //获取用户id
        $data['user_id'] = Session::get('user_id');
        $data['is_admin'] = Session::get('is_admin');
        //获取用户信息
        $userList = UserModel::where('id',$data['user_id'])->select();
        //如果是超级管理员获取全部信息
        if ($data['is_admin']==1){
            $userList = UserModel::select();
        }
        $this->assign('title','用户列表');
        $this->assign('empty','<span style="color:red">没有任何数据</span>');
        $this->assign('userList',$userList);
        return $this->fetch();
    }
    public function userEdit()
    {
        //获取主键
        $userId = Request::param('id');
        $userInfo = UserModel::where('id',$userId)->find();
        $this->password = $userInfo['password'];
        $this->assign('title','用户编辑');
        $this->assign('userInfo',$userInfo);
        return $this->fetch();
    }
    public function doEdit()
    {
        $date = Request::param();

        $id = $date['id'];
        //2.将用户密码加密后再写回
        if ($date['password'] == $this->password) {
            unset($date['password']);
        } else {
            $date['password'] = sha1($date['password']);
        }
        unset($date['id']);
        $res = UserModel::where('id',$id)->data($date)->update();
        if ($res){
            $this->success('更新成功','userList');
        }else{
            $this->error('没有更新或更新失败');
        }
       

    }
}