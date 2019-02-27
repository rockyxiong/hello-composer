<?php
 
namespace Hello;
 
class SayHello
{
    public static function world()
    {
        return 'Hello World!';
    }
    /**
     * API接口统一返回
     *
     * @param string $msg   返回信息
     * @param array $data   返回数据
     * @param int $code     返回状态码
     * @return array
     */
    public static function apiResponse( $msg = '', $data = [],  $code = 0 )
    {
        return [
            'code'  => $code,
            'data'  => $data,
            'msg'   => $msg
        ];
    }

    /**
     * 下划线转驼峰
     *
     * @param $uncamelized_words
     * @param string $separator
     * @return string
     */
    public function camelize($uncamelized_words, $separator = '_')
    {
        $uncamelized_words = $separator . str_replace($separator, " ", strtolower($uncamelized_words));

        return ltrim(str_replace(" ", "", ucwords($uncamelized_words)), $separator);
    }

    /**
     * 驼峰命名转下划线命名
     *
     * @param $camelCaps
     * @param string $separator
     * @param bool $singleUpper  singleUpper = true - 此模式下,会将连在一起的大写字母分成单个，如： aTDDa 转换为 a_t_d_da
     * @return string
     */
    public function uncamelize($camelCaps, $separator = '_', $singleUpper = true)
    {
        if ($singleUpper) {
            return strtolower(preg_replace('/([A-Z])/', $separator . "$1", $camelCaps));
        } else {
            return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
        }
    }

    /**
     * 数组键值下划线转驼峰
     *
     * @param $array
     * @param string $separator
     * @return array
     */
    public function camelizeArrayKeys($array, $separator = '_')
    {
        $result = [];
        foreach ($array as $key => $item) {
            $result[$this->camelize($key, $separator)] = $item;
        }
        return $result;
    }

    /**
     * 数组键值驼峰命名转下划线命名
     *
     * @param $array
     * @param string $separator
     * @param bool $singleUpper
     * @return array
     */
    public function uncamelizeArrayKeys($array, $separator = '_', $singleUpper = true)
    {
        $result = [];
        foreach ($array as $key => $item) {
            $result[$this->uncamelize($key, $separator, $singleUpper)] = $item;
        }
        return $result;
    }

    /**
     * 字符串截取，支持中文和其他编码
     * static
     * access public
     * @param string $str 需要转换的字符串
     * @param string $start 开始位置
     * @param string $length 截取长度
     * @param string $charset 编码格式
     * @param string $suffix 截断显示字符
     * return string
     */
    public function msubstr($str,$length, $suffix=true, $start=0, $charset="utf-8")
    {
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
}