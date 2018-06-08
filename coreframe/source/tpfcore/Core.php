<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 * ============================================================================
 * 版权所有 2017-2077 tpframe工作室，并保留所有权利。
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！未经本公司授权您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * 核心类
 */
namespace tpfcore;
use \think\Loader;
use tpfcore\helpers\StringHelper;
class Core{
	/**
    * 加载模型
    * @access protected
    * @param string   $name     模型名
    * @param string   $module   模块名
    * @param string   $layer    模块名
    * @return mixed
    */
	final static function loadModel($name = '', $module = '' , $layer='')
	{
	    $backtrace_array = debug_backtrace(false, 1);

	    $current_directory_name = basename(dirname($backtrace_array[0]['file']));
	    
	    !empty($module) && $name = $module.'/'.$name;

	    $return_object = null;
	    if(!$layer){
		    switch ($current_directory_name) {
		        case LAYER_CONTROLLER_NAME : $return_object = $module?model($name, LAYER_SERVICE_NAME):self::getModel($name,LAYER_CONTROLLER_NAME); break;
		        case LAYER_SERVICE_NAME    : $return_object = model($name, LAYER_LOGIC_NAME); break;
		        case LAYER_LOGIC_NAME      : $return_object = model($name, LAYER_MODEL_NAME); break;
		        case LAYER_MODEL_NAME      : $return_object = model($name, LAYER_MODEL_NAME); break;
		        default                    : $return_object = model($name, LAYER_LOGIC_NAME); break;
		    }
	    }else{
		    switch ($layer) {
		        case LAYER_CONTROLLER_NAME : $return_object = model($name, LAYER_CONTROLLER_NAME); break;
		        case LAYER_SERVICE_NAME    : $return_object = model($name, LAYER_SERVICE_NAME); break;
		        case LAYER_LOGIC_NAME      : $return_object = model($name, LAYER_LOGIC_NAME); break;
		        case LAYER_MODEL_NAME      : $return_object = model($name, LAYER_MODEL_NAME); break;
		        default                    : $return_object = model($name, LAYER_MODEL_NAME); break;
		    }
	    }
	    return $return_object;
	}
	/**
    * 加载具体模型
    * @access protected
    * @param string   $name     模型名
    * @param string   $layer    模块名
    * @return mixed
    */
	private static function getModel($name,$layer){
		$model=null;
		$common_service='app'."\\".MODULE_COMMON_NAME."\\".LAYER_SERVICE_NAME."\\".$name;
		$common_logic='app'."\\".MODULE_COMMON_NAME."\\".LAYER_LOGIC_NAME."\\".$name;
		$common_model='app'."\\".MODULE_COMMON_NAME."\\".LAYER_MODEL_NAME."\\".$name;

		$module_service='app'."\\".MODULE_NAME."\\".LAYER_SERVICE_NAME."\\".$name;
		$module_logic='app'."\\".MODULE_NAME."\\".LAYER_LOGIC_NAME."\\".$name;
		$module_model='app'."\\".MODULE_NAME."\\".LAYER_MODEL_NAME."\\".$name;

		if($layer==LAYER_CONTROLLER_NAME){
			if(class_exists($common_service) || class_exists($module_service)){
    			$model=model($name, LAYER_SERVICE_NAME);
    		}else if(class_exists($common_logic) || class_exists($module_logic)){
    			$model=model($name, LAYER_LOGIC_NAME);
    		}else{
    			$model=model($name, LAYER_MODEL_NAME);
    		}
		}
		return $model;
	}
	/**
     * 调用模块的操作方法 参数格式 [模块/控制器/]操作
     * @param string        $action 调用动作 [控制器/操作]
     * @param string|array  $vars 调用参数 支持字符串和数组
	 * @param string        $model 调用模块
     * @param string        $layer 要调用的控制层名称（logic\service\model\controller）
     * @param bool          $appendSuffix 是否添加类名后缀
     * @return mixed
     */
	final static function loadAction($action,$vars = [],$model="",$layer="",$appendSuffix = false){
		$name=explode("/", $action)[0];
		$common_service='app'."\\".MODULE_COMMON_NAME."\\".LAYER_SERVICE_NAME."\\".$name;
		$common_logic='app'."\\".MODULE_COMMON_NAME."\\".LAYER_LOGIC_NAME."\\".$name;
		$common_model='app'."\\".MODULE_COMMON_NAME."\\".LAYER_MODEL_NAME."\\".$name;

		$module_service='app'."\\".MODULE_NAME."\\".LAYER_SERVICE_NAME."\\".$name;
		$module_logic='app'."\\".MODULE_NAME."\\".LAYER_LOGIC_NAME."\\".$name;
		$module_model='app'."\\".MODULE_NAME."\\".LAYER_MODEL_NAME."\\".$name;
		$module_controller='app'."\\".MODULE_NAME."\\".LAYER_CONTROLLER_NAME."\\".$name;

		if(!$model){
			if($layer){
				switch ($layer){
					case LAYER_CONTROLLER_NAME : $result = class_exists($module_controller)?Loader::action($action, $vars, LAYER_CONTROLLER_NAME, $appendSuffix):Loader::action('common'."/".$action, $vars, LAYER_CONTROLLER_NAME, $appendSuffix); break;
			        case LAYER_SERVICE_NAME    : $result = class_exists($module_service)?Loader::action($action, $vars, LAYER_SERVICE_NAME, $appendSuffix):Loader::action('common'."/".$action, $vars, LAYER_SERVICE_NAME, $appendSuffix); break;
			        case LAYER_LOGIC_NAME      : $result = class_exists($module_logic)?Loader::action($action, $vars, LAYER_LOGIC_NAME, $appendSuffix):Loader::action('common'."/".$action, $vars, LAYER_LOGIC_NAME, $appendSuffix); break;
			        case LAYER_MODEL_NAME      : $result = class_exists($module_model)?Loader::action($action, $vars, LAYER_MODEL_NAME, $appendSuffix):Loader::action('common'."/".$action, $vars, LAYER_MODEL_NAME, $appendSuffix); break;
			        default                    : break;
				}
			}else{
				if(class_exists($common_logic)){
					$url='common'."/".$action;
					$result=Loader::action($url, $vars, LAYER_LOGIC_NAME, $appendSuffix);
				}
				else if(class_exists($module_logic)){
					$result=Loader::action($action, $vars, LAYER_LOGIC_NAME, $appendSuffix);
				}
				else if(class_exists($common_service)){
					$url='common'."/".$action;
					$result=Loader::action($url, $vars, LAYER_SERVICE_NAME, $appendSuffix);
				}else{
					$result=Loader::action($action, $vars, LAYER_SERVICE_NAME, $appendSuffix);
				}
			}
			
		}else{
			$module_service='app'."\\".$model."\\".LAYER_SERVICE_NAME."\\".$name;
			$module_logic='app'."\\".$model."\\".LAYER_LOGIC_NAME."\\".$name;
			$module_model='app'."\\".$model."\\".LAYER_MODEL_NAME."\\".$name;
			$module_controller='app'."\\".$model."\\".LAYER_CONTROLLER_NAME."\\".$name;
			$url=$model."/".$action;
			if($layer){
				switch ($layer){
					case LAYER_CONTROLLER_NAME : $result = Loader::action($url, $vars, LAYER_CONTROLLER_NAME, $appendSuffix);break;
			        case LAYER_SERVICE_NAME    : $result = Loader::action($url, $vars, LAYER_SERVICE_NAME, $appendSuffix);break;
			        case LAYER_LOGIC_NAME      : $result = Loader::action($url, $vars, LAYER_LOGIC_NAME, $appendSuffix);break;
			        case LAYER_MODEL_NAME      : $result = Loader::action($url, $vars, LAYER_MODEL_NAME, $appendSuffix);break;
			        default                    : break;
				}
			}else{
				if(class_exists($module_logic)){
					$result=Loader::action($url, $vars, LAYER_LOGIC_NAME, $appendSuffix);
				}else{
					$result=Loader::action($url, $vars, LAYER_SERVICE_NAME, $appendSuffix);
				}

			}
		}
		return $result;
	}
	/**
	 * 获取插件类的类名
	 * @param strng $name 插件名
	 */
	final static function get_addon_class($catename = '', $name = '')
	{

	    $addonClass=StringHelper::s_format_class($catename);

	    $class = ADDON_DIR_NAME."\\{$catename}\\{$addonClass}";
	    
	    return $class;
	}

