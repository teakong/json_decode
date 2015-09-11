<?php
/**
*@功能：json_encode不编译中文成unicode,看起来更容易理解
*@参数：类型为array，$array是
*@返回：类型为string
 */
function json_encode_cn($array)
{
	arrayRecursive($array, 'urlencode', true);
	$json = json_encode($array);
	return urldecode($json);
}


/**************************************************************
   *
   *    使用特定function对数组中所有元素做处理
   *    @param  string  &$array     要处理的字符串
   *    @param  string  $function   要执行的函数
   *    @return boolean $apply_to_keys_also     是否也应用到key上
   *    @access public
   *
 *************************************************************/
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
	static $recursive_counter = 0;
	if (++$recursive_counter > 1000) {
		die('possible deep recursion attack');
	}
	if(!empty($array))
	{
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				arrayRecursive($array[$key], $function, $apply_to_keys_also);
			} else {
				$array[$key] = $function($value);
			}
	 
			if ($apply_to_keys_also && is_string($key)) {
				$new_key = $function($key);
				if ($new_key != $key) {
					$array[$new_key] = $array[$key];
					unset($array[$key]);
				}
			}
		}
	}
	$recursive_counter--;
}

//使用示例：  
$arr = array (  
    'name' => '小明',  
    'sex' => '男',  
    'age' => 22,  
);  
$json_str = json_encode_cn($arr);
echo $json_str;//{"name":"小明","sex":"男","age":"22"}

