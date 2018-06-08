<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */

namespace tpfcore\web;

use tpfcore\base\TpfObject;

/**
 * JsExpression marks a string as a JavaScript expression.
 *
 * When using [[\tpfcore\helpers\Json::encode()]] or [[\tpfcore\helpers\Json::htmlEncode()]] to encode a value, JsonExpression objects
 * will be specially handled and encoded as a JavaScript expression instead of a string.
 */
class JsExpression extends TpfObject
{
    /**
     * @var string the JavaScript expression represented by this object
     */
    public $expression;


    /**
     * Constructor.
     * @param string $expression the JavaScript expression represented by this object
     * @param array $config additional configurations for this object
     */
    public function __construct($expression, $config = [])
    {
        $this->expression = $expression;
        parent::__construct($config);
    }

    /**
     * The PHP magic function converting an object into a string.
     * @return string the JavaScript expression.
     */
    public function __toString()
    {
        return $this->expression;
    }
}
