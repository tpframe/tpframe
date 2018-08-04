<?php
namespace app\install\service;

use app\common\model\ModelBase;
use \tpfcore\Core;
use \tpfcore\helpers\StringHelper;
/*	
*	服务层基类
*/
class Database extends ModelBase
{
	public function createDatabase($data){
		return Core::loadModel($this->name)->createDatabase($data);
	}
	public function checkpass($dbconfig){
		return Core::loadModel($this->name)->checkpass($dbconfig);
	}

	// 执行sql
	public function executeSql($db,$data){
		return Core::loadModel($this->name)->executeSql($db,"tpframe.sql",$data);
	}
	//更新配置信息
	public function update_site_config($db, $data){
		return Core::loadModel($this->name)->update_site_config($db, $data);
	}

	//创建管理员
	public function create_admin_account($db,$data){

		$data_encrypt_key=StringHelper::get_random_string(32);

		session("data_encrypt_key",$data_encrypt_key);

		return Core::loadModel($this->name)->create_admin_account($db, $data,$data_encrypt_key);	
	}

	//生成网站配置文件
	public function create_site_config($db,$data){

		$data_encrypt_key = session("data_encrypt_key");

		return Core::loadModel($this->name)->create_site_config($data,$data_encrypt_key);	
	}

	//生成网站配置
	public function create_config($db){
		return Core::loadModel($this->name)->create_config();
	}

	//记录网站版本与安装时候
	public function create_version($db){
		return Core::loadModel($this->name)->create_version();
	}

	// 老方法
	public function startInstall($db,$data){
		$object=Core::loadModel($this->name);
		$db->startTrans();
		try{
			//执行sql语句
	        $object->executeSql($db,"tpframe.sql",$data);

	        //更新配置信息
	        $object->update_site_config($db, $data);
	        
	        $data_encrypt_key=StringHelper::get_random_string(18);

	        //创建管理员
	        $object->create_admin_account($db, $data,$data_encrypt_key);
	        
	        //生成网站配置文件
	        $object->create_database($data,$data_encrypt_key);

	        //生成网站配置
	        $object->create_config();

	        //记录网站版本与安装时候
	        $object->create_version();

	        $db->commit();
	    }catch (\Exception $e) {
		    // 回滚事务
		    $db->rollback();
		    throw new \Exception($e->getMessage());
		}
	}
}
?>