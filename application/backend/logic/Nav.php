<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\logic;
use \tpfcore\util\Tree;
use \tpfcore\util\Data;
use \tpfcore\Core;
/**
 *  导航逻辑
 */
class Nav extends AdminBase
{
	private $arr=[];
	public function saveNav($data){
		$validate=\think\Loader::validate($this->name);
		$validate_result = $validate->scene('add')->check($data);
        if (!$validate_result) {    
            return [RESULT_ERROR, $validate->getError(), null];
        }
		$last_id=Core::loadModel($this->name)->saveObject($data);
		if($last_id){
        	return [RESULT_SUCCESS, '操作成功', url('Nav/index')];
        }
	}
	public function delNav($data){
		return self::deleteObject($data,true)?[RESULT_SUCCESS, '删除成功', url('Nav/index')]:[RESULT_ERROR, '删除失败', url('Nav/index')];
	}
	public function getNavListByid($data){
		return self::getOneObject($data);
	}
	public function getNavList($where=[]){
		$result=self::getObject($where,"*","sort ASC");
		$new_result=[];
		foreach ($result as $key => $value) {
			$new_result[$key]=$value->toArray();
		}
        $tree = new Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        
        foreach ($new_result as $n=> $r) {
        	$new_result[$n]['parentid_node'] = ($r['parentid']) ? ' class="child-of-node-' . $r['parentid'] . ' collapsed"' : 'class="expanded"';
        	$new_result[$n]['manage'] = '<a href="' . url("Nav/add", ["parentid" => $r['id']]) . '">添加菜单</a> | <a href="' . url("Nav/edit", ["id" => $r['id']]) . '">编辑菜单</a> | <a href="' . url("Nav/del", ["id" => $r['id']]). '" class="js-ajax-delete">删除菜单</a> ';
            $new_result[$n]['display'] = $r['display'] ? "显示" : "隐藏";
        }
       
        $tree->init($new_result);
        $action=url("Nav/ajaxdata");
        $str = "<tr id='node-\$id' \$parentid_node>
					<td style='padding-left:20px;'><span style='padding-left: 20px' class='expander'></span><input name='listorders[\$id]' type='text' size='3' value='\$sort' data='Nav|sort|id|\$id' class='input input-order ajax-text' action='$action'></td>
					<td>\$id</td>
					<td>\$spacer\$label</td>
				    <td>\$display</td>
					<td>\$manage</td>
				</tr>";
        $categorys = $tree->get_tree(0, $str);
		return $categorys;
	}
	public function getTreeNav($data=[]){
		$parentid=empty($data['id'])?(empty($data['parentid'])?-1:$data['parentid']):$data['id'];
		if(!empty($data['id'])){
			$list=$this->getNavListByid(['id'=>$data['id']]);
			$parentid=$list->parentid;
		}

		$result=self::getObject([],"*","sort ASC");
		$new_result=[];
		foreach ($result as $key => $value) {
			unset($result[0]);
			$new_result[$value['id']]=$value->toArray();
		}
		
        $tree = new Tree();
        $tree->init($new_result);
        $str = "<option value='\$id' \$selected>\$spacer \$label</option>";
        $categorys = $tree->get_tree(0, $str,$parentid);
		return $categorys;
	}
	public function getNavArrTree($where=[],$filter,$returnarr){
		$result=self::getObject($where,"*","sort ASC");
		foreach ($result as $key => $value) {
			$arr[$value['id']]=$value->toArray();
		}
		if($filter&&\think\Session::get("backend_author_sign")['userid']!=1){
			// 如果要进行权限过滤
			$privs=Core::loadModel("User")->getObject(['id'=>\think\Session::get("backend_author_sign")['userid']],"id,privs")[0]->toArray()['privs'];
			if($privs){
				$privs=explode(",", $privs);
				foreach ($arr as $key => $value) {
					if(!in_array($value['id'], $privs)){
						unset($arr[$key]);
					}
				}
			}else{
				$arr=[];
			}
		}
		return $returnarr?$arr:Data::toTreeArrray($arr);
	}
}