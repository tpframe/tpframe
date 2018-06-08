<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace app\backend\logic;
use \tpfcore\Core;
/**
 *  管理员角色
 */
class Role extends AdminBase
{
    public function getRoleList($where = [],$field = true, $order = '', $is_paginate = true){
        $paginate_data = $is_paginate ? ['rows' => DB_LIST_ROWS] : false;
	    return self::getObject($where ,$field, $order, $paginate_data);
    }
    public function addRole($data){
        $last_id=Core::loadModel($this->name)->saveObject($data);
        if($last_id){
            return [RESULT_SUCCESS, '操作成功', url('Role/index')];
        }else{
            return [RESULT_ERROR, '操作失败', url('Role/index')];
        }
    }
    public function del($data){
        $result=self::deleteObject($data,true);
        if($result){
            return [RESULT_SUCCESS, '操作成功', url('Role/index')];
        }else{
            return [RESULT_ERROR, '操作失败', url('Role/index')];
        }
    }
    public function getRole(){
        return self::getObject();
    }
}
?>