<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */

namespace tpfcore\base;

/**
 * InvalidParamException represents an exception caused by invalid parameters passed to a method.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class InvalidParamException extends \BadMethodCallException
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Invalid Parameter';
    }
}
