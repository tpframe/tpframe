<?php
/**
 * @link http://www.tpframe.com/
 * @copyright Copyright (c) 2017 TPFrame Software LLC
 * @author 510974211@qq.com
 */
namespace tpfcore\helpers;
class StringHelper extends BaseStringHelper
{
	/**
	* 字符串截取
	*/
	public static function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
		// 过滤html代码
		$str=strip_tags($str);
	    if(function_exists("mb_substr")){
	        $slice = mb_substr($str, $start, $length, $charset);
	        $strlen = mb_strlen($str,$charset);
	    }elseif(function_exists('iconv_substr')){
	        $slice = iconv_substr($str,$start,$length,$charset);
	        $strlen = iconv_strlen($str,$charset);
	    }else{
	        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	        preg_match_all($re[$charset], $str, $match);
	        $slice = join("",array_slice($match[0], $start, $length));
	        $strlen = count($match[0]);
	    }
	    if($suffix && $strlen>$length)$slice.='...';
	    return $slice;
	 }
	 public static function html_replace($content){
	    $content=str_replace("&lt;", "<", $content);
	    $content=str_replace("&gt;", ">", $content);
	    $content=str_replace("&namp;", "&", $content);
	    $content=str_replace("&quot;", "\"", $content);
	    return $content;
	 }
	 /**
	 * 随机字符串生成
	 * @param int $len 生成的字符串长度
	 * @return string
	 */
	public static function get_random_string($len = 6) {
		$chars = array(
				"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
				"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
				"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
				"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
				"S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
				"3", "4", "5", "6", "7", "8", "9"
		);
		$arrLen = count($chars) - 1;
		shuffle($chars);
		$output = "";
		for ($i = 0; $i < $len; $i++) {
			$output .= $chars[mt_rand(0, $arrLen)];
		}
		return $output;
	}
}
