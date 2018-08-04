<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\backend\controller;
use \tpfcore\Core;
use \tpfcore\web\Curl;
class Index extends AdminBase
{
    public function index()
    {
        return $this->fetch("index",[
            'listMianNav'=>Core::loadModel("Menu")->getMenuArrTree(['parentid'=>0]),
        	'listTree'=>Core::loadModel("Menu")->getMenuArrTree(['display'=>1,'parentid'=>["gt","0"]],true)
        ]);
    }
    public function main(){
    	$mysql= \think\Db::query("select VERSION() as version");
    	$mysql=$mysql[0]['version'];
    	$mysql=empty($mysql)?L('UNKNOWN'):$mysql;
    	
        $validate_state=json_decode(Curl::post("http://validate.tpframe.com/authorize",['url'=>request()->url(true),'ip'=>request()->ip()]),true);
    	//server infomaions
    	$info = array(
    			"操作系统：" => PHP_OS,
    			"运行环境：" => $_SERVER["SERVER_SOFTWARE"],
    	        "PHP版本：" => PHP_VERSION,
    			"PHP运行方式：" => php_sapi_name(),
				"PHP版本：" => phpversion(),
    			"MYSQL版本：" =>$mysql,
    			"程序版本：" => config("version.tpframe_version").config("version.tpframe_release") . "&nbsp;&nbsp;&nbsp; [<a href='https://www.tpframe.com' target='_blank'>TPFrame</a>]",
                "授权状态："=>$validate_state['code']===0?"<font class='green'>已授权</font>":"<font class='red'><a href='https://www.tpframe.com/authorize/buy' target='_blank'>未授权</a></font>",
    			"上传附件限制：" => ini_get('upload_max_filesize'),
    			"执行时间限制：" => ini_get('max_execution_time') . "s",
    			"剩余空间：" => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
    	);

    	return $this->fetch("main",[
    		"server_info"=>$info
    	]);
    }
} 
