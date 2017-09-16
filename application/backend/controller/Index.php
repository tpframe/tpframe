<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\backend\controller;
use \tpfcore\Core;
class Index extends AdminBase
{
    public function index()
    {
        return $this->fetch("index",[
        	'listTree'=>Core::loadModel("Menu")->getMenuArrTree(['display'=>1],true)
        ]);
    }
    public function main(){
    	$mysql= \think\Db::query("select VERSION() as version");
    	$mysql=$mysql[0]['version'];
    	$mysql=empty($mysql)?L('UNKNOWN'):$mysql;
    	
    	//server infomaions
    	$info = array(
    			"操作系统" => PHP_OS,
    			"运行环境" => $_SERVER["SERVER_SOFTWARE"],
    	        "PHP版本" => PHP_VERSION,
    			"PHP运行方式" => php_sapi_name(),
				"PHP版本" => phpversion(),
    			"MYSQL版本" =>$mysql,
    			"程序版本" => TPFRAME_VERSION . "&nbsp;&nbsp;&nbsp; [<a href='http://www.tpframe.com' target='_blank'>TPFrame</a>]",
    			"上传附件限制" => ini_get('upload_max_filesize'),
    			"执行时间限制" => ini_get('max_execution_time') . "s",
    			"剩余空间" => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
    	);
    	//$this->assign('server_info', $info);

    	return $this->fetch("main",[
    		"server_info"=>$info
    	]);
    }
} 
