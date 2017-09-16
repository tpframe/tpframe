<?php
namespace app\common\logic;

use app\common\dao\CategoryDao;
use app\common\model\ModelBase;
/*	
*	逻辑基类
*/
class Category extends ModelBase implements CategoryDao
{
	public function getCategory(){
		$Category=\Think\Loader::model('Category');
		return $Category->find()->toArray();
	}
}
?>