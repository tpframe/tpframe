<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// | Site home: http://www.tpframe.com
// +----------------------------------------------------------------------

namespace app\common\controller;

use think\Controller;

/**
 * 系统通用控制器基类
 */
class ControllerBase extends Controller
{
    // 当前类名称
    protected $class;
    // 当前控制器名称
    protected $name;
    // 请求参数
    protected $param;
    // 请求的POST参数
    protected $post;
    
    /**
     * 基类初始化
     */
    protected function _initialize()
    {
        
        // 初始化请求信息
        $this->initRequestInfo();

        // 当前类名
        $this->class = get_called_class();

        if (empty($this->name)) {
            // 当前模型名
            $name       = str_replace('\\', '/', $this->class);
            $this->name = basename($name);
            if (\think\Config::get('class_suffix')) {
                $suffix     = basename(dirname($name));
                $this->name = substr($this->name, 0, -strlen($suffix));
            }
        }
    }
    
    /**
     * 初始化请求信息
     */
    final private function initRequestInfo()
    {
        
        defined('IS_POST')          or define('IS_POST',         $this->request->isPost());
        defined('IS_GET')           or define('IS_GET',          $this->request->isGet());
        defined('IS_AJAX')          or define('IS_AJAX',         $this->request->isAjax());
        defined('MODULE_NAME')      or define('MODULE_NAME',     $this->request->module());
        defined('CONTROLLER_NAME')  or define('CONTROLLER_NAME', $this->request->controller());
        defined('ACTION_NAME')      or define('ACTION_NAME',     $this->request->action());
        defined('URL')              or define('URL',             strtolower($this->request->controller() . '/' . $this->request->action()));
        defined('URL_MODULE')       or define('URL_MODULE',      strtolower($this->request->module()) . '/' . URL);
        
        $this->param = $this->request->param();
        $this->post = $this->request->post();
    }
    
    /**
     * 系统跳转
     */
    final protected function jump($status = '', $message = '', $url = null, $data = '')
    {
        
        is_array($status) && list($status, $message, $url) = $status;
        
        $success  = RESULT_SUCCESS;
        $error    = RESULT_ERROR;
        $redirect = RESULT_REDIRECT;
        
        // 分配跳转类型
        switch ($status) {

            case $success  : $this->$success($message, $url, $data);
            case $error    : $this->$error($message, $url, $data);
            case $redirect : $this->$redirect($url, $data);
            default        : return $data;
        }
    }
}
