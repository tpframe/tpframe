<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\backend\logic;
use \tpfcore\util\Tree;
use \tpfcore\Core;
use \think\Config;
/**
 *  导航逻辑
 */
class Category extends AdminBase
{
	public function saveCategory($data){
		/*$validate=\think\Loader::validate($this->name);
		$validate_result = $validate->scene('add')->check($data);
        if (!$validate_result) {    
            return [RESULT_ERROR, $validate->getError(), null];
        }*/
		$last_id=Core::loadModel($this->name)->saveObject($data);
		if($last_id){
        	return [RESULT_SUCCESS, '操作成功', url('Category/index')];
        }
	}
	public function delCategory($data){
		return self::deleteObject($data,true)?[RESULT_SUCCESS, '删除成功', url('links/index')]:[RESULT_ERROR, '删除失败', url('links/index')];
	}
	public function getCategoryListByid($data){
		return self::getOneObject($data);
	}
	public function getCategoryList(){
		$result=self::getObject([],"*","sort ASC");
		foreach ($result as $key => $value) {
			$result[$key]=$value->toArray();
		}
		$assets_path=Config::get("template")['view_path'].DS.'assets';
        $tree = new Tree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        foreach ($result as $n=> $r) {
        	$result[$n]['parentid_node'] = ($r['parentid']) ? ' class="child-of-node-' . $r['parentid'] . ' collapsed"' : 'class="expanded"';
            $result[$n]['manage'] = '<a href="' . url("Category/add", ["parentid" => $r['id']]) . '">添加分类</a> | <a href="' . url("Category/edit", ["id" => $r['id']]) . '">编辑分类</a> | <a href="' . url("Category/del", ["id" => $r['id']]). '">删除分类</a> ';
            $result[$n]['isnav'] = $r['isnav'] ?  '<img src="/theme/backend/assets/images/yes.gif"/>': '<img src="/theme/backend/assets/images/no.gif"/>';
            $result[$n]['display'] = $r['display'] ? "显示" : "隐藏";
        }
       
        $tree->init($result);
        $str = "<tr id='node-\$id' \$parentid_node>
					<td style='padding-left:20px;'><span style='padding-left: 20px' class='expander'></span><input name='listorders[\$id]' type='text' size='3' value='\$sort' class='input input-order'></td>
					<td>\$id</td>
					<td>\$spacer\$title</td>
					<td>\$isnav</td>
				    <td>\$display</td>
					<td>\$manage</td>
				</tr>";
        $categorys = $tree->get_tree(0, $str);
		return $categorys;
	}
	public function getTreeCategory($data=[]){
		$parentid=empty($data['id'])?(empty($data['parentid'])?-1:$data['parentid']):$data['id'];
		if(!empty($data['id'])){
			$list=$this->getCategoryListByid(['id'=>$data['id']]);
			$parentid=$list->parentid;
		}
		if(!empty($data['cid'])){
			$parentid=$data['cid'];
		}
		$result=self::getObject([],"*","sort ASC");
		foreach ($result as $key => $value) {
			unset($result[0]);
			$result[$value['id']]=$value->toArray();
		}
		
        $tree = new Tree();
        $tree->init($result);
        $str = "<option value='\$id' \$selected>\$spacer \$title</option>";
        $categorys = $tree->get_tree(0, $str,$parentid);
		return $categorys;
	}

}