<?php
header("content-type:text/html; charset=utf-8"); 
//变态情况下的数据
$json = '[{ id : \'301\' , pId : 11 ,name:"%u5730%u7403%u6751%2819%29",url:"#",target:"_self",iconSkin:"pIcon03"},{id:"111",pId:"11",name:"PK%289%29",url:"#",target:"_self",iconSkin:"pIcon03"},{id:"1",pId:0,name:"%u9986%u85CF%u5206%u7C7B",url:"javascript:void(0);",target:"_self",open:true,iconSkin:"pIcon01"}]';
$arr = json_decode_fix($json);
var_dump($arr);
//极有可能出现的情况
$json = '[{a:"3:4"},{b:"7:8"}]';
$brr = json_decode_fix($json);
var_dump($brr);
 
/**
 * php解码js版本的json,兼容单引号和不带双引号情况
 * @param string $json
 * @return array
 */
function json_decode_fix($json)
{
    $result = json_decode($json, true);
    if($result)
    {
        return $result;
    }else{
        //不允许以纯数字作为键名或在键名或值处出现冒号,否则可能修复失败
        $pattern = '/(\w+\s*):([\s*\"\'|\d*]|true|false)+/is';
        $json = preg_replace_callback($pattern, function($matches){
            //处理纯数字或布尔值,其冒号之后为true、false、纯数字而非单双引号
            $index = strpos($matches[0], ':');
            $key = trim($matches[0]);
            $last = substr($key, -1);
            if($last === '"')
            {
                $key = rtrim($key, '" ');
                return '"'.trim(substr($key, 0, $index)).'":'.trim(substr($key, $index+1)).'"';
            }else if($last === "'")
            {
                $key = rtrim($key, "' ");
                return '"'.trim(substr($key, 0, $index)).'":"'.trim(substr($key, $index+1), "' ").'"';
            }else{
                $left = trim(substr($key, 0, $index));
                return is_numeric($left) ? $matches[0] : '"'.trim(substr($key, 0, $index)).'":'.substr($key, $index+1);
            }
        }, $json);
        return json_decode($json, true);
    }
}
