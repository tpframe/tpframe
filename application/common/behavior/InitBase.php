<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// | Site home: http://www.tpframe.com
// +----------------------------------------------------------------------
namespace app\common\behavior;

use think\Loader;
use think\Db;

/**
 * 初始化基础信息行为
 */
class InitBase
{
    /**
     * 行为入口
     */
    public function run()
    {
        //检查是否已经正常安装系统
        $this->checkInstall();

        // 初始化系统常量
        $this->initConst();
        
        // 初始化路径常量
        $this->initPathConst();
        
        // 初始化配置信息
        @file_exists('data/conf/database.php') && $this->initConfig();
        
        //$this->checkConfig();

        // 初始化数据库信息
        $this->initDbInfo();
        
        // 初始化缓存信息
        @file_exists('data/conf/database.php') && $this->initCacheInfo();
        
        //初始化一些常量
        $this->initDefine();

        // 注册命名空间
        $this->registerNamespace();
    }
    /**
     * 检查是否已经正常安装系统
     */
    private function checkInstall(){
        if(!preg_match('/(.*?)install(.*?)/', strtolower(request()->baseUrl()))){
            if(!file_exists('data/install.lock') || !file_exists("data/conf/database.php")){
                Header("Location:/install");
                exit;
            }
        }else{
            if(file_exists("data/install.lock") && file_exists("data/conf/database.php")){

                Header("Location:/");exit;

            }
            if((file_exists("data/install.lock") || file_exists("data/conf/database.php")) && !preg_match('/(.*?)install\/index\/step(.*?)/', strtolower(request()->baseUrl()))){

                exit("请删除data/install.lock文件与data/conf/database.php文件后再重新安装");

            }
        }
        
    }

    /**
     * 初始化数据库信息
     */
    private function initDbInfo()
    {
        $database_config = config('database');
        
        $list_rows = config('list_rows');
    
        define('DB_PREFIX', $database_config['prefix']);

        empty($list_rows) ? define('DB_LIST_ROWS', 10) : define('DB_LIST_ROWS', $list_rows);
    }
    
    /**
     * 初始化缓存信息
     */
    private function initCacheInfo()
    {
        
        // 缓存表信息前缀
        define('CACHE_PREFIX', 'cache_info_');
        
        // 缓存表版本key名称
        define('CACHE_VERSION_NAME', 'version');
        
        // 缓存标签key名称
        define('CACHE_TAGS_NAME', 'cache_info_tags');
        
        $list  = Db::query('SHOW TABLE STATUS');
        
        foreach ($list as $v) {
            
            $table_name = str_replace('_', '', str_replace(DB_PREFIX, '', $v['Name']));
            
            $cache_key = CACHE_PREFIX.$table_name;
            
            cache($cache_key) ?: cache($cache_key, [CACHE_VERSION_NAME => 0], 0);
        }
        
        // 缓存信息标签
        cache(CACHE_TAGS_NAME) ?: cache(CACHE_TAGS_NAME, []);
    }
    
    /**
     * 初始化系统常量
     */
    private function initConst()
    {
        

        // 通用模块名称
        define('MODULE_COMMON_NAME', 'common');
        
        // 逻辑层名称
        define('LAYER_LOGIC_NAME', 'logic');

        // 数据模型层名称
        define('LAYER_MODEL_NAME', 'model');

        // 系统服务层名称
        define('LAYER_SERVICE_NAME', 'service');

        // 系统控制器层名称
        define('LAYER_CONTROLLER_NAME', 'controller');

        // 返回结果集key
        define('RESULT_SUCCESS' , 'success');
        define('RESULT_ERROR'   , 'error');
        define('RESULT_REDIRECT', 'redirect');
        define('RESULT_MESSAGE' , 'message');
        define('RESULT_URL'     , 'url');
        define('RESULT_DATA'    , 'data');

        // 数据状态
        define('DATA_STATUS' ,  'status');
        define('DATA_NORMAL' ,  1);
        define('DATA_DISABLE',  0);
        define('DATA_DELETE' , -1);
        
        // 时间常量
        define('DATA_CREATE_TIME' ,  'create_time');
        define('DATA_UPDATE_TIME' ,  'update_time');
        define('NOW_TIME' , time());
        
        // 系统超级管理员ID
        define('ADMINISTRATOR_ID', 1);
        
        $runtime_config=file_exists(ROOT_PATH."data/conf/database.php")?include ROOT_PATH."data/conf/database.php":[];

        // 系统加密KEY
        define('DATA_ENCRYPT_KEY', isset($runtime_config['DATA_ENCRYPT_KEY'])?$runtime_config['DATA_ENCRYPT_KEY']:'!hg&HW14*WF5^%$3NHK)EDh*h#@s(01w-Eftpframe@.com');

        // 系统当前版本
        define('TPFRAME_VERSION', isset($runtime_config['TPFRAME_VERSION'])?$runtime_config['TPFRAME_VERSION']:'TPFrame v1.0');
        
    }
    
    /**
     * 初始化路径常量
     */
    private function initPathConst()
    {
        // 插件目录名称
        define('ADDON_DIR_NAME', 'addon');
        
        // 插件根目录路径
        define('ADDON_PATH', ROOT_PATH . ADDON_DIR_NAME . "/");

        // 源码核心目录
        define('SOURCE_DIR_PATH', 'coreframe/source/');

        // 核心文件目录名称
        define('TPFRAME_DIR_NAME', 'tpfcore');

        // 核心文件目录路径
        define('TPFRAME_PATH', ROOT_PATH .SOURCE_DIR_PATH.TPFRAME_DIR_NAME . "/");
        
        // 静态资源目录路径
        define('PUBLIC_PATH', ROOT_PATH . 'data/assets/');
        
        // 文件上传目录路径
        define('UPLOAD_PATH', ROOT_PATH . 'data/uploads/');
        
        // 网站
        define('SITE_PATH', $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_ADDR']);

        // 文件上传目录相对路径
        define('UPLOAD_PATH_RELATIVE', SITE_PATH.'/data/uploads/');
        
        // 图片上传目录路径
        define('PICTURE_PATH', UPLOAD_PATH . 'pics/');
 
    }
    
    /**
     * 初始化配置信息
     */
    private function initConfig()
    {
        // 配置模型
        $model = model(MODULE_COMMON_NAME.'/Config');
        
        // 获取所有配置信息
        $config_list = $model->all();
        
        // 写入配置
        foreach ($config_list as $info) {
            
           config($info['name'], $info['value']);
        }
        $runtime_config=file_exists(ROOT_PATH."data/conf/config.php")?include ROOT_PATH."data/conf/config.php":[];
        
        define("FRONTEND_THEME",isset($runtime_config['DEFAULT_THEME'])?$runtime_config['DEFAULT_THEME']:"default");

        define("HTML_CACHE_ON",isset($runtime_config['HTML_CACHE_ON'])?$runtime_config['HTML_CACHE_ON']:false);
    }
    /**
    * 检查配置文件是否完整
    */
    private function checkConfig(){
        $core_config=['data/conf/config.php'];
        $config=[];
        foreach ($core_config as $key => $value) {
            if(!file_exists(ROOT_PATH.$value)){
                die($value."不存在");
            }
            $config=array_merge($config,require ROOT_PATH.$value);
        }
    }
        
    /**
    * 常量初始化
    */
    private function initDefine(){

        defined('FRONTEND_THEME') or define('FRONTEND_THEME', "default");

        defined('HTML_CACHE_ON') or define('HTML_CACHE_ON', "false");
        // 缓存表信息前缀
        defined('CACHE_PREFIX') or define('CACHE_PREFIX', 'cache_info_');
        
        // 缓存表版本key名称
        defined('CACHE_VERSION_NAME') or define('CACHE_VERSION_NAME', 'version');
        
        // 缓存标签key名称
        defined('CACHE_TAGS_NAME') or define('CACHE_TAGS_NAME', 'cache_info_tags');
    }

    /**
     * 注册命名空间
     */
    private function registerNamespace()
    {
        // 注册插件根命名空间
        Loader::addNamespace(ADDON_DIR_NAME, ADDON_PATH);
        // 注册核心代码命名空间
        Loader::addNamespace(TPFRAME_DIR_NAME, TPFRAME_PATH);
    }
}
