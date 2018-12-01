<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\common\logic;
use \tpfcore\Core;
use think\Validate;
use think\Db;
use tpfcore\storage\AliyunOss;
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
            $request = Request::instance();

            $size=empty(config("config.allow_upload_pic_size"))?2*1024*1024:config("config.allow_upload_pic_size")*1024;
            
            $ext=empty(config("config.allow_upload_pic_type"))?'jpg,png,gif':config("config.allow_upload_pic_type");
            /*
                可上传多张图片
            */
            $urls=[];
            $index=0;
            foreach ($_FILES as $key => $value) {
                if($value['error']!=0) continue;
                $file = request()->file($key);
                $info = $file->validate(['size'=>$size,'ext'=>$ext])->move(UPLOAD_PATH);
                if($info){
                    $savename = str_replace("\\","/",$info->getSaveName());
                    $relative_url="data/uploads/".$savename;
                    $urls[$index] = $absolutely_url="/".$relative_url;

                    $upload_position = empty(config("config.upload_pic_position"))?"local":config("config.upload_pic_position");
                    //上传到阿里云
                    if($upload_position=="aliyun_oss") {
                        $listConfig = Core::loadAddonModel("AliyunOss","aliyun_oss","controller")->getConfig("aliyun_oss");

                        if(empty($listConfig) || $listConfig['status']==0){
                            return [40044,"请先安装或配置好OSS"];
                        }
                        $config = json_decode($listConfig['config'],true);

                        $list = Core::loadAddonModel("OssBucket","aliyun_oss","controller")->getOssBucket(["order"=>"is_default desc","limit"=>1]);

                        if(empty($list)){

                            return [40044,"请配置好你的bucket"];
                        }

                        $config["config"]['endpoint']=$list[0]['endpoint'];
                        $config["config"]['bucket']=$list[0]['name'];
                        try {
                            $aliyun_oss = new AliyunOss($config['config']);
                            if(!$aliyun_oss->uploadFile($relative_url,$relative_url)){
                                return [40044,$aliyun_oss->getErrorMsg()];
                            }

                            $urls[$index]=empty($list[0]['oss_img_url'])?"https://".$list[0]['name'].".".$list[0]['endpoint'].$absolutely_url:$list[0]['oss_img_url'].$absolutely_url;     

                            unset($info);
                            // 上传成功后删除原图片
                            unlink($relative_url);
                            
                        } catch (\OssException $e) {
                            return [40044,$e->getMessage()];
                        }
                    }

                }else{
                    // 上传失败获取错误信息
                    return ["40023",$file->getError()];
                }
                $index++;
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
            $object = request()->file($key);
            $info = $object->validate(['size'=>$size,'ext'=>$ext])->move(UPLOAD_PATH);
            
            if ($info) {

                $save_name = $info->getSaveName();
                
                $picture_dir_name = substr($save_name, 0, strrpos($save_name, DS));
                
                $filename = $info->getFilename();
                
                $url = UPLOAD_PATH_RELATIVE.$picture_dir_name."/".$filename;

                $relative_url= "data/uploads/".$picture_dir_name."/".$filename;

                $absolutely_url=parse_url($url)['path'];

                //上传到阿里云
                if($upload_position=="aliyun_oss") {
                    $listConfig = Core::loadAddonModel("AliyunOss","aliyun_oss","controller")->getConfig("aliyun_oss");

                    if(empty($listConfig) || $listConfig['status']==0){
                        return ["error"=>DATA_NORMAL,"message"=>"请先安装或配置好OSS"];
                    }
                    $config = json_decode($listConfig['config'],true);

                    $list = Core::loadAddonModel("OssBucket","aliyun_oss","controller")->getOssBucket(["order"=>"is_default desc","limit"=>1]);

                    if(empty($list)){

                        return ["error"=>DATA_NORMAL,"message"=>"请配置好你的bucket"];
                    }

                    $config["config"]['endpoint']=$list[0]['endpoint'];
                    $config["config"]['bucket']=$list[0]['name'];
                    try {
                        $aliyun_oss = new AliyunOss($config['config']);
                        if(!$aliyun_oss->uploadFile($relative_url,$relative_url)){
                            return ["error"=>DATA_NORMAL,"message"=>$aliyun_oss->getErrorMsg()];
                        }

                        $absolutely_url = $url=empty($list[0]['oss_img_url'])?"https://".$list[0]['name'].".".$list[0]['endpoint'].$absolutely_url:$list[0]['oss_img_url'].$absolutely_url;

                        unset($info);
                        // 上传成功后删除原图片
                        unlink($relative_url);
                        
                    } catch (\OssException $e) {
                        return ["error"=>DATA_NORMAL,"message"=>$e->getMessage()];
                    }
                }

                return ['error' => DATA_DISABLE, 'url' => $url , 'img_url'=>$absolutely_url];

            } else {
                return ["error"=>DATA_NORMAL,"message"=>$object->getError()];
            }
        }else{
            return ["error"=>DATA_NORMAL,"message"=>"没有要上传的文件"];
        }
	}
}