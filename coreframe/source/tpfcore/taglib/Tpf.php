<?php
/**
 * ============================================================================
 * 版权所有 2017-2077 tpframe工作室，并保留所有权利。
 * @link http://www.tpframe.com/
 * @author    yaosean <510974211>
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！未经本公司授权您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * tpf标签主类
 */
namespace tpfcore\taglib;
use think\template\TagLib;
use tpfcore\Core;
class Tpf extends Taglib
{

    // 标签定义
    protected $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次  expression 是否允许表达式
        'friendlink'    => ['attr' => 'num,key,id,order'],
        'slide'         => ['attr' => 'num,key,id,order,where'],
        'posts'         => ['attr' => 'num,key,id,order,where,limit'],
    ];
    /**
     * 友情链接数据调用
     * num:获取记录数量
     * key:序号
     * id:循环中定义的元素变量
     * sort:排序方式
     * {tpf:friendlink num='6'}{/tpf:friendlink} 
     */
    public function tagFriendlink($tag, $content){
        $id     = isset($tag['id'])?$tag['id']:'vo';
        $num    = isset($tag['num'])?(int)$tag['num']:1;
        $key    = isset($tag['key'])?$tag['key']:'key';
        $order  = isset($tag['order'])?$tag['order']:'sort ASC';
        $parse  = '<?php ';
        $parse .= '$tpflist =  Core::loadModel("FriendLink")->getFriendLink(["where"=>["status"=>1],"order"=>"'.$order.'","limit"=>'.$num.']); ';
        $parse .= 'foreach($tpflist as $'.$key.'=>$'.$id.'){';
        $parse .= '?>';
        $parse .= $content;
        $parse .= '<?php } ?>';

        return $parse;
    }
    /**
     * 幻灯片/广告位数据调用
     * num:获取记录数量
     * key:序号
     * id:循环中定义的元素变量
     * sort:排序方式
     * where:查询条件
     * {tpf:slide num='1'}{/tpf:slide} 
     */
    public function tagSlide($tag, $content){
        $id     = isset($tag['id']) && $tag['id']?$tag['id']:'vo';
        $num    = isset($tag['num']) && $tag['num']?(int)$tag['num']:1;
        $key    = isset($tag['key']) && $tag['key']?$tag['key']:'key';
        $order  = isset($tag['order']) && $tag['order']?$tag['order']:'listorder ASC';
        $where  = isset($tag['where']) && $tag['where']?$tag['where']:'1=1';
        $parse  = '<?php ';
        $parse .= '$tpflist =  Core::loadModel("Slide")->getTpfSlide(["where"=>"slide_status=1 AND '.$where.'","join"=>["join" => "__SLIDE_CAT__ b", "condition" => "__SLIDE__.slide_cid=b.cid", "type" => "LEFT"],"order"=>"'.$order.'","field"=>"slide_id,slide_name,slide_pic,slide_url,slide_des,cat_name","limit"=>'.$num.']); ';
        $parse .= 'foreach($tpflist as $'.$key.'=>$'.$id.'){';
        $parse .= '?>';
        $parse .= $content;
        $parse .= '<?php } ?>';

        return $parse;
    }
    /**
     * 帖子数据调用
     * num:获取记录数量
     * key:序号
     * id:循环中定义的元素变量
     * sort:排序方式
     * where:查询条件
     * limit:分页显示，每页显示多少条
     * {tpf:posts num='1'}{/tpf:posts} 
     */
    public function tagPosts($tag, $content){
        $id     = isset($tag['id']) && $tag['id']?$tag['id']:'vo';
        $num    = isset($tag['num']) && $tag['num']?(int)$tag['num']:1;
        $key    = isset($tag['key']) && $tag['key']?$tag['key']:'key';
        $order  = isset($tag['order']) && $tag['order']?$tag['order']:'datetime ASC';
        $where  = isset($tag['where']) && $tag['where']?$tag['where']:'1=1';
        $rows=isset($tag['limit']) && is_numeric($tag['limit'])?$tag['limit']:0;
        $parse  = '<?php ';
        $parse .= '$tpflist =  Core::loadModel("Posts")->getTpfPosts(["where"=>"isdelete=0 AND ischeck=1 AND '.$where.'","join"=>["join" => "__USER__ b", "condition" => "__POSTS__.cateid=b.id", "type" => "LEFT"],"order"=>"'.$order.'","field"=>"__POSTS__.id,title,datetime,thumb,source,author,view,reply,likes,iscomment,istop,isrecommend,cateid,uid,b.nickname","limit"=>'.$num.',"paginate"=>["rows"=>'.$rows.']]); ';
        $parse .= 'foreach($tpflist as $'.$key.'=>$'.$id.'){';
        $parse .= '?>';
        $parse .= $content;
        $parse .= '<?php } ?>';

        return $parse;
    }
}
