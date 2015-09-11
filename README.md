# json_decode
json_encode针对中文会进行UNICODE编码，和其他语言兼容性并不是很好。
## json_encode_cn
json_encode_cn目前测试时间最长,未发现bug，不足的是整型会变成字符型。
json_encode_cn2使用正则替换，且依赖iconv函数，如果iconv存在bug相信也会有bug。
json_decode_cn3使用曲线救国方式，自行urlencode生成的代码在各类语言中也非常容易urldecode。

##json_decode_fix
PHP的json_encode总有一些不通用的缺陷，例如不能解析js的json对象(当键名没有引号时)。
json_decode_fix即可以解决部分bug，简单测试过string，integer，boolean等类型。
继续测试中。

