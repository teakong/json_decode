<?php
/**
 *@功能：json_encode不编译中文成unicode
 *@参数：$arr为数组，所有值必须为数组
 *@返回：json字符串，如果版本大于5.4则直接保留中文，否则使用urlencode编码
 */
function json_encode_cn3($arr)
{
    if(version_compare(PHP_VERSION, '5.4.0') >= 0)
    {
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }else{
        return json_encode(_urlencode($arr));
    }
}

function _urlencode($arr)
{
    if(is_array($arr))
    {
        return array_map(__METHOD__, $arr);
    }else if(is_string($arr)){
        return urlencode($arr);
    }else{
        return $arr;
    }
}

function json_decode_cn3($string)
{
    if(version_compare(PHP_VERSION, '5.4.0') >= 0)
    {
        json_decode($string, true);
    }else{
        return _urldecode(json_decode($string, true));
    }
}

function _urldecode($arr)
{
    if(is_array($arr))
    {
        return array_map(__METHOD__, $arr);
    }else if(is_string($arr)){
        return urldecode($arr);
    }else{
        return $arr;
    }
}

//使用示例：  
$arr = array (  
    'name' => '小明',  
    'sex' => '男',  
    'age' => 22,  
);  
$json_str = json_encode_cn3($arr);  
echo $json_str;//{"name":"%E5%B0%8F%E6%98%8E","sex":"%E7%94%B7","age":22
$arr = json_decode_cn3($json_str);
var_dump($arr);//array(3) { ["name"]=> string(6) "小明" ["sex"]=> string(3) "男" ["age"]=> int(22) }

