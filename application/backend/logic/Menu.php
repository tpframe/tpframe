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
	private $arr=[];
	public function saveMenu($data){
		/*$validate=\think\Loader::validate($this->name);
		$validate_result = $validate->scene('add')->check($data);
        if (!$validate_result) {    
            return [RESULT_ERROR, $validate->getError(), null];
        }*/
		$last_id=Core::loadModel($this->name)->saveObject($data);
		if($last_id){
        	return [RESULT_SUCCESS, '操作成功', url('Menu/index')];
        }
	}
	public function delMenu($data){
		return self::deleteObject($data,true)?[RESULT_SUCCESS, '删除成功', url('links/index')]:[RESULT_ERROR, '删除失败', url('links/index')];
	}
	public function getMenuListByid($data){
		return self::getOneObject($data);
	}
	public function getMenuList(){
		$result=self::getObject([],"*","sort ASC");
		foreach ($result as $key => $value) {
			$result[$key]=$value->toArray();
		}
        $tree = new Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        
        foreach ($result as $n=> $r) {
        	$result[$n]['parentid_node'] = ($r['parentid']) ? ' class="child-of-node-' . $r['parentid'] . ' collapsed"' : 'class="expanded"';
            $result[$n]['manage'] = '<a href="' . url("Menu/add", ["parentid" => $r['id']]) . '">添加菜单</a> | <a href="' . url("Menu/edit", ["id" => $r['id']]) . '">编辑菜单</a> | <a href="' . url("Menu/del", ["id" => $r['id']]). '">删除菜单</a> ';
            $result[$n]['display'] = $r['display'] ? "显示" : "隐藏";
            $result[$n]['app']=$r['model']."/".$r['controller']."/".$r['action'];
        }
       
        $tree->init($result);
        $str = "<tr id='node-\$id' \$parentid_node>
					<td style='padding-left:20px;'><span style='padding-left: 20px' class='expander'></span><input name='listorders[\$id]' type='text' size='3' value='\$sort' class='input input-order'></td>
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
		foreach ($result as $key => $value) {
			unset($result[0]);
			$result[$value['id']]=$value->toArray();
		}
		
        $tree = new Tree();
        $tree->init($result);
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $categorys = $tree->get_tree(0, $str,$parentid);
		return $categorys;
	}
	public function getMenuArrTree($where=[],$filter,$returnarr){
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