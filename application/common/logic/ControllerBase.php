<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\common\logic;
use \tpfcore\Core;
use think\Validate;
use think\Db;
/**
 * Admin基础逻辑
 */
class ControllerBase extends LogicBase
{
	/*
		传递的数据必须要有下面的一些值 ，不然就不通过
		$table 	表名
		$colum  列名
		$columval  列值
		$key 主键名
		$keyval  主键值
	*/
	public function ajaxdata($data){
		$validate = new Validate(["table"=>"require","colum"=>"require","columval"=>"require","key"=>"require","keyval"=>"require|regex:\d+"]);
		if(!$validate->check($data)){
		    return [-4,$validate->getError(),null];
		}
		extract($data);
		$result=Db::name($table)->update([$key=>$keyval,$colum=>$columval]);
		if($result){
			return [1, '操作成功',null];
		}
		return [0, '操作失败',null];
	}
}