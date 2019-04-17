<?php
/**
 * Created by PhpStorm.
 * User: 64989
 * Date: 2019/4/17
 * Time: 11:14
 */

namespace app\admin\controller;
use app\admin\common\controller\Base;
use app\admin\common\model\Article as ArtModel;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use app\admin\common\model\Cate;

class Article extends Base
{
    public function index()
    {
        //检查用户是否登录
        $this->isLogin();
        //登陆成功
        return $this->redirect('artList');
    }
    public function artList()
    {
        $this->isLogin();
        $userId = Session::get('user_id');
        $isAdmin = Session::get('is_admin');
        if ($isAdmin==1){
            $artList = ArtModel::paginate(5);
        }else{
            $artList = ArtModel::where('user_id',$userId)->paginate(5);

        }
        $this->assign('title','文章管理');
        $this->assign('empty','<span style="color:red">没有文章</span>');
        $this->assign('artList',$artList);
        return $this->fetch();
    }
    public function artEdit()
    {
        $artId = Request::param('id');
        $artInfo = ArtModel::where('id',$artId)->find();$cateId = ArtModel::where('id',$artId)->value('cate_id');
        $cateList = Cate::all();
        $this->assign('title','编辑文章');
        $this->assign('artInfo',$artInfo);
        $this->assign('cateList',$cateList);
        return $this->fetch();


    }
    public function doEdit()
    {

            $data = Request::param();

            $rule = [
                'title|标题'=> 'require|length:5,20|chsAlphaNum',
                'content|文章内容'=>'require',
                'cate_id|栏目名称'=>'require',
            ];
            $res = $this->validate($data,$rule);
            if ($res!==true){
                echo '<script>alert("'.$res.'");location.href="article/artEdit"</script>';
            }else{
                //验证成功
                //上传的图片信息
                $file = Request::file('title_img');
                $info =  $file->validate([
                    'size'=>50000000,
                    'ext'=>'jpeg,jpg,gif,png',
                ])->move('uploads/');
                if ($info){
                    $data['title_img'] = $info->getSaveName();
                }else{
                    $this->error($file->getError());
                }

                if (ArtModel::update($data)){
                    $this->success('文章编辑成功','article/artList');
                }else{
                    $this->error('文章编辑失败');
                }
            }

    }
    public function doDelete()
    {
        $artId = Request::param('id');
        $artDelete = ArtModel::where('id',$artId)->delete();
        if ($artDelete){
            $this->success('删除成功','artList');
        }else{
            $this->error('删除失败');
        }
    }

}