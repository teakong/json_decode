<?php
//中文json函数方法  
function json_encode_cn($arr) {   
    $str = json_encode($arr);   
    $search = "#\\\u([0-9a-f]+)#ie";   
    $replace = "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))";   
    return preg_replace($search, $replace, $str);   
}

//使用示例：  
$arr = array (  
    'name' => '小明',  
    'sex' => '男',  
    'age' => 22,  
);  
$json_str = json_encode_cn($arr);  
echo $json_str;//{"name":"小明","sex":"男","age":22}
