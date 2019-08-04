<?php
/**
 * ============================================================================
 * 版权所有 2017-2077 tpframe工作室，并保留所有权利。
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！未经本公司授权您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 模型基类
 */
namespace app\common\model;

use think\Model;
use think\Db;
use PDO;
use tpfcore\helpers\StringHelper;
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
     * 取得数据库的表信息
     * @access public
     * @param string $dbName
     * @return array
     */
    final protected function getTables($dbName = '')
    {
        $sql    = !empty($dbName) ? 'SHOW TABLES FROM ' . $dbName : 'SHOW TABLES ';
        $pdo    = Db::query($sql, [], false, true);
        $result = $pdo->fetchAll(PDO::FETCH_ASSOC);
        $info   = [];
        foreach ($result as $key => $val) {
            $info[$key] = current($val);
        }
        return $info;
    }
    /**
     * 取得数据表的字段信息
     * @access public
     * @param string $tableName
     * @return array
     */
    final protected function getFields($tableName)
    {
        list($tableName) = explode(' ', $tableName);
        if (false === strpos($tableName, '`')) {
            if (strpos($tableName, '.')) {
                $tableName = str_replace('.', '`.`', $tableName);
            }
            $tableName = '`' . $tableName . '`';
        }
        $sql    = 'SHOW COLUMNS FROM ' . $tableName;
        $pdo    = Db::query($sql, [], false, true);
        $result = $pdo->fetchAll(PDO::FETCH_ASSOC);
        $info   = [];
        if ($result) {
            foreach ($result as $key => $val) {
                $val                 = array_change_key_case($val);
                $info[$val['field']] = [
                    'name'    => $val['field'],
                    'type'    => $val['type'],
                    'notnull' => (bool) ('' === $val['null']), // not null is empty, null is yes
                    'default' => $val['default'],
                    'primary' => (strtolower($val['key']) == 'pri'),
                    'autoinc' => (strtolower($val['extra']) == 'auto_increment'),
                ];
            }
        }
        return $info;
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
     * @param string|array $field 操作的字段列表
     * @param string $sequence 自增序列名
     * @return boolean
     */
    final protected function saveObject($data = [],$field = true, $where = [], $sequence = null)
    {
        
        $pk = $this->getPk();
        
        return empty($data[$pk]) ? $this->addObject($data, true, $field, $sequence) : $this->updateObject($where, $data, $field, $sequence);
    }
    
    /**
     * 新增数据,是否返回自增的主键
     * @access protected
     * @param stirng|array $data 要操作的数据
     * @param boolean $getLastInsID 返回自增主键   默认返回
     * @param string  $sequence     自增序列名
     * @return boolean
     */
    final protected function addObject($data = [], $getLastInsID = true, $field = true, $sequence = null)
    {
        $result= $this->allowField($field)->isUpdate(false)->save($data, $where=[], $sequence);
        if($getLastInsID){
            if(method_exists($this, "getQuery")){
                return $this->getQuery()->getLastInsID($sequence);
            }else{
                return $this->db()->getLastInsID($sequence);
            }
        }
        return $result;
    }
    
    /**
     * 更新数据
     * @access protected
     * @param stirng|array $data 要操作的数据
     * @param string|array $where 操作的条件
     * @return boolean
     */
    final protected function updateObject($where = [], $data = [], $field = true, $sequence = null)
    {

        return $this->allowField($field)->isUpdate(true)->save($data, $where, $sequence);

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
    final protected function deleteObject($where = [], $is_true = false , $column = null)
    { 
        return $is_true ? $this->where($where)->delete() : $this->setFieldValue($where, is_null($column)?DATA_STATUS:$column, DATA_DELETE);
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
       return $this->where($where)->field($field)->find();
    }
    
    /**
    * 获取数据列表
    * @access protected
    * @param array   $where 条件
    * @param string $field   字段名
    * @param string|array $order 排序字段
    * @param array $paginate   分布处理参数
    * @param array $join   联合查询参数    
    * ["join"=>["__CATEGORY__","__USER__"],"condition"=>["__CATEGORY__.id=__POSTS__.cateid","__USER__.id=__POSTS__.uid"],"type"=>["left","left"]]
    * 或["join"=>["__CATEGORY__"],"condition"=>["__CATEGORY__.id=__POSTS__.cateid"],"type"=>["left"]]
    * 或["join"=>"__CATEGORY__","condition"=>"__CATEGORY__.id=__POSTS__.cateid","type"=>"left"]
    * @param array $group   分组查询参数
    * @param mixed $limit   查询条数
    * @param mixed $data   数据集
    * @return mixed
    */
    final protected function getObject($where = [], $field = true, $order = '', $paginate = array('rows' => null, 'simple' => false, 'config' => []), $join = array('join' => null, 'condition' => null, 'type' => 'INNER'), $group = array('group' => '', 'having' => ''), $limit = null, $data = null,$expire=0)
    {
        if(isset($where['page'])) unset($where['page']);

        $where=StringHelper::parseStrTable($where);
        
        $field=StringHelper::parseStrTable($field);
 
        $join=StringHelper::parseStrTable($join);

        $order=StringHelper::parseStrTable($order);

        $group=StringHelper::parseStrTable($group);

        $paginate['simple'] = empty($paginate['simple']) ? false   : $paginate['simple'];
        
        $paginate['config'] = empty($paginate['config']) ? []      : $paginate['config'];
        
        $join['condition']  = empty($join['condition'])  ? null    : $join['condition'];
        
        $join['type']       = empty($join['type'])       ? 'INNER' : $join['type'];
        
        $group['having']    = empty($group['having'])    ? ''      : $group['having'];
        
        self::$ob_query = $this->where($where)->order($order);

        if(!empty($join['join'])){

            if(is_array($join['join'])){

                foreach ($join['join'] as $key => $value) {

                    self::$ob_query = self::$ob_query->join($join['join'][$key], $join['condition'][$key], $join['type'][$key]);

                }

            }else{

                self::$ob_query = self::$ob_query->join($join['join'], $join['condition'], $join['type']);

            }

        }

        $except = false;

        is_array($field) && isset($field[1]) && $except = true;

        self::$ob_query = self::$ob_query->field($field,$except);
        
        !empty($group['group'])   && self::$ob_query = self::$ob_query->group($group['group'], $group['having']);
    
        !empty($limit)            && self::$ob_query = self::$ob_query->limit($limit);
        
        $cache_tag = Cache::get_cache_tag($this->name, $join);
        
        $cache_key = Cache::get_cache_key($this->name, $where, $field, $order, $paginate, $join, $group, $limit, $data);
        
        if (\think\Cache::has($cache_key) && Cache::check_cache_tag($cache_tag)) {

            return unserialize(\think\Cache::get($cache_key));
            
        } else {
            $result_data = !empty($paginate['rows']) ? self::$ob_query->paginate($paginate['rows'], $paginate['simple'], $paginate['config']) : self::$ob_query->select($data);

            HTML_CACHE_ON && \think\Cache::tag($cache_tag)->set($cache_key, serialize($result_data),$expire) && Cache::set_cache_tag($cache_tag,$expire);
            
            return $result_data;
        }
    }

    /**
    * 获取数据列表，为了更加灵活，采用数组的方式导入参数
    * @access protected
    * @param array   $param 参数
    * @return mixed
    */
    final protected function getList($param=[])
    {
        $defaultParam=   [
                    "where" =>[],
                    "field" =>true,
                    "order" =>"",
                    "orderRaw"=>"",
                    "paginate"  =>['rows' => null, 'simple' => false, 'config' => []],
                    "join"      =>['join' => null, 'condition' => null, 'type' => 'INNER'],
                    "group"     =>['group' => '', 'having' => ''],
                    "limit" =>null,
                    "data"  =>null,
                    "expire"=>0
        ]; 
        $param=StringHelper::parseStrTable($param);

        $params=array_merge($defaultParam,$param);

        extract($params);

        $paginate['simple'] = empty($paginate['simple']) ? false   : $paginate['simple'];
        
        $paginate['config'] = empty($paginate['config']) ? ['query' => request()->param()]      : $paginate['config'];
        
        $join['condition']  = empty($join['condition'])  ? null    : $join['condition'];
        
        $join['type']       = empty($join['type'])       ? 'INNER' : $join['type'];
        
        $group['having']    = empty($group['having'])    ? ''      : $group['having'];
        
        !empty($orderRaw)?self::$ob_query = $this->where($where)->orderRaw($orderRaw):self::$ob_query = $this->where($where)->order($order);

        if(!empty($join['join'])){

            if(is_array($join['join'])){

                foreach ($join['join'] as $key => $value) {

                    self::$ob_query = self::$ob_query->join($join['join'][$key], $join['condition'][$key], $join['type'][$key]);

                }

            }else{

                self::$ob_query = self::$ob_query->join($join['join'], $join['condition'], $join['type']);

            }

        }

        $except = false;

        is_array($field) && isset($field[1]) && $except = true;

        self::$ob_query = self::$ob_query->field($field,$except);
        
        !empty($group['group'])   && self::$ob_query = self::$ob_query->group($group['group']);

        !empty($group['having'])  && self::$ob_query = self::$ob_query->having($group['having']);
    
        !empty($limit)            && self::$ob_query = self::$ob_query->limit($limit);
        
        $cache_tag = Cache::get_cache_tag($this->name, $join);
        
        $cache_key = Cache::get_cache_key($this->name, $where, $field, $order, $paginate, $join, $group, $limit, $data);
        
        if (\think\Cache::has($cache_key) && Cache::check_cache_tag($cache_tag)) {

            return unserialize(\think\Cache::get($cache_key));
            
        } else {
            $result_data = !empty($paginate['rows']) ? self::$ob_query->paginate($paginate['rows'], $paginate['simple'], $paginate['config']) : self::$ob_query->select($data);

            HTML_CACHE_ON && \think\Cache::tag($cache_tag)->set($cache_key, serialize($result_data),$expire) && Cache::set_cache_tag($cache_tag,$expire);
            
            return $result_data;
        }
    }
}
?>