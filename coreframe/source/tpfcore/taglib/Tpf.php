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
        'friendlink' => ['attr' => 'num,key,id'],
    ];
    /**
     * 友情链接数据调用
     * num:获取记录数量
     * key:序号
     * id:循环中定义的元素变量
     * {tpf:friendlink num='6'}{/tpf:friendlink} 
     */
    public function tagFriendlink($tag, $content){
        $id     = isset($tag['id'])?$tag['id']:'vo';
        $num    = isset($tag['num'])?(int)$tag['num']:1;
        $key    = isset($tag['key'])?$tag['key']:'key';
        $parse  = '<?php ';
        $parse .= '$tpfTagFriendlink =  Core::loadModel("Links")->getLinks(["limit"=>'.$num.']); ';
        $parse .= 'foreach($tpfTagFriendlink as $'.$key.'=>$'.$id.'){';
        $parse .= '?>';
        $parse .= $content;
        $parse .= '<?php } ?>';
        return $parse;
    }
}
