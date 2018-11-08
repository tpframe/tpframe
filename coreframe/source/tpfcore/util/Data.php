<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace tpfcore\util;
/**
 * 通用的树型类，可以生成任何树型结构
 */
class Data {
	final static function filterEmptyDate($arr=[]){
		foreach ($arr as $key => $value) {
			if($value===""||$value===NULL) unset($arr[$key]);
		}
		return $arr;
	}
	/*
		把普通数组转换成树型数组
	*/
	final static function toTreeArrray($items=[],$parentid="parentid"){
		$tree = array(); //格式化好的树
		if(is_array($items)){
		    foreach ($items as $item)
		        if (isset($items[$item[$parentid]]))
		            $items[$item[$parentid]]['son'][] = &$items[$item['id']];
		        else
		            $tree[] = &$items[$item['id']];
	    }
	    return $tree;
	}
	/*
		把普通数组转换成树型数组
	*/
	final static function toTreeArrray2($items=[],$parentid="parentid") { 
	    foreach ($items as $item) 
	        $items[$item[$parentid]]['son'][$item['id']] = &$items[$item['id']]; 
	    return isset($items[0]['son']) ? $items[0]['son'] : array(); 
	}
	final static function genTree($items,$id='id',$pid='parentid',$son = 'children'){
		$tree = array(); //格式化的树
	  	$tmpMap = array(); //临时扁平数据
	    
	  	foreach ($items as $item) {
	    	$tmpMap[$item[$id]] = $item;
	  	}
	  	foreach ($items as $item) {
	    	if (isset($tmpMap[$item[$pid]])) {
	      		$tmpMap[$item[$pid]][$son][] = &$tmpMap[$item[$id]];
	    	} else {
	      		$tree[] = &$tmpMap[$item[$id]];
	  		}
	  	}
	  	unset($tmpMap);
	  	return $tree;
	}
	/**
	 * 把返回的数据集转换成Tree
	 * @param array $list 要转换的数据集
	 * @param string $pid parent标记字段
	 * @param string $level level标记字段
	 * @return array
	 */
	final static function list_to_tree($list, $pk='id', $pid = 'pid', $child = 'child', $root = 0)
	{
	    // 创建Tree
	    $tree = [];
	    if (is_array($list)) {
	        // 创建基于主键的数组引用
	        $refer = [];
	        foreach ($list as $key => $data) {
	            $refer[$data[$pk]] =& $list[$key];
	        }
	        foreach ($list as $key => $data) {
	            // 判断是否存在parent
	            $parentId =  $data[$pid];
	            if ($root == $parentId) {
	                $tree[] =& $list[$key];
	            } else if(isset($refer[$parentId])){
	                $parent =& $refer[$parentId];
	                if(is_object($parent)) {
	                    $parent = $parent->toArray();
	                }
	                $parent[$child][] =& $list[$key];
	            }
	        }
	    }
	    return $tree;
	}
}