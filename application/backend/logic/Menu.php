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
class Menu extends AdminBase
{
	private $parentids=[];
	private $arr=[];
	public function saveMenu($data){
		$validate=\think\Loader::validate($this->name);
		$validate_result = $validate->scene('add')->check($data);
        if (!$validate_result) {    
            return [RESULT_ERROR, $validate->getError(), null];
        }
		$last_id=Core::loadModel($this->name)->saveObject($data);
		if($last_id){
        	return [RESULT_SUCCESS, '操作成功', url('Menu/index')];
        }
	}
	public function delMenu($data){
		/*
			如下情况不能删除
			1、还有子菜单的时候
		*/
		$childs=self::getList(["where"=>['parentid'=>$data['id']]]);
		if(count($childs)>0){
			return [RESULT_ERROR , '删除失败，该分类下还有子分类', url("Menu/index")];
		}
		return self::deleteObject($data,true)?[RESULT_SUCCESS, '删除成功', url('Menu/index')]:[RESULT_ERROR, '删除失败', url('Menu/index')];
	}
	public function getMenuListByid($data){
		return self::getOneObject($data);
	}
	public function getMenuList(){
		$result=self::getObject([],"*","sort ASC");
		$new_result=[];
		foreach ($result as $key => $value) {
			$new_result[$key]=$value->toArray();
		}

        $tree = new Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

        foreach ($new_result as $n=> $r) {
        	$new_result[$n]['parentid_node'] = ($r['parentid']) ? ' class="child-of-node-' . $r['parentid'] . ' collapsed"' : 'class="expanded"';
            $new_result[$n]['manage'] = '<a href="' . url("Menu/add", ["parentid" => $r['id']]) . '">添加菜单</a> | <a href="' . url("Menu/edit", ["id" => $r['id']]) . '">编辑菜单</a> | <a href="' . url("Menu/del", ["id" => $r['id']]). '" class="js-ajax-delete">删除菜单</a> ';
            $new_result[$n]['display'] = $r['display'] ? "显示" : "隐藏";
            $new_result[$n]['app']=$r['module']."/".$r['controller']."/".$r['action'];
        }
        $tree->init($new_result);
        $action=url("Menu/ajaxdata");
        $str = "<tr id='node-\$id' \$parentid_node>
					<td style='padding-left:20px;'><span style='padding-left: 20px' class='expander'></span><input name='listorders[]' data='Menu|sort|id|\$id' type='text' size='3' value='\$sort' class='input input-order ajax-text' action='$action'></td>
					<td>\$id</td>
        			<td>\$app</td>
					<td>\$spacer\$name</td>
				    <td>\$display</td>
					<td>\$manage</td>
				</tr>";
        $categorys = $tree->get_tree(0, $str);
		return $categorys;
	}
	public function getTreeMenu($data=[]){
		$parentid=empty($data['id'])?(empty($data['parentid'])?-1:$data['parentid']):$data['id'];
		if(!empty($data['id'])){
			$list=$this->getMenuListByid(['id'=>$data['id']]);
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
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $categorys = $tree->get_tree(0, $str,$parentid);
		return $categorys;
	}
	public function getMenuArrTree($where=[],$filter,$returnarr){
		$result=self::getObject($where,"*","sort ASC,id ASC");
		foreach ($result as $key => $value) {
			$arr[$value['id']]=$value->toArray();
		}
		if($filter&&\think\Session::get("backend_author_sign")['userid']!=1){
			// 如果要进行权限过滤
			$privs=Core::loadModel("User","backend","logic")->getObject(['id'=>\think\Session::get("backend_author_sign")['userid']],"id,privs")[0]->toArray()['privs'];
			if($privs){
				$privs=explode(",", $privs);
				foreach ($privs as $key => $value) {
					$this->parentids[]=$value;
					$this->get_parent_ids($value);
				}
				$privs=array_unique($this->parentids);
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

	public function getMenuRole($data=[]){
		$result=self::getObject(["type"=>1],"id,name,parentid","sort ASC,id ASC");
		$new_result=[];
		foreach ($result as $key => $value) {
			$new_result[$key]=$value->toArray();
		}
		if($data && isset($data['privs']) && is_string($data['privs'])){
			$role_id=explode(",", $data['privs']);
			foreach ($role_id as $key => $value) {
				foreach ($new_result as $k2 => $v2) {
					if($value==$v2['id']){
						$new_result[$k2]['state']=["selected"=>true];
					}
				}
			}

		}
		foreach ($new_result as $key => $value) {
			$new_result[$key]['text']=$new_result[$key]['name'];
			unset($new_result[$key]['name']);
		}
		return Data::genTree($new_result);
	}

	public function get_parent_ids($parentid){
		if($parentid>0){
			$result=self::getOneObject(['id'=>$parentid]);
			if($result){
				$this->parentids[]=$result['parentid'];
				$this->get_parent_ids($result['parentid']);
			}else{
				return $this->parentids;
			}
		}else{
			return $this->parentids;
		}
	}
}