<?php
use think\Db;
//根据用户主键id查询用户名称
if (!function_exists('getUserName')){
    function getUserName($id)
    {
        return Db::table('zh_user')->where('id',$id) ->value('name');
    }
}
//过滤文章再要
function getArtContent($content)
{
    return mb_substr(strip_tags($content),0,10).'...';
}
if (!function_exists('getCateName')){
    function getCateName($cateId)
    {
        return Db::table('zh_article_category')->where('id',$cateId) ->value('name');
    }
}
//if (!function_exists('getUserLike')){
//    function getUserLike($id)
//    {
//        return Db::table('zh_user_like')->where('id',$id) ->value('content');
//    }
