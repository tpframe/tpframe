<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\common\logic;
use \tpfcore\util\Tree;
use \tpfcore\util\Data;
use \tpfcore\Core;
/**
 *  分类逻辑
 */
class Category extends LogicBase
{
	public $ids=[];
	public function getCategory($param=[]){
		return self::getList($param);
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
	public function getTreeCategory($data=[]){
		$parentid=empty($data['id'])?(empty($data['parentid'])?-1:$data['parentid']):$data['id'];
		if(!empty($data['cateid'])){
			$parentid=$data['cateid'];
		}
		$result=self::getObject(["display"=>1,"type"=>1],"*","sort ASC");
		$arr=[];
		foreach ($result as $key => $value) {
			$arr[$value['id']]=$value->toArray();
		}
        $tree = new Tree();
        $tree->init($arr);
        $str = "<option value='\$id' \$selected>\$spacer \$title</option>";
        $categorys = $tree->get_tree(0, $str,$parentid);
		return $categorys;
	}
}