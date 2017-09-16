<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------

namespace app\frontend\logic;
use \tpfcore\Core;
/**
 *  设置逻辑
 */
class Setting extends FrontendBase
{
	public function getSetting($column){
		return $column?\tpfcore\helpers\Json::jsonValueToArray(self::getOneObject(['sign'=>'site_options'])->toArray())['options'][$column]:'';
	}
}