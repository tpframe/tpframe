<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\common\logic;
use \tpfcore\Core;
use think\Validate;
use think\Db;
use tpfcore\storage\AliyunOss;
use tpfcore\storage\Qiniu;
use OSS\Core\OssException;
use think\Request;
/**
 * Admin基础逻辑
 */
class ControllerBase extends LogicBase
{
	/*
		传递的数据必须要有下面的一些值 ，不然就不通过
		$table 	表名
		$colum  列名
		$columval  列值
		$key 主键名
		$keyval  主键值
	*/
	public function ajaxdata($data){
		$validate = new Validate(["table"=>"require","colum"=>"require","columval"=>"require","key"=>"require","keyval"=>"require|regex:\d+"]);
		if(!$validate->check($data)){
		    return [-4,$validate->getError(),null];
		}
		extract($data);
		$result=Db::name($table)->update([$key=>$keyval,$colum=>$columval]);
		if($result){
			return [1, '操作成功',null];
		}
		return [0, '操作失败',null];
	}

	public function upload(){
		if(request()->file()){
            $upload_position = empty(config("config.upload_pic_position"))?"local":config("config.upload_pic_position");
            $size=empty(config("config.allow_upload_pic_size"))?2*1024*1024:config("config.allow_upload_pic_size")*1024;
            $ext=empty(config("config.allow_upload_pic_type"))?'jpg,png,gif':config("config.allow_upload_pic_type");
            /*
                可上传多张图片
            */
            $urls=[];
            $index=0;
            foreach ($_FILES as $key => $value) {
                if($value['error']!=0) continue;
                $object = request()->file($key)->validate(['size'=>$size,'ext'=>$ext]);
                if($object->check()){
                    $suffix=pathinfo($object->getInfo('name'),PATHINFO_EXTENSION);   //取得后缀
                    // 要上传的文件
                    $tmp_file = $object->getRealPath();  
                    //保存云端的路径名
                    $filename="data/uploads/".date('Ymd') . "/" . md5(microtime(true)).".$suffix";
                    $urls[$index] = "/".$filename;
                    //上传到七牛云
                    if($upload_position == "qiniu"){
                        $listConfig = Core::loadAddonModel("Qiniu","qiniu","controller")->getConfig("qiniu");
                        if(empty($listConfig) || $listConfig['status']==0){
                            return [40045,"请先安装或配置好七牛云"];
                        }
                        $config = json_decode($listConfig['config'],true);
                        
                        $qiniu = new Qiniu($config['config']);

                        $list = Core::loadAddonModel("Bucket","qiniu","controller")->getBucket(["where"=>["channel"=>"qiniu"],"order"=>"is_default desc","limit"=>1]);

                        if(empty($list)){

                            return ["error"=>DATA_NORMAL,"message"=>"请配置好你的bucket"];
                        }
                        $bucket = $list[0]['name'];

                        $result = $qiniu->putFile($bucket,$filename, $tmp_file);

                        if(!$result){
                            return [40045,$qiniu->getErrorMsg()];
                        }

                        if(empty($list[0]['oss_img_url'])){
                            $domain = "http://".$list[0]['endpoint']."/";
                            $urls[$index] = $domain.$filename; 
                        }else{
                            $urls[$index] = $list[0]['oss_img_url']."/".$filename; 
                        }

                    }

                    //上传到阿里云
                    elseif($upload_position=="aliyun_oss") {
                        $listConfig = Core::loadAddonModel("AliyunOss","aliyun_oss","controller")->getConfig("aliyun_oss");

                        if(empty($listConfig) || $listConfig['status']==0){
                            return [40045,"请先安装或配置好OSS"];
                        }
                        $config = json_decode($listConfig['config'],true);

                        $list = Core::loadAddonModel("Bucket","aliyun_oss","controller")->getBucket(["where"=>["channel"=>"aliyun_oss"],"order"=>"is_default desc","limit"=>1]);

                        if(empty($list)){

                            return [40045,"请配置好你的bucket"];
                        }

                        $config["config"]['endpoint']=$list[0]['endpoint'];
                        $config["config"]['bucket']=$list[0]['name'];
                        try {
                            $aliyun_oss = new AliyunOss($config['config']);
                            if(!$aliyun_oss->uploadFile($tmp_file,$filename)){
                                return [40045,$aliyun_oss->getErrorMsg()];
                            }

                            $urls[$index]=empty($list[0]['oss_img_url'])?"https://".$list[0]['name'].".".$list[0]['endpoint']."/".$filename:$list[0]['oss_img_url']."/".$filename;

                        } catch (\OssException $e) {
                            return [40045,$e->getErrorMsg()];
                        }
                    }else{

                        $info = $object->move(UPLOAD_PATH);

                        if ($info) {

                            $save_name = $info->getSaveName();
                            
                            $picture_dir_name = substr($save_name, 0, strrpos($save_name, DS));
                            
                            $filename = $info->getFilename();
                            
                            $url = UPLOAD_PATH_RELATIVE.$picture_dir_name."/".$filename;

                            $urls[$index]=parse_url($url)['path'];

                        } else {
                            return [40045,$object->getError()];
                        }
                    }
                    $index++;
                }
            }
            return [0,"上传成功",$urls];
        }else{
            return [40024,"没有上传的文件"];
        }
	}

