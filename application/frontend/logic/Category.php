<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\frontend\logic;
use \tpfcore\util\Tree;
use \tpfcore\util\Data;
use \tpfcore\Core;
/**
 *  分类逻辑
 */
class Category extends FrontendBase
{
	public $ids=[];
	public function getCategory($where){
		return self::getObject($where,"id,url,title");
	}
	public function getChildIds($parentid){
		$list=self::getObject(['parentid'=>$parentid]);
		foreach ($list as $key => $value) {
			$this->ids[]=$value['id'];
			$this->getChildIds($value['id']);
		}
		return $this->ids;
	}
	public function getChilds(){
		return \think\Db::query("SELECT b.id,b.title,count(a.cateid) as num FROM ".DB_PREFIX."posts as a  RIGHT JOIN ".DB_PREFIX."category as b ON a.cateid=b.id WHERE b.parentid=1 GROUP BY b.id");
	}
}