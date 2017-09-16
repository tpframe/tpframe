<?php
namespace app\common\model;

use think\Model;
use think\Db;
#use think\Cache;
use tpfcore\web\Cache;
/*	
*	模型基类
*	最基本的增、删、改、查类，所有的模型类都继承基类
*/
class ModelBase extends Model
{
    // 当前类名称
    public $class;
	// 查询对象
    private static $ob_query = null;
    /**
     * 基类初始化
     */
    protected function _initialize()
    {
        // 当前类名
        $this->class = get_called_class();
    }
    /**
     * 状态获取器
     */ 
    public function getStatusTextAttr()
    {
        
        $status = [DATA_DELETE => '删除', DATA_DISABLE => '禁用', DATA_NORMAL => '启用'];
        
        return $status[$this->data['status']];
    }
    
    /**
     * 保存数据，没有主键就执行添加，有就执行更新
     * @access protected
     * @param stirng|array $data 要操作的数据
     * @param string|array $where 操作的条件
     * @param string $sequence 自增序列名
     * @return boolean
     */
    final protected function saveObject($data = [], $where = [], $sequence = null)
    {
        
        $pk = $this->getPk();
        
        Cache::set_cache_version($this->name);
        
        return empty($data[$pk]) ? $this->allowField(true)->isUpdate(false)->save($data, $where, $sequence) : $this->updateObject($where, $data,$sequence);
    }
    
    /**
     * 新增数据,是否返回自增的主键
     * @access protected
     * @param stirng|array $data 要操作的数据
     * @param boolean $getLastInsID 返回自增主键   默认返回
     * @param string  $sequence     自增序列名
     * @return boolean
     */
    final protected function addObject($data = [], $getLastInsID = true,$sequence = null)
    { 
        Cache::set_cache_version($this->name);
        return $this->insert($data, false, $getLastInsID,$sequence = null);
    }
    
    /**
     * 更新数据
     * @access protected
     * @param stirng|array $data 要操作的数据
     * @param string|array $where 操作的条件
     * @return boolean
     */
    final protected function updateObject($where = [], $data = [],$sequence = null)
    {

        Cache::set_cache_version($this->name);
        // return $this->allowField(true)->update($data,$where);
        return $this->allowField(true)->isUpdate(true)->save($data, $where, $sequence);
    }
    
     /**
     * 聚合函数-统计数据
     * @access protected
     * @param string|array $where 操作的条件
     * @param stirng $stat_type 统计类型，默认为count，统计条件
     * @return mixed
     */
    final protected function getStatistics($where = [], $stat_type = 'count', $field = 'id')
    {
        
        return $this->where($where)->$stat_type($field);
    }
    
    /**
     * 保存多个数据到当前数据对象
     * @access public
     * @param array   $data_list 数据
     * @param boolean $replace 是否自动识别更新和写入
     * @return array|false
     */
    final protected function opObjects($data_list = [], $replace = false)
    {
        Cache::set_cache_version($this->name);
        
        return $this->saveAll($data_list, $replace);
    }
    
    /**
     * 设置某个字段值
     * @access protected
     * @param array   $where 条件
     * @param string $field 字段名
     * @param string $value 新的值
     * @return boolean
     */
    final protected function setFieldValue($where = [], $field = '', $value = '')
    {
        return $this->updateObject($where, [$field => $value]);
    }
    
    /**
     * 删除数据（分真实删除与更改字段状态）
     * @access protected
     * @param array   $where 条件
     * @param string $is_true 是否真实删除
     * @return boolean
     */
    final protected function deleteObject($where = [], $is_true = false)
    { 
        Cache::set_cache_version($this->name);
        return $is_true ? $this->where($where)->delete() : $this->setFieldValue($where, DATA_STATUS, DATA_DELETE);
    }
    
    /**
     * 得到某个列的数组
     * @access protected
     * @param array   $where 条件
     * @param string $field 字段名 多个字段用逗号分隔
     * @param string $key   索引
     * @return array
     */
    final protected function getColumns($where = [], $field = '', $key = '')
    {
        return Db::name($this->name)->where($where)->column($field, $key);
    }
    
    /**
     * 得到某个字段的值
     * @access protected
     * @param array   $where 条件
     * @param string $field   字段名
     * @param mixed  $default 默认值
     * @param bool   $force   强制转为数字类型
     * @return mixed
     */
    final protected function getColumnValue($where = [], $field = '', $default = null, $force = false)
    {
        return Db::name($this->name)->where($where)->value($field, $default, $force);
    }
    
    /**
    * 查找单条记录
    * @access protected
    * @param array   $where 条件
    * @param string $field   字段名
    * @return mixed
    */
    final protected function getOneObject($where = [], $field = true)
    {
       $arr=$this->where($where)->field($field)->find();
       return $arr;
    }
    
    /**
    * 获取数据列表
    * @access protected
    * @param array   $where 条件
    * @param string $field   字段名
    * @param string|array $order 排序字段
    * @param array $paginate   分布处理参数
    * @param array $join   联合查询参数
    * @param array $group   分组查询参数
    * @param mixed $limit   查询条数
    * @param mixed $data   数据集
    * @return mixed
    */
    final protected function getObject($where = [], $field = true, $order = '', $paginate = array('rows' => null, 'simple' => false, 'config' => []), $join = array('join' => null, 'condition' => null, 'type' => 'INNER'), $group = array('group' => '', 'having' => ''), $limit = null, $data = null)
    {
        
        $paginate['simple'] = empty($paginate['simple']) ? false   : $paginate['simple'];
        
        $paginate['config'] = empty($paginate['config']) ? []      : $paginate['config'];
        
        $join['condition']  = empty($join['condition'])  ? null    : $join['condition'];
        
        $join['type']       = empty($join['type'])       ? 'INNER' : $join['type'];
        
        $group['having']    = empty($group['having'])    ? ''      : $group['having'];
        
        self::$ob_query = $this->where($where)->order($order);
        
        !empty($join['join'])     && self::$ob_query = self::$ob_query->join($join['join'], $join['condition'], $join['type']);
        
        self::$ob_query = self::$ob_query->field($field);
        
        !empty($group['group'])   && self::$ob_query = self::$ob_query->group($group['group'], $group['having']);
    
        !empty($limit)            && self::$ob_query = self::$ob_query->limit($limit);
        
        $cache_tag = Cache::get_cache_tag($this->name, $join);
        
        $cache_key = Cache::get_cache_key($this->name, $where, $field, $order, $paginate, $join, $group, $limit, $data);
        
        if (\think\Cache::has($cache_key) && Cache::check_cache_tag($cache_tag)) {

            return unserialize(\think\Cache::get($cache_key));
            
        } else {
            $result_data = !empty($paginate['rows']) ? self::$ob_query->paginate($paginate['rows'], $paginate['simple'], $paginate['config']) : self::$ob_query->select($data);
            
            \think\Cache::tag($cache_tag)->set($cache_key, serialize($result_data)) && Cache::set_cache_tag($cache_tag);
            
            return $result_data;
        }
    }
}
?>