	public function kd_upload(){
		if(request()->file()){
            $upload_position = empty(config("config.upload_pic_position"))?"local":config("config.upload_pic_position");
            $size=empty(config("config.allow_upload_pic_size"))?2*1024*1024:config("config.allow_upload_pic_size")*1024;
            $ext=empty(config("config.allow_upload_pic_type"))?'jpg,png,gif':config("config.allow_upload_pic_type");
            $key = array_keys($_FILES)[0];

            $object = request()->file($key)->validate(['size'=>$size,'ext'=>$ext]);

            if($object->check()){

                $suffix=pathinfo($object->getInfo('name'),PATHINFO_EXTENSION);   //取得后缀
                // 要上传的文件
                $tmp_file = $object->getRealPath();  
                //保存云端的路径名
                $filename="data/uploads/".date('Ymd') . "/" . md5(microtime(true)).".$suffix";

                //上传到七牛云
                if($upload_position == "qiniu"){
                    $listConfig = Core::loadAddonModel("Qiniu","qiniu","controller")->getConfig("qiniu");
                    if(empty($listConfig) || $listConfig['status']==0){
                        return [40045,"请先安装或配置好七牛云"];
                    }
                    $config = json_decode($listConfig['config'],true);
                    
                    $qiniu = new Qiniu($config['config']);

                    $list = Core::loadAddonModel("Bucket","qiniu","controller")->getBucket(["where"=>["channel"=>"qiniu"],"order"=>"is_default desc","limit"=>1]);

                    if(empty($list)){

                        return ["error"=>DATA_NORMAL,"message"=>"请配置好你的bucket"];
                    }
                    $bucket = $list[0]['name'];

                    $result = $qiniu->putFile($bucket,$filename, $tmp_file);

                    if(!$result){
                        return ["error"=>DATA_NORMAL,"message"=>$qiniu->getErrorMsg()];
                    }else{

                        if(empty($list[0]['oss_img_url'])){
                            $domain = "http://".$list[0]['endpoint']."/";
                            $filename = $domain.$filename; 
                        }else{
                            $filename= $list[0]['oss_img_url']."/".$filename; 
                        }
                        return ['error' => DATA_DISABLE, 'url' => $filename , 'img_url'=>$filename];
                    }
                }

                //上传到阿里云
                elseif($upload_position=="aliyun_oss") {
                    $listConfig = Core::loadAddonModel("AliyunOss","aliyun_oss","controller")->getConfig("aliyun_oss");

                    if(empty($listConfig) || $listConfig['status']==0){
                        return ["error"=>DATA_NORMAL,"message"=>"请先安装或配置好OSS"];
                    }
                    $config = json_decode($listConfig['config'],true);

                    $list = Core::loadAddonModel("Bucket","aliyun_oss","controller")->getBucket(["where"=>["channel"=>"aliyun_oss"],"order"=>"is_default desc","limit"=>1]);

                    if(empty($list)){

                        return ["error"=>DATA_NORMAL,"message"=>"请配置好你的bucket"];
                    }

                    $config["config"]['endpoint']=$list[0]['endpoint'];
                    $config["config"]['bucket']=$list[0]['name'];
                    try {
                        $aliyun_oss = new AliyunOss($config['config']);

                        if(!$aliyun_oss->uploadFile($tmp_file,$filename)){
                            return ["error"=>DATA_NORMAL,"message"=>$aliyun_oss->getErrorMsg()];
                        }

                        $url=empty($list[0]['oss_img_url'])?"https://".$list[0]['name'].".".$list[0]['endpoint']."/".$filename:$list[0]['oss_img_url']."/".$filename;
                        
                        return ['error' => DATA_DISABLE, 'url' => $url , 'img_url'=>$url];

                    } catch (\OssException $e) {
                        return ["error"=>DATA_NORMAL,"message"=>$e->getErrorMsg()];
                    }
                }
                // 存储在本地
                else{
                    $info = $object->move(UPLOAD_PATH);
                    if ($info) {

                        $save_name = $info->getSaveName();
                        
                        $picture_dir_name = substr($save_name, 0, strrpos($save_name, DS));
                        
                        $filename = $info->getFilename();
                        
                        $url = UPLOAD_PATH_RELATIVE.$picture_dir_name."/".$filename;

                        $absolutely_url=parse_url($url)['path'];

                        return ['error' => DATA_DISABLE, 'url' => $url , 'img_url'=>$absolutely_url];

                    } else {
                        return ["error"=>DATA_NORMAL,"message"=>$object->getError()];
                    }
                }
            }else{
                return ["error"=>DATA_NORMAL,"message"=>$object->getError()];
            }
        }else{
            return ["error"=>DATA_NORMAL,"message"=>"没有要上传的文件"];
        }
	}
}