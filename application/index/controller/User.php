<?php
namespace app\index\controller;
use app\common\controller\Base;
use think\facade\Request;
use app\common\model\User as UserModel;

use think\facade\Session;

class User extends Base
{
    public function register()
    {
        $this->is_reg();
        $this->assign('title', '用户注册');
        return $this->fetch();
    }

    public function  insert()
    {	//前端提交的必须是Ajax请求再进行验证与新增操作
        if(Request::isAjax()){
            //1.数据验证
            $data = Request::post();  //要验证的数据
            $rule = 'app\common\validate\User';  //自定义的验证器

            //开始验证: $res 中保存错误信息,成功返回true
            $res=$this->validate($data,$rule);
            if (true !== $res){  //验证失败
                return ['status'=> -1, 'message'=>$res];
            }else { //验证成功
                //2. 将数据写入到数据表zh_user中,并对写入结果进行判断
                if($user=UserModel::create($data)){
                    //注册成功后,实现自动登录
                   $courentUser = UserModel::get($user->id);
                   Session::set('user_id',$courentUser->id);
                   Session::set('user_name',$courentUser->name);
                   Session::set('is_admin',$courentUser->is_admin);

                    return ['status'=>1, 'message'=>'恭喜,注册成功~~'];
                } else {
                    return ['status'=>0, 'message'=>'注册失败~~'];
                }
            }
        }else{
            $this->error('请求类型错误','register');
        }
    }
    //用户登录
    public function login()
    {
        $this->logined();
        return $this->fetch('login',['title'=>'用户登录']);
    }

    //用户登录验证与查询
    public function loginCheck()
    {
        if(Request::isAjax()){
            //1.数据验证
            $data = Request::post();  //要验证的数据
            $rule = [
                'email|邮箱'=>'require|email',
                'password|密码'=>'require|alphaNum'
            ];  //自定义的验证器

            //开始验证: $res 中保存错误信息,成功返回true
            $res=$this->validate($data,$rule);
            if (true !== $res){  //验证失败
                return ['status'=> -1, 'message'=>$res];
            }else { //验证成功
                 $result = UserModel::get(function ($query) use ($data){
                     $query->where('email',$data['email'])
                         ->where('password',sha1($data['password']));
                 });

                if($result == null){
                    return ['status'=>0, 'message'=>'密码或邮箱不正确请检查~~'];
                } else {
                    //将用户写入session
                   Session::set('user_id',$result->id);
                   Session::set('user_name',$result->name);
                    return ['status'=>1, 'message'=>'登录成功~~'];

                }
            }
        }else{
            $this->error('请求类型错误','');
        }
    }
    public function logout()
    {
        //第一种删除session
//        Session::delete('user_id');
//        Session::delete('user_name');
        //第二种删除session
        Session::clear();
        $this->success('退出登录成功','index/index');

    }
}
