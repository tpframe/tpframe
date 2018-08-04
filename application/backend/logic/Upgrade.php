<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\backend\logic;
use tpfcore\web\Curl;
use tpfcore\helpers\FileHelper;
use tpfcore\util\PclZip;
use \tpfcore\util\Config;
use think\Db;
class Upgrade extends AdminBase
{
	public function check(){
		$upgrade_base_url="http://upgrade.tpframe.com/upgradelist.php";
		$param=[
			"version"=>config("version.tpframe_version"),
			"release"=>config("version.tpframe_release")
		];

		try{
			$return=json_decode(Curl::post($upgrade_base_url,$param),1);
		}catch(\Exception $e){
			$return = [];
		}

		$return=is_null($return) || empty($return)?[]:$return;

		return array_values($return);
	}
	// 程序开始更新
	public function doupdate($data){
		if(!isset($data['action'])){
			return [-1,"程序更新出错",["status"=>"error"]];
		}
		sleep(1);
		$oldversion=config("version.tpframe_version");
		$oldrelease=config("version.tpframe_release");
		set_time_limit(0);
		$save_dir="data/backup/upgrade_caches/";
		$backup_dir=ROOT_PATH."/data/backup/upgrade";

		$version=explode("_patch_", $data['version'])[0];
		$release=$data['release'];

		if($data['action']=="download"){
			$down_file="http://upgrade.tpframe.com/upgrade_package/".$data['version'];
			$down_return = FileHelper::getRemoteFile($down_file,$save_dir,false,1);
			session("down_return",$down_return);
			if($down_return['error_code']!=0){
				return [-1,"下载更新包".$data['version']."失败",['status'=>"error"]];
			}else{
				return [0,"更新包".$data['version']."下载成功",['status'=>"success","action"=>"uncompression","next_tip"=>"开始解压文件升级包"]];
			}
		}

		if($data['action']=="uncompression"){
			$down_return = session("down_return");
			$save_name=$down_return['save_path'];
			$archive=new PclZip($save_name);
			if($archive->extract(PCLZIP_OPT_PATH, $save_dir, PCLZIP_OPT_REPLACE_NEWER) == 0) {
				return [-1,"解压文件".$save_name."失败:".$archive->errorInfo(true),['status'=>"error"]];
			}else{
				return [0,"解压文件".$save_name."成功",['status'=>"success","action"=>"cover","next_tip"=>"准备备份原程序后进行覆盖"]];
			}
		}

		if($data['action']=="cover"){
			$copy_from = ROOT_PATH.$save_dir.$release;
			$copy_to = ROOT_PATH;
			
			$backup_dir=ROOT_PATH."data/backup/upgrade/".$oldversion."_".$oldrelease;
			$this->copyfailnum = 0;
			$this->copydir($copy_from, $copy_to, true,$backup_dir);
			
			//检查文件操作权限，是否复制成功
			if($this->copyfailnum > 0) {
				return [-1,"复制文件失败，请检查文件夹权限",['status'=>"error"]];
			}else{
				$upgrade_sql_path=$save_dir.$release.".sql";
				if(file_exists($upgrade_sql_path)){
					$action="execute_sql";
					$next_tip="准备执行sql文件";
				}else{
					$action="update_version";
					$next_tip="准备记录更新版本";
				}
				return [0,"成功复制文件",['status'=>"success","action"=>$action,"next_tip"=>$next_tip]];
			}
		}

		if($data['action']=="execute_sql"){
			$upgrade_sql_path=$save_dir.$release.".sql";
			if(file_exists($upgrade_sql_path)){
				try{
					$this->executeSql($upgrade_sql_path);
					return [0,"升级sql文件执行成功",['status'=>"success","action"=>"update_version","next_tip"=>"准备记录更新版本"]];
				}catch(\Exception $e){
					return [-1,"执行升级sql出错!，path:$upgrade_sql_path",['status'=>"error"]];
				}
			}
		}

		if($data['action']=="update_version"){
			$update_config=['tpframe_version'=>$version,'tpframe_release'=>$release];
			try{
				Config::updateConfig(APP_PATH."extra/version.php",$update_config);

				return [0,"成功记录更新版本",['status'=>"success","action"=>"delete_package","next_tip"=>"正在删除升级文件..."]];
			}catch(\Exception $e){
				return [-1,"更新版本记录失败!",['status'=>"error"]];
			}
		}

		if($data['action']=="delete_package"){
			$this->deletedir($save_dir);
			return [0,"升级文件包删除成功!",['status'=>"success","action"=>"install_success"]];
		}
		if($data['action']=="install_success"){
			return [0,"网站升级成功，你当前的版本为:".config("version.tpframe_version").",请先清空缓存后查看效果",['status'=>"success"]];
		}
	}
	
	private function showmsg($msg, $class = ''){
	    echo "<script type=\"text/javascript\">showmsg(\"{$msg}\", \"{$class}\")</script>";
	    flush();
    	ob_flush();
	    sleep(1);
	}
	/**
     * 执行插件sql
     */
    private function executeSql($name = '')
    {

        $sql_string = file_get_contents($name);

        $sql = explode(";\n", str_replace("\r", "\n", $sql_string));

        $tablepre=DB_PREFIX;

        $sql = str_replace(" `tpf_", " `{$tablepre}", $sql);

        foreach ($sql as $value) {
            
            $value=trim($value);

            !empty($value) && Db::execute($value);
        }
    }
	private function copydir($dirfrom, $dirto , $isbackup=false,$backup_dir="") {
	    //如果目录不存在，则建立之
	    if(!file_exists($dirto)){
	        mkdir($dirto,0777, true);
	    }
	    //如果目录不存在，则建立之
	    if(!file_exists($backup_dir)){
	        mkdir($backup_dir,0777, true);
	    }
	    
	    $handle = opendir($dirfrom); //打开当前目录
    
	    //循环读取文件
	    while(false !== ($file = readdir($handle))) {
	    	if($file != '.' && $file != '..'){ //排除"."和"."
		        //生成源文件名
			    $filefrom = $dirfrom.DIRECTORY_SEPARATOR.$file;
		     	//生成目标文件名
		        $fileto = $dirto.DIRECTORY_SEPARATOR.$file;
		        //生成要备份的文件名
		        $filebackup=$backup_dir.DIRECTORY_SEPARATOR.$file;
		        if(is_dir($filefrom)){ //如果是子目录，则进行递归操作
		            $this->copydir($filefrom, $fileto, $isbackup,$filebackup);
		        } else { //如果是文件，则直接用copy函数复制
		        	if($isbackup && file_exists($fileto)){
				    	if(!copy($fileto,$filebackup)){
				    		$this->copyfailnum++;
				    	}
		        	}
		        	if(!copy($filefrom, $fileto)) {
						$this->copyfailnum++;
					}
		        }
	    	}
	    }
	}
	
	private function deletedir($dirname){
	    $result = false;
	    if(!is_dir($dirname)){
	        return;
	    }
	    $handle = opendir($dirname); //打开目录
	    while(($file = readdir($handle)) !== false) {
	        if($file != '.' && $file != '..'){ //排除"."和"."
	            $dir = $dirname.DIRECTORY_SEPARATOR.$file;
	            //$dir是目录时递归调用deletedir,是文件则直接删除
	            is_dir($dir) ? $this->deletedir($dir) : unlink($dir);
	        }
	    }
	    closedir($handle);
	    $result = rmdir($dirname) ? true : false;
	    return $result;
	}
}