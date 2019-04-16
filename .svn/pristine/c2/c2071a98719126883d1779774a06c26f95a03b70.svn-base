<?php
namespace app\index\validate;
use think\Validate;
class User extends Validate
{
  protected $rule = [
      'name|用户名' => 'require',
      'email|邮箱' => 'email',
      'password|密码' => 'require|between:6,12'



  ];
  protected  $message = [
      'name.require' => '用户名不能为空',
      'email.email' => '邮箱格式错误',
      'password.require' => '密码不能为空',
      'password.between' => '密码字符在6-12位之间'
  ];








}