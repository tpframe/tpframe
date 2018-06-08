<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace tpfcore\web;
use tpfcore\base\TpfObject;
class Cache extends TpfObject{
	/**
	 * 获取缓存标签
	 */
	static final function get_cache_tag($name, $join = null)
	{
	    $cache_table_info = cache(CACHE_PREFIX . strtolower($name));
	    
	    $table_string = $cache_table_info[CACHE_VERSION_NAME];
	    
	    if (!empty($join) && !empty($join['join'])) {

	        if(is_array($join['join'])){

	        	foreach ($join['join'] as $v) {
	            
		            $names = explode(' ', $v);
		            
		            $table_name = str_replace('_', '', str_replace(DB_PREFIX, '', $names[0]));
		            
		            $cache_key = CACHE_PREFIX.$table_name;
		            
		            $cache_info = cache($cache_key);
		            
		            $table_string .= $cache_info[CACHE_VERSION_NAME];
		        }
	        }else{
		            
	            $table_name = str_replace('_', '', str_replace(DB_PREFIX, '', $join['join']));
	            
	            $cache_key = CACHE_PREFIX.$table_name;
	            
	            $cache_info = cache($cache_key);
	            
	            $table_string .= $cache_info[CACHE_VERSION_NAME];
	        }

	    }
	    
	    return md5(serialize($table_string));
	}

	/**
	 * 获取缓存key
	 */
	static final function get_cache_key($name, $where, $field, $order, $paginate, $join, $group, $limit, $data)
	{
	    
	    $page = input('page', '');
	    
	    $data = compact('name', 'where', 'field', 'order', 'paginate', 'join', 'group', 'limit', 'data', 'page');
	    
	    return md5(serialize($data));
	}

	/**
	 * 验证缓存标签
	 */
	static final function check_cache_tag($tag = '')
	{
	    
	    $cache_info_tags = cache(CACHE_TAGS_NAME);
	    
	    return in_array($tag, $cache_info_tags);
	}

	/**
	 * 写入缓存标签
	 */
	static final function set_cache_tag($tag = '',$expire=0)
	{
	    
	    $cache_info_tags = cache(CACHE_TAGS_NAME);
	    
	    $cache_info_tags[] = $tag;

	    cache(CACHE_TAGS_NAME, $cache_info_tags, $expire);
	}

	/**
	 * 设置缓存版本
	 */
	static final function set_cache_version($name = '')
	{
	    $strtolower_name = strtolower($name);
	    
	    $cache_table_info = cache(CACHE_PREFIX . $strtolower_name);
	    
	    ++$cache_table_info[CACHE_VERSION_NAME];
	    
	    cache(CACHE_PREFIX . $strtolower_name, $cache_table_info, 0);
	}
}