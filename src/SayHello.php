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

}