<?php

namespace Sudiyi\Open\Core;

/**
 * Class Base
 *
 * 基础类，该类中定义数据类最基本的行为，包括：
 * 设置签名、生成MD5、生成Authorization、设置http请求头部信息等
 *
 * @package Sudiyi\Open\Core
 */
class Base
{
    /**
     * @var Integer $partner_id  合作商家号
     */
    protected $partner_id;

    /**
     * @var String $partner_key  合作商家密匙
     */
    protected $partner_key;

    /**
     * @var String $content_type  Http Request MimeType.
     */
    public $content_type = Config::CONTENT_TYPE;

    /**
     * Base constructor.
     * 
     * @param $partner_id
     * @param $partner_key
     */
    public function __construct($partner_id, $partner_key)
    {
        $this->partner_id = $partner_id;
        $this->partner_key = $partner_key;
        date_default_timezone_set('Asia/Shanghai');
    }

    /**
     * 生成MD5
     *
     * @param  string $str 需要生成MD5的字符串
     * @return string
     */
    public function makeContentMD5($str)
    {
        return base64_encode(md5($str));
    }

    /**
     * 生成签名
     *
     * @param string $method
     * @param string $content_md5
     * @param string $content_type
     * @param string $date
     * @param string $path
     * @return string
     */
    public function makeSign($method, $content_md5, $content_type, $date, $path)
    {
        return join("\n", [strtoupper($method), $content_md5, $content_type, $date, $path]);
    }

    /**
     * 生成Authorization
     * @param string $info2sign  签名
     * @return string
     */
    public function makeAuthorization($info2sign)
    {
        $signature = base64_encode(hash_hmac('sha1', $info2sign, $this->partner_key, true));

        return "SDY {$this->partner_id}:{$signature}";
    }

    /**
     * 设置HTTP请求的头部信息
     *
     * @param string  $path    HTTP-Request-Path
     * @param string  $method  HTTP-Request-Method
     * @return array
     */
    public function getHeader($path, $method='get')
    {
        $date = date('r');
        $content_md5 = $this->makeContentMD5('');
        $path = '/' . ltrim($path, '/');
        
        $info2sign = $this->makeSign($method, $content_md5, $this->content_type, $date, $path);
        $authorization = $this->makeAuthorization($info2sign);

        $header = array(
            'Content-Type:' . $this->content_type,
            'Date:' . $date,
            'Content-MD5:' . $content_md5,
            'Authorization:' . $authorization,
        );

        return $header;
    }

}
