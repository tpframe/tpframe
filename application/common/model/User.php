<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
/**
 * ============================================================================
 * 版权所有 2017-2077 tpframe工作室，并保留所有权利。
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！未经本公司授权您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 用户模型
 */
namespace app\common\model;

class User extends ModelBase
{
	protected $insert = ['create_time']; 	//插件的时候自动写入注册时间
	protected $update = ['login_time']; //更新的时候自动更新登录时间
    
    protected function setCreateTimeeAttr($value)
    {
    	return time();
    }
    protected function setLoginTimeAttr($value)
    {
        return time();
    }
    protected function setPasswordAttr($value){
    	return "###".$value;
    }
}
?>