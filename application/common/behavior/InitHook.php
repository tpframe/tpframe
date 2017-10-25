<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
/**
 * ============================================================================
 * 版权所有 2017-2077 tpframe工作室，并保留所有权利。
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！未经本公司授权您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 */
namespace app\common\behavior;

use think\Hook;
use tpfcore\Core;

/**
 * 初始化钩子信息行为
 */
class InitHook
{
    /**
     * 行为入口
     */
    public function run()
    {
        if(!file_exists('data/conf/database.php')) return ;

        $HookModel  = model(MODULE_COMMON_NAME.'/Hook');
        
        $AddonModel = model(MODULE_COMMON_NAME.'/Addon');
        
        $hook_list = $HookModel->column('name,addon_list');

        foreach ($hook_list as $k => $v) {
            
            if (empty($v)) {
                continue;
            }
            $where[DATA_STATUS] = DATA_NORMAL;
            $name_list = explode(',', $v);
            $where['name'] = ['in', $name_list];

            $data = $AddonModel->where($where)->column('id,name'); 
            $dataType = $AddonModel->where($where)->column('id,type');
            !empty($data) && Hook::add($k, array_map(array(new Core(),"get_addon_class"),$dataType, array_intersect($name_list, $data)));
        }
    }
}
