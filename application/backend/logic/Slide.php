<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace app\backend\logic;
use \tpfcore\Core;
/**
 *  轮播分类逻辑
 */
class Slide extends AdminBase
{
	public function getSlideList($where = [],$field = true, $order = '', $is_paginate = true){
	    $paginate_data = $is_paginate ? ['rows' => DB_LIST_ROWS] : false;
	    return self::getObject($where ,$field, $order, $paginate_data);
	}
	public function addSlide($data){
	    
// 	    $validate=\think\Loader::validate($this->name);
// 	    $validate_result = $validate->scene('add')->check($data);
// 	    if (!$validate_result) {
// 	        return [RESULT_ERROR, $validate->getError(), null];
// 	    }
	    $last_id=self::addObject($data);
	    if($last_id){
	        return [RESULT_SUCCESS, '添加成功', url('Slide/index')];
	    }
	}
    public function delSlide($data){
		return self::deleteObject($data,true)?[RESULT_SUCCESS, '删除成功', url('Slide/index')]:[RESULT_ERROR, '删除失败', url('Slide/index')];
	}
	public function editSlide($data){
/*	    $validate=\think\Loader::validate($this->name);
	    $validate_result = $validate->scene('add')->check($data);
	    if (!$validate_result) {
	        return [RESULT_ERROR, $validate->getError(), null];
	    }*/
	    $last_id=self::saveObject($data);
	    if($last_id){
	        return [RESULT_SUCCESS, '修改成功', url('Slide/index')];
	    }else{
	        return [RESULT_ERROR,'未做如何修改', url('Slide/index') ];
	    }
	}
}
?>