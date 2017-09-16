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
            return ['errcode'=>1,"errmsg"=>"用户名或密码错误"];
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
        	return Db::connect($dbconfig);
        }else{
        	return false;
        }  
	}
	public function executeSql($db,$file,$data){
		try{
			$tablepre=$data['dbprefix'];
			$module_path=dirname(dirname(__FILE__));
		    //读取SQL文件
		    $sql = file_get_contents($module_path . '/data/'.$file);
		    $sql = str_replace("\r", "\n", $sql);
		    $sql = explode(";\n", $sql);
		    //替换表前缀

		    $default_tablepre = "t_";
		    $sql = str_replace(" `{$default_tablepre}", " `{$tablepre}", $sql);
		    //开始安装
		    $this->show_msg('开始安装数据库...');
		    foreach ($sql as $item) {
		    	set_time_limit(0);
		        $item = trim($item);
		        if(empty($item)) continue;
		        preg_match('/CREATE TABLE `([^ ]*)`/', $item, $matches);
		        if($matches) {
		            $table_name = $matches[1];
		            $msg  = "创建数据表{$table_name}";
		            if(false!== $db->execute($item)){
		                $this->show_msg($msg . ' 完成');
		            } else {
		               	$this->show_msg($msg . ' 失败！', 'error');
		            }
		        } else {
		        	// $this->show_msg('正在创建数据');
		            $db->execute($item);
		        }
		    }
		}catch(\Exception $e){
			$this->show_msg("安装数据库失败!", 'error');
			throw new \Exception('安装数据库失败'); 
		}
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
				\"site_tpl\":\"\",
				\"mobile_tpl_enabled\":\"0\",
				\"html_cache_on\":\"0\",
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
		    $this->show_msg("网站信息配置成功!");
		}catch(\Exception $e){
			$this->show_msg("安装网站配置失败!", 'error');
			throw new \Exception('安装网站配置失败'); 
		}
	}
	public function create_admin_account($db,$data,$data_encrypt_key){
		try{
			$tablepre=$data['dbprefix'];
			$username=$data["manager"];
		    $password='###'.md5($data["manager_pwd"].$data_encrypt_key);
		    $email=$data["manager_email"];
		    $create_date=date("Y-m-d h:i:s");
		    $ip=\think\Request::instance()->ip(0,true);
		    $sql ="
		    INSERT INTO `{$tablepre}user` 
		    (id,username,password,nickname,email,url,create_time,grade,last_login_ip,last_login_time) VALUES 
		    ('1', '{$username}', '{$password}', 'admin', '{$email}', '', '{$create_date}', 1, '{$ip}','{$create_date}');";
		    $db->execute($sql);
		    $this->show_msg("管理员账号创建成功!");
		}catch(\Exception $e){
			$this->show_msg("管理员账号创建失败!", 'error');
			throw new \Exception('管理员账号创建失败'); 
		}
	}
	public function create_config($data,$data_encrypt_key){
		if(is_array($data)){
			try{
				$hostname=$data['dbhost'];
				$database=$data['dbname'];
				$username=$data['dbuser'];
				$password=$data['dbpw'];
				$hostport=$data['dbport'];
				$prefix=$data['dbprefix'];
				$tpframe_version=\think\Config::get("TPFRAME_VERSION");
		        $conf="<?php
/**
 * 配置文件
 */
return array(
    'type' => 'mysql',
    'hostname' => '{$hostname}',
    'database' => '{$database}',
    'username' => '{$username}',
    'password' => '{$password}',
    'hostport' => '{$hostport}',
    'prefix' => '{$prefix}',
    
    'DATA_ENCRYPT_KEY'	=> '$data_encrypt_key',
    'TPFRAME_VERSION'	=> '$tpframe_version',
);";
		        //写入应用配置文件
		        if(file_put_contents('data/conf/database.php', $conf)){
		            $this->show_msg('配置文件写入成功');
		        } else {
		            $this->show_msg('配置文件写入失败！', 'error');
		        }
	    	}catch(\Exception $e){
	    		$this->show_msg("配置文件写入失败！", 'error');
				throw new \Exception('配置文件写入失败！'); 
	    	}
    	}
	}
	public function show_msg($msg, $class = ''){
	    echo "<script type=\"text/javascript\">showmsg(\"{$msg}\", \"{$class}\")</script>";
	    flush();
    	ob_flush();
	    sleep(0.8);
	}
}