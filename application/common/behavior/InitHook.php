<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// | Site home: http://www.tpframe.com
// +----------------------------------------------------------------------
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
        if(!file_exists(APP_PATH.'extra/database.php')) return ;

        $HookModel  = model(MODULE_COMMON_NAME.'/Hook');
        
        $AddonModel = model(MODULE_COMMON_NAME.'/Addon');
        
        $hook_list = $HookModel->field('name,module')->select();

        foreach ($hook_list as $k => $v) {

            if (empty($v)) {
                continue;
            }
            $where[DATA_STATUS] = DATA_NORMAL;

            $where['module'] = $v['module'];

            $data = $AddonModel->where($where)->column('id,module'); 
            
            !empty($data) && Hook::add($v['name'], array_map(array(new Core(),"get_addon_class"),$data));
        }
    }
}
