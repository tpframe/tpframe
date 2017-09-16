<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\frontend\logic;
use \tpfcore\util\Tree;
use \tpfcore\util\Data;
use \tpfcore\Core;
/**
 *  导航逻辑
 */
class Nav extends FrontendBase
{
	public function getNav(){
		$listNav=self::getObject(['cid'=>1,"display"=>1],"id,href,label,target");
		$nav_arr=[];
		foreach ($listNav as $key => $value) {
			$nav_arr[$key]['id']=$value['id'];
			$nav_arr[$key]['label']=$value['label'];
			$nav_arr[$key]['href']=$value['href'];
			$nav_arr[$key]['target']=$value['target'];
		}

		$categor_arr=[];
		$listCategory=Core::loadModel("Category",'','logic')->getCategory(['isnav'=>1]);
		foreach ($listCategory as $key => $value) {
			$categor_arr[$key]['id']=$value['id'];
			$categor_arr[$key]['label']=$value['title'];
			$categor_arr[$key]['href']=$value['url'];
			$categor_arr[$key]['target']="_self";
		}
		$navs=array_merge($nav_arr,$categor_arr);
		return $navs;
	}
}