	/**
	 * 钩子
	 */
	final static function hook($tag = '', $params = [])
	{
	    
	    \think\Hook::listen($tag, $params);
	}
	/**
	 * 插件显示内容里生成访问插件的url
	 * @param string $url url  插件名类名://控制器/方法  eg:FriendLink://FriendLink/index
	 * @param array $param 参数
	 * @author <510974211@qq.com>
	 */
	final static function addons_url($url, $param = array())
	{

	    $url        =  parse_url($url);   // login://qq/login ====> Array ( [scheme] => login [host] => qq [path] => /login )

	    $addons     =  $url['scheme'];

	    $controller =  $url['host'];

	    $action     =  isset($url['path'])?$url['path']:"index";

	    /* 基础参数 */
	    $params_array = array(
	        'm'     => StringHelper::s_format_underline($addons),
	        'c' 	=> StringHelper::s_format_underline($controller),
	        'a'     => strtolower(substr($action, 1)),
	    );

	    $params = array_merge($params_array, $param); //添加额外参数

	    return url('addon/execute', $params);
	}
	/**
	 * 获取插件模型，默认获取c参数相同的控制器，否则外部l参数传递过来
	 * @param var $param 参数
	 * @author <510974211@qq.com>
	 */
	final static function loadAddonModel($param=[],$module="",$layer=""){
		if(null==$param || empty($param) || ""==$param){
			return null;
		}

		if(is_array($param) && !array_key_exists("m",$param)){
			return null; 
		}

		if(is_string($param)){

			$backtrace_array = debug_backtrace(false, 1);

			$current_directory_name = basename(dirname($backtrace_array[0]['file']));

			$addon_path=str_replace(ROOT_PATH, "\\", dirname(dirname($backtrace_array[0]['file'])));

			$addon_path=str_replace(DS, "\\", $addon_path);

			$logincModel=$addon_path."\\logic\\".$param;

			$entityModel=$addon_path."\\model\\".$param;

			// 如果有模块
			if($module){

				$logincModel="\\addon\\{$module}"."\\logic\\".$param;

				$entityModel="\\addon\\{$module}"."\\model\\".$param;

			}

			if($layer){

				$model_object=$layer==LAYER_CONTROLLER_NAME?$logincModel:$entityModel;

			}else{

				switch ($current_directory_name) {

			        case LAYER_CONTROLLER_NAME : $model_object = $logincModel; break;

			        case LAYER_LOGIC_NAME      : $model_object = $entityModel; break;

			        case LAYER_MODEL_NAME      : $model_object = $entityModel; break;

			        default                    : $return_object = null; break;
			    }
			}

			if(class_exists($model_object)){

				return new $model_object();

			}

			return null;
		}

		// 数组的情况下有参数m表示模块  l表示逻辑

		$module=$param['m'];

		$logic_name=isset($param['c']) && $param['c'] ? $param['c']:$param['m'];

		$logincModel="\\".ADDON_DIR_NAME."\\".$module."\\logic\\".StringHelper::s_format_class($logic_name);

		return new $logincModel();
	}
	/*
	* 插件里面的数据验证
	* name 插件名字
	*/
	final static function addonValidate($name){
		if(null==$name || empty($name) || ""==$name){
			return null;
		}

		$backtrace_array = debug_backtrace(false, 1);

		$addon_path=str_replace(ROOT_PATH, "\\", dirname(dirname($backtrace_array[0]['file'])));

		$addon_path=str_replace(DS, "\\", $addon_path);

		$validateModel=$addon_path."\\validate\\".$name;
		
		if(class_exists($validateModel)){

			return \think\Loader::validate($validateModel);

		}
		return null;

	}
}
?>