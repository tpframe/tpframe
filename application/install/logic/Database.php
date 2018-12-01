<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\install\logic;

use app\common\logic\LogicBase;
use think\Db;
use think\Request;
/**
 * 数据库基础逻辑
 */
class Database extends LogicBase
{
	public function checkpass($data){
		$conn=Db::connect($data);
		try{
           $result=$conn->query("show databases;");
           return ['errcode'=>0,"errmsg"=>"连接成功"];
        }catch (\Exception $e){
            return ['errcode'=>1,"errmsg"=>"用户名或密码错误".$e->getMessage()];
        }
	}
	public function createDatabase($data){
		//创建数据库
        $dbconfig['type']="mysql";
        $dbconfig['hostname']=$data['dbhost'];
        $dbconfig['username']=$data['dbuser'];
        $dbconfig['password']=$data['dbpw'];
        $dbconfig['hostport']=$data['dbport'];
        $db  = Db::connect($dbconfig);
        $dbname=strtolower($data['dbname']);
        $sql = "CREATE DATABASE IF NOT EXISTS `{$dbname}` DEFAULT CHARACTER SET utf8";
        $result=$db->execute($sql);
        if($result){
        	$dbconfig['database']=$dbname;
        	$dbconfig['prefix']=trim($data['dbprefix']);
        	return [0,"数据库安装成功",['db'=>Db::connect($dbconfig),'action'=>'executeSql','status'=>'success']];
        }else{
        	return [-1,"数据库安装失败",['status'=>'error']];
        }  
	}
	public function executeSql($db,$file,$data){

		$tablepre=$data['dbprefix'];

		$module_path=dirname(dirname(__FILE__));

		if(!session("?install_sql")){
			//读取SQL文件
	   	 	$install_sql = $this->export_sql($module_path . '/data/'.$file, $tablepre);
	   	 	session("install_sql",$install_sql);
		}else{
			$install_sql=session("install_sql");
		}
		/*echo "<pre/>";
		print_r($install_sql);*/
		if(empty($install_sql) || !is_array($install_sql)){
			return [-1,"安装sql解析错误",['status'=>'error']];
		}
	    
	    $sql_curr_index = isset($data['install_sql_index']) && is_numeric($data['install_sql_index'])?$data['install_sql_index']:0;

	    if($sql_curr_index>=count($install_sql)){

	    	return [0,"SQL安装完成",['status'=>'success','action'=>'update_site_config']];

	    }

	    $sql_curr = $install_sql[$sql_curr_index].";";

    	set_time_limit(0);
        $sql_curr = trim($sql_curr);

        preg_match('/CREATE TABLE .+ `([^ ]*)`/', $sql_curr, $matches);

        if($matches) {
            $table_name = $matches[1];
            $msg  = "创建数据表{$table_name}";
            try{
	            $db->execute($sql_curr);
	            return [0,$msg."成功",['status'=>"success","action"=>"executeSql"]];
	        }catch(\Exception $e){
	        	return [-1,$msg."失败".$e->getMessage(),['status'=>"error"]];
	        }
        } else {
        	try{
            	$db->execute($sql_curr);
            	return [0,"SQL语句执行成功",['status'=>"success","action"=>"executeSql"]];
        	}catch(\Exception $e){
        		return [-1,"SQL语句执行失败".$e->getMessage(),['status'=>"error"]];
        	}
        }
		    
	}
	private function export_sql($file, $tablepre, $charset = 'utf8mb4')
    {
        if (file_exists($file)) {
            //读取SQL文件
            $sql = file_get_contents($file);
            $sql = str_replace("\r", "\n", $sql);
            $sql = str_replace("BEGIN;\n", '', $sql);
            $sql = str_replace("COMMIT;\n", '', $sql);
            $sql = str_replace('utf8mb4', $charset, $sql);
            $sql = trim($sql);
            //替换表前缀
            $sql  = str_replace(" `tpf_", " `{$tablepre}", $sql);
            $sqls = explode(";\n", $sql);
            return $sqls;
        }

        return [];
    }
	public function update_site_config($db,$data){
		try{
			$tablepre=$data['dbprefix'];
			$sitename=$data["sitename"];
		    $email=$data["manager_email"];
		    $siteurl=$data["siteurl"];
		    $seo_keywords=$data["sitekeywords"];
		    $seo_description=$data["siteinfo"];
			$site_options="{
				\"site_name\":\"$sitename\",
				\"landline\":\"\",
				\"toll_free\":\"\",
				\"address\":\"\",
				\"site_icp\":\"\",
				\"site_admin_email\":\"$email\",
				\"site_tongji\":\"\",
				\"site_copyright\":\"\",
				\"site_seo_title\":\"$sitename\",
				\"site_seo_keywords\":\"$seo_keywords\",
				\"site_seo_description\":\"$seo_description\",
				\"urlmode\":\"0\",
				\"html_suffix\":\"\",
				\"ucenter_enabled\":\"0\",
				\"comment_need_check\":\"0\",
				\"comment_time_interval\":\"60\",
				\"banned_usernames\":\"\",
				\"site_host\":\"$siteurl\",
				\"site_root\":\"\"
			}";
		    $sql="INSERT INTO `{$tablepre}setting` (options,sign) VALUES ('$site_options','site_options')";
		    $db->execute($sql);
		    return [0,"网站信息配置成功!",['action'=>'create_admin_account','status'=>'success']];
		}catch(\Exception $e){
			return [-1,"安装网站配置失败!".$e->getMessage(),['status'=>'error']];
		}
	}
	public function create_config(){
		 $site_options="<?php return array (
  'DEFAULT_THEME' => 'default',
  'HTML_CACHE_ON' => 0,
  'ADMIN_LOG_SWITCH' => 0,
  'WEB_SITE_CLOSE' => 0,
  'ADMIN_LOGIN_LLIMIT_IP'=>'',
  'ADMIN_LOGIN_VERIFY_SWITCH'=>0,
  'allow_upload_pic_type'=>'jpg,png,gif,bmp',
  'allow_upload_pic_size'=>2048,
  'upload_pic_position' => 'local'
);";
		//写入配置文件
        if(file_put_contents(APP_PATH.'extra/config.php', $site_options)){
            return [0,'基本配置文件写入成功!',['action'=>'create_version','status'=>'success']];
        } else {
            return [-1,'基本配置文件写入失败！',['status'=>'error']];
        }
	}
	public function create_admin_account($db,$data,$data_encrypt_key){
		try{
			$tablepre=$data['dbprefix'];
			$username=$data["manager"];
		    $password='###'.md5($data["manager_pwd"].$data_encrypt_key);
		    $email=$data["manager_email"];
		    $create_date=time();
		    $ip=\think\Request::instance()->ip(0,true);
		    $sql ="
		    INSERT INTO `{$tablepre}user` 
		    (id,username,password,nickname,email,url,create_time,grade,last_login_ip,last_login_time) VALUES 
		    ('1', '{$username}', '{$password}', 'admin', '{$email}', '', '{$create_date}', 1, '{$ip}','{$create_date}');";
		    $db->execute($sql);
		    return [0,'管理员账号创建成功!',['action'=>'create_site_config','status'=>'success']];
		}catch(\Exception $e){
			return [-1,'管理员账号创建失败! 失败原因：'.$e->getMessage(),['status'=>'error']];
		}
	}
	public function create_site_config($data,$data_encrypt_key){
		if(is_array($data)){
			try{
				$hostname=$data['dbhost'];
				$database=strtolower($data['dbname']);
				$username=$data['dbuser'];
				$password=$data['dbpw'];
				$hostport=$data['dbport'];
				$prefix=$data['dbprefix'];
		        $conf="<?php
\$local_database=require('database-local.php');
/**
 * 配置文件
 */
\$database=array(
    'type' => 'mysql',
    'hostname' => '{$hostname}',
    'database' => '{$database}',
    'username' => '{$username}',
    'password' => '{$password}',
    'hostport' => '{$hostport}',
    'prefix' => '{$prefix}',
    
    'DATA_ENCRYPT_KEY'	=> '$data_encrypt_key'
);
return array_merge(\$database,\$local_database);";
		        //写入应用配置文件
		        if(file_put_contents(APP_PATH.'extra/database.php', $conf)){
		            return [0,'配置文件写入成功!',['action'=>'create_config','status'=>'success']];
		        } else {
		            return [-1,'配置文件写入失败！',['status'=>'error']];
		        }
	    	}catch(\Exception $e){
				return [-1,'配置文件写入失败！'.$e->getMessage(),['status'=>'error']];
	    	}
    	}
	}
	public function create_version(){
		try{
				$tpframe_version=config("tpframe_version");
				$tpframe_release=config("tpframe_release");
		        $conf="<?php
return [
	'tpframe_version'=>'$tpframe_version',
	'tpframe_release'=>'$tpframe_release'
];";
		        //写入应用配置文件
		        if(file_put_contents(APP_PATH.'extra/version.php', $conf)){
		            return [0,'版本记录文件写入成功',['status'=>'success']];
		        } else {
		            return [-1,'版本记录文件写入失败！',['status'=>'error']];
		        }
	    	}catch(\Exception $e){
				return [-1,'版本记录文件写入失败！'.$e->getMessage(),['status'=>'error']];
	    	}
	}
	public function show_msg($msg, $class = ''){
	    echo "<script type=\"text/javascript\">showmsg(\"{$msg}\", \"{$class}\")</script>";
	    flush();
    	ob_flush();
	    sleep(0.8);
	}
}