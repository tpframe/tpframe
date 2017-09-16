<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\logic;
use \tpfcore\Core;
/**
 *  友情链接逻辑
 */
class Posts extends AdminBase
{
	public function savePosts($data){
		$validate=\think\Loader::validate($this->name);
		$validate_result = $validate->scene('add')->check($data);
        if (!$validate_result) {    
            return [RESULT_ERROR, $validate->getError(), null];
        }
		$last_id=Core::loadModel($this->name)->saveObject($data);
		if($last_id){
        	return [RESULT_SUCCESS, '操作成功', url('Posts/index')];
        }
	}
	public function delPosts($data){
		return self::saveObject(['isdelete'=>1],$data)?[RESULT_SUCCESS, '删除成功', url('Posts/index')]:[RESULT_ERROR, '删除失败', url('Posts/index')];
	}
	public function getPostsList($where = [], $field = true, $order = '', $is_paginate = true){
		$paginate_data = $is_paginate ? ['rows' => DB_LIST_ROWS] : false;
		return self::getObject($where, $field, $order, $paginate_data);
	}
}