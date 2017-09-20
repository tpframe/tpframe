<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace app\backend\logic;
use \tpfcore\Core;
/**
 *  广告逻辑
 */
class Ad extends AdminBase
{
    public function getAdList($where = [],$field = true, $order = '', $is_paginate = true){
        $paginate_data = $is_paginate ? ['rows' => DB_LIST_ROWS] : false;
	    return self::getObject($where ,$field, $order, $paginate_data);
    }
    public function addAd($data){
        $last_id=self::saveObject($data);
        if($last_id){
            return [RESULT_SUCCESS, '添加成功', url('Ad/index')];
        }else{
            return [RESULT_ERROR, '操作失败', url('Ad/index')];
        }
    }
    public function editAd($data){
        $last_id=self::saveObject($data);
        if($last_id){
            return [RESULT_SUCCESS, '操作成功', url('Ad/index')];
        }else{
            return [RESULT_ERROR, '操作失败', url('Ad/index')];
        }
    }
    public function del($data){
        $result=self::deleteObject($data,true);
        if($result){
            return [RESULT_SUCCESS, '操作成功', url('Ad/index')];
        }else{
            return [RESULT_ERROR, '操作失败', url('Ad/index')];
        }
    }
}
?>