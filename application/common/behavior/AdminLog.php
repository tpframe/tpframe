<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// | Site home: http://www.tpframe.com
// +----------------------------------------------------------------------
namespace app\common\behavior;

use think\Db;
use tpfcore\Core;


class AdminLog
{
    /**
     * 行为入口
     */
    public function run(&$params)
    {
        $no_autho_action=["backend/user/login","backend/adminlog/index"];
        if((defined('ADDON_ADMIN_INC') || MODULE_NAME=="backend") && config("config.ADMIN_LOG_SWITCH") && !in_array(URL_MODULE, $no_autho_action)){
        	// 写入日志
        	$param=request()->param();
        	/* 过滤比较长的数据 */
        	foreach ($param as $key => $value) {
                if(is_array($value)) $value=json_encode($value);
        		if(mb_strlen($value,'UTF8')>800){
        			unset($param[$key]);
				}
        	}
        	$data['data']=json_encode($param);
        	$data['module']=MODULE_NAME;
        	$data['controller']=CONTROLLER_NAME;
        	$data['action']=ACTION_NAME;
        	$data['url']=request()->url(true);
        	$data['userid']=\think\Session::get("backend_author_sign")['userid'];
        	$data['username']=\think\Session::get("backend_author_sign")['username'];
        	$data['ip']=request()->ip();
        	$data['datetime']=time();
        
        	Db::name("AdminLog")->insert($data);

        }
    }
}
