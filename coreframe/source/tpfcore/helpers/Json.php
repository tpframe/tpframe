<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace tpfcore\helpers;
use tpfcore\base\InvalidParamException;

class Json extends BaseJson
{
    public static function jsonValueToArray($data, $options = 320)
    {
        if(!is_array($data)){
            throw new InvalidParamException('Invalid array data.');
        }elseif ($data === []) {
            return null;
        }else{
            foreach ($data as $key => &$value) {
                if(is_array($value)){
                    self::jsonValueToArray($value);
                }
                if(preg_match('/^{([\s\S]*)}$/',$value)){
                    $value=json_decode($value,$options);
                }
            }
            return $data;
        }
    }

    public static function arrayValueToJson($data, $options = 320)
    {
        if(!is_array($data)){
            throw new InvalidParamException('Invalid array data.');
        }elseif ($data === []) {
            return null;
        }
        foreach ($data as $key => &$value) {
            if(is_array($value)){
                $value=json_encode($value);
            }
        }
        return $data;
    }
}
