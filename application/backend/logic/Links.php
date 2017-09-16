<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\logic;

/**
 *  友情链接逻辑
 */
class Links extends AdminBase
{
	public function saveLinks($data){
		$validate=\think\Loader::validate($this->name);
		$validate_result = $validate->scene('add')->check($data);
        if (!$validate_result) {    
            return [RESULT_ERROR, $validate->getError(), null];
        }
		$last_id=self::saveObject($data);
		if($last_id){
        	return [RESULT_SUCCESS, '操作成功', url('links/index')];
        }
	}
	public function delLinks($data){
		return self::deleteObject($data,true)?[RESULT_SUCCESS, '删除成功', url('links/index')]:[RESULT_ERROR, '删除失败', url('links/index')];
	}
	public function getLinksList($where = [], $field = true, $order = '', $is_paginate = true){
		$paginate_data = $is_paginate ? ['rows' => DB_LIST_ROWS] : false;
		return self::getObject($where, $field, $order, $paginate_data);
	}
}