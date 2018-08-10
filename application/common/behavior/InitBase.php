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
        @file_exists(APP_PATH.'extra/database.php') && $this->initConfig();

        // 初始化数据库信息
        $this->initDbInfo();
        
        // 初始化缓存信息
        @file_exists(APP_PATH.'extra/database.php') && $this->initCacheInfo();
        
        //初始化一些常量
        $this->initDefine();
        
        //自动载入第三方包文件
        $this->autoImportPackage(PACKAGE_PATH);

        // 注册命名空间
        $this->registerNamespace();
    }
    /**
     * 检查是否已经正常安装系统
     */
    private function checkInstall(){

        // 判断是否是进行安装操作
        if(preg_match('/^\/install(.*?)/', strtolower(request()->baseUrl()))){

            if(file_exists("data/install.lock") && file_exists(APP_PATH."extra/database.php")){

                Header("Location:/");exit;

            }
            // 如果有install，配置文件又不完整的情况，如果没到第5步，有任意一个配置文件则表示非正常安装
            if(!preg_match('/(.*?)step5(.*?)/', strtolower(request()->baseUrl()))){
                if(stripos(strtolower(request()->url(true)), "/install/index/install")==false && (file_exists("data/install.lock") || file_exists(APP_PATH."extra/database.php"))){
                    exit("请删除data/install.lock文件与".APP_PATH."extra/database.php文件后再重新安装");
                }               
            }else{
                // 如果有install，配置文件又不完整的情况，如果到了第5步，数据库配置文件不在，则表示前面安装有问题
                if(file_exists("data/install.lock") && !file_exists(APP_PATH."extra/database.php")){
                    exit("请删除data/install.lock文件后再重新安装");
                }   
            }
        }else{
            if(!file_exists('data/install.lock') || !file_exists(APP_PATH."extra/database.php")){
                Header("Location:/install");
                exit;
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

        // 系统加密KEY
        define('DATA_ENCRYPT_KEY', config('database.DATA_ENCRYPT_KEY')?config('database.DATA_ENCRYPT_KEY'):'!hg&HW14*WF5^%$3NHK)EDh*h#@s(01w-Eftpframe@.com');

        // 系统当前版本
        define('TPFRAME_VERSION', config('version.tpframe_version')?config('version.tpframe_version'):'TPFrame v3.0');
        
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

        // 第三方程序包目录
        define('PACKAGE_PATH', 'coreframe/package');
        
        // 静态资源目录路径
        define('PUBLIC_PATH', ROOT_PATH . 'data/assets/');
        
        // 文件上传目录路径
        define('UPLOAD_PATH', ROOT_PATH . 'data/uploads/');
        
        // 网站
        define('SITE_PATH',(isset($_SERVER['REQUEST_SCHEME']) && !empty($_SERVER['REQUEST_SCHEME']))?$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']:(strpos($_SERVER['SERVER_PROTOCOL'],'HTTPS')  !== false ?"https://".$_SERVER['HTTP_HOST']:"http://".$_SERVER['HTTP_HOST']));

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

        define("FRONTEND_THEME",config('config.DEFAULT_THEME')?config('config.DEFAULT_THEME'):"default");

        define("HTML_CACHE_ON",config('config.HTML_CACHE_ON')?config('config.HTML_CACHE_ON'):false);
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
    * 自动导入第三方包文件
    */
    private function autoImportPackage($path){
        if(is_dir($path)){
            $dir =  scandir($path);
            foreach ($dir as $file){
                $sub_path =$path .'/'.$file;
                if($file != "." && $file != ".." && strpos($file,".")===false && is_dir($sub_path)){
                    if(file_exists($sub_path.'/Bootstrap.php')){
                        include $sub_path.'/Bootstrap.php';
                    }
                    $this->autoImportPackage($sub_path);
                }
            }
        }
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
