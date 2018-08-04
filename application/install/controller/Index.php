<?php
namespace app\install\controller;
use app\common\controller\ControllerBase;
use \tpfcore\Core;
class Index extends ControllerBase {
    function _initialize(){
        parent::_initialize();
        if(@file_exists("./data/install.lock")){
            $this->redirect(SITE_PATH."/");
        }
        if (phpversion() <= '5.4.0') set_magic_quotes_runtime(0);
        if ('5.4.0' > phpversion()){
            header("Content-type:text/html;charset=utf-8");
            exit('您的php版本过低，不能安装本软件，请升级到5.4.0或更高版本再安装，谢谢！');
        }
    }
    //首页
    public function index() {
        session("_install_step",1);
        return $this->fetch(":index");
    }
    public function step1() {
        $this->redirect(SITE_PATH."/install/");
    }

    public function step2(){
        session("_install_step",2);
        try{
            if(file_exists(APP_PATH.'extra/database.php')){
                unlink(APP_PATH.'extra/database.php');
            }
        }catch(\Exception $e){
            echo $e->getMessage();
        }

        $data=array();
        $data['phpversion'] = @ phpversion();
        $data['os']=PHP_OS;
        $tmp = function_exists('gd_info') ? gd_info() : array();
        $server = $_SERVER["SERVER_SOFTWARE"];
        $host = (empty($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_HOST"] : $_SERVER["SERVER_ADDR"]);
        $name = $_SERVER["SERVER_NAME"];
        $max_execution_time = ini_get('max_execution_time');
        $allow_reference = (ini_get('allow_call_time_pass_reference') ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
        $allow_url_fopen = (ini_get('allow_url_fopen') ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
        $safe_mode = (ini_get('safe_mode') ? '<font color=red>[×]On</font>' : '<font color=green>[√]Off</font>');

        $err = 0;
        if (empty($tmp['GD Version'])) {
            $gd = '<font color=red>[×]Off</font>';
            $err++;
        } else {
            $gd = '<font color=green>[√]On</font> ' . $tmp['GD Version'];
        }

        if (class_exists('pdo')) {
            $data['pdo'] = '<i class="fa fa-check correct"></i> 已开启';
        } else {
            $data['pdo'] = '<i class="fa fa-remove error"></i> 未开启';
            $err++;
        }

        if (extension_loaded('pdo_mysql')) {
            $data['pdo_mysql'] = '<i class="fa fa-check correct"></i> 已开启';
        } else {
            $data['pdo_mysql'] = '<i class="fa fa-remove error"></i> 未开启';
            $err++;
        }

        if (extension_loaded('curl')) {
            $data['curl'] = '<i class="fa fa-check correct"></i> 已开启';
        } else {
            $data['curl'] = '<i class="fa fa-remove error"></i> 未开启';
            $err++;
        }

        if (extension_loaded('gd')) {
            $data['gd'] = '<i class="fa fa-check correct"></i> 已开启';
        } else {
            $data['gd'] = '<i class="fa fa-remove error"></i> 未开启';
            $err++;
        }

        if (extension_loaded('mbstring')) {
            $data['mbstring'] = '<i class="fa fa-check correct"></i> 已开启';
        } else {
            $data['mbstring'] = '<i class="fa fa-remove error"></i> 未开启';
            $err++;
        }

        if (extension_loaded('fileinfo')) {
            $data['fileinfo'] = '<i class="fa fa-check correct"></i> 已开启';
        } else {
            $data['fileinfo'] = '<i class="fa fa-remove error"></i> 未开启';
            $err++;
        }

        if (ini_get('file_uploads')) {
            $data['upload_size'] = '<i class="fa fa-check correct"></i> ' . ini_get('upload_max_filesize');
        } else {
            $data['upload_size'] = '<i class="fa fa-remove error"></i> 禁止上传';
        }

        if (function_exists('session_start')) {
            $data['session'] = '<i class="fa fa-check correct"></i> 支持';
        } else {
            $data['session'] = '<i class="fa fa-remove error"></i> 不支持';
            $err++;
        }

        $folders = array(
            'data',
            'data/assets',
            'data/uploads',
            'application/extra'
        );
        $new_folders=array();
        foreach($folders as $dir){
            $Testdir = "./".$dir;
            $this->dir_create($Testdir);
            if(is_writable($Testdir)){
                $new_folders[$dir]['w']=true;
            }else{
                $new_folders[$dir]['w']=false;
                $err++;
            }
            if(is_readable($Testdir)){
                $new_folders[$dir]['r']=true;
            }else{
                $new_folders[$dir]['r']=false;
                $err++;
            }
        }
        $data['folders']=$new_folders;

        $this->assign($data);
        return $this->fetch(":step2");
    }

    public function step3(){
        session("_install_step",3);
        return $this->fetch(":step3");
    }

    public function step4(){
        $this->assign("data",json_encode($this->post));
        return $this->fetch(":step4");
    }

    public function install(){
        if(IS_POST && isset($this->post['action'])){
            sleep(1);
            $action=$this->post['action'];
            switch ($action) {

                case 'database': 
                $result=Core::loadModel("Database")->createDatabase($this->post);
                if($result[0]==0){
                    session("db_connect",$result[2]['db']);
                }
                $this->jump($result); 
                break;
                
                case 'executeSql':  
                    $this->jump(Core::loadModel("Database")->executeSql(session("db_connect"),$this->post));
                    break;

                case 'update_site_config':  
                    $this->jump(Core::loadModel("Database")->update_site_config(session("db_connect"),$this->post));
                    break;
                    
                case 'create_admin_account':  
                    $this->jump(Core::loadModel("Database")->create_admin_account(session("db_connect"),$this->post));
                    break;        

                case 'create_site_config':  
                    $this->jump(Core::loadModel("Database")->create_site_config(session("db_connect"),$this->post));
                    break;

                case 'create_config':  
                    $this->jump(Core::loadModel("Database")->create_config(session("db_connect")));
                    break;
                    
                case 'create_version':
                    session("_install_step",4);
                    $this->jump(Core::loadModel("Database")->create_version(session("db_connect")));
                    break;

                default:
                    $this->jump([-1,"安装出错",['status'=>'error']]);
                    break;
            }
        }else{
            $this->jump([-1,"非法安装程序！",['status'=>'error']]);
        }
    }

    public function step5(){
        if(session("_install_step")==4){
            @touch('./data/install.lock');
            $this->curl_post("http://www.tpframe.com/taskmger/install",['domain'=>$_SERVER['HTTP_HOST'],'ip'=>request()->ip()]);
            session(null);
            return $this->fetch(":step5");
        }else{
            $this->error("非法安装！");
        }
    }

    public function checkpass(){
        if(IS_POST){
            $dbconfig=$this->post;
            $dbconfig['type']="mysql";
            return Core::loadModel("Database")->checkpass($dbconfig);
        }else{
            return ['errcode'=>1,"errmsg"=>"post request"];
        }
    }
    public function dir_create($path, $mode = 0777){
        if (is_dir($path)) return true;
        $ftp_enable = 0;
        $temp = explode('/', $path);
        $cur_dir = '';
        $max = count($temp) - 1;
        for ($i = 0; $i <= $max; $i++) {
            $cur_dir .= $temp[$i] . '/';
            if (@is_dir($cur_dir))
                continue;
            @mkdir($cur_dir, 0777, true);
            @chmod($cur_dir, 0777);
        }
        return true;
    }

    /**
     * 模拟post进行url请求
     * @param string $url
     * @param string $param
     */
    private function curl_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        
        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        
        return $data;
    }
}

