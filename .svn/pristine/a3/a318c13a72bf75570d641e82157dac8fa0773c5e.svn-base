<?php
namespace app\index\controller;
use app\common\controller\Base;
use app\common\model\ArtCate;
use app\common\model\Article;
use think\Db;
use think\facade\Request;
use think\facade\Cache;
use think\cache\driver\Redis;

class Index extends Base
{
    //首页方法

public function index()
{
    //全局查询条件
    $map = [];
    //条件1
    $map[]=['status', '=', 1];
    //实现搜索功能
    $keywords = Request::param('keywords');
    if (!empty($keywords)) {
        //条件2
        $map[] = ['title', 'like', '%' . $keywords . '%'];
    }
    //分类信息显示
    $cateId = Request::param('cate_id');
    if (isset($cateId)) {
        //条件3
        $map[] = ['cate_id','=', $cateId];
        $res = ArtCate::get($cateId);
        $artList = Db::table('zh_article')
            ->where($map)
//            ->where('cate_id', $cateId)
            ->order('create_time', 'desc')->paginate(3);
        $this->assign('artList', $artList);
        $this->assign('cateName', $res->name);
    } else {
        $this->assign('cateName', '全部文章');
        $artList = Db::table('zh_article')
            ->where($map)
            ->order('create_time', 'desc')->paginate(3);
        $this->assign('artList', $artList);
    }
    $this->assign('empty','<h3>没有文章</h3>>');
    return $this->fetch();
}

//添加文章界面
public function insert()
{
    //1.用户必须登录
    $this->isLogin();
    //2.设置页面标题
    $this->assign('title','发布文章');
    //3.获取栏目信息
    $cateList = ArtCate::all();
    if (count($cateList)>0){
        $this->assign('cateList',$cateList);
    }else{
        $this->error('请先添加栏目','index/index');
    }
    //4.渲染发布界面
    return $this->fetch();
}
//保存文章
public function save()
{
    if (Request::isPost()){
        $data = Request::post();

        $rule = 'app\common\validate\Article';
        $res = $this->validate($data,$rule);
        if ($res!==true){
            echo '<script>alert("'.$res.'");location.back()</script>';
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
           //将数据写到数据表
//            halt($data);
            if (Article::create($data)){
                $this->success('文章发布成功','index/index');
            }else{
               $this->error('文章发送失败');
            }
        }

    }else{
        $this->error('请求类型错误','index/save');
    }

}
//详情页
public function detail()
{
    $artId = Request::param('id');
//    echo $artId['id'];exit;
    $art = Article::get(function ($query) use ($artId){
        $query->where('id','=',$artId)->setInc('pv');
});
    if (!is_null($art)){
        $this->assign('art',$art);
    }

    $like = Db::table('zh_user_like')->where('article_id','=',$artId)->value('content');

    if (!is_null($like)) {
         $this->assign('like', $like);
    }else{
         $this->assign('like', '0');
    }

    $this->assign('title','详情页');

    return $this->fetch();

}
//收藏
public function fav()
{
    if (!Request::isAjax()) {
     return ['status'=>-1,'message'=>'请求类型错误'];
    }
    //获取从前端通过来的数据
    $data = Request::param();
    //判断用户是否登录
    if (empty($data['session_id'])){
        return['status'=>-2,'message'=>'请登录后再收藏'];
    }
    //查询条件
    $map[]=['user_id','=',$data['user_id']];
    $map[]=['article_id','=',$data['article_id']];
    $fav = Db::table('zh_user_fav')->where($map)->find();
    if (is_null($fav)){
        Db::table('zh_user_fav')->data([
            'user_id'=>$data['user_id'],
            'article_id'=>$data['article_id'],
        ])->insert();
        return['status'=>1,'message'=>'收藏成功'];
    }else{
        Db::table('zh_user_fav')->where($map)->delete();
        return['status'=>0,'message'=>'已取消'];

    }
}
    public function ok()
    {
        if (!Request::isAjax()) {
            return ['status'=>-1,'message'=>'请求类型错误'];
        }
        //获取从前端通过来的数据
        $data = Request::param();

        //查询条件
        $map[]=['user_id','=',$data['user_id']];
        $map[]=['article_id','=',$data['article_id']];
        $fav = Db::table('zh_user_like')->where($map)->find();
        if (is_null($fav)){
            Db::table('zh_user_like')->data([
                'user_id'=>$data['user_id'],
                'article_id'=>$data['article_id'],
            ])->insert();
            Db::table('zh_user_like')->where($map)->setInc('content',1);
//            if (!is_null($like)){
//                return $this->assign('like',$like);
//            }
            return['status'=>1,'message'=>'点赞成功'];
        }else{
            Db::table('zh_user_like')->where($map)->delete();
            return['status'=>0,'message'=>'已取消'];

        }

    }
}
