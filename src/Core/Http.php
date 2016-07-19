<?php

namespace Sudiyi\Open\Core;

/**
 * Class Http
 *
 * Http 请求处理
 *
 * @package Sudiyi\Open\Core
 */
class Http
{
    /**
     * @var string  Sudiyi Open Platform API Host.
     */
    public $host;

    /**
     * @var int     Request timeout,
     */
    public $time_out = 5;

    /**
     * Http constructor.
     *
     * @param string  $host
     * @param integer $time_out
     * @throws SdyException
     */
    public function __construct($host, $time_out = null)
    {
        if (substr($host, 0, 4) != 'http')
            throw new SdyException('A illegal host was given when Http::new.');
        else
            $this->host = rtrim($host, '/');

        isset($time_out) && $this->time_out = $time_out;
    }
    
    /**
     * curl
     *
     * @param string $url
     * @param mixed  $header
     * @param string $method
     * @param null   $post_data
     * @return mixed
     * @throws SdyException
     */
    protected function curl($url, $header, $method, $post_data = null)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->time_out);
        //设置header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        switch (strtoupper($method)) {
            case 'GET' :
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                break;
            case 'PUT' :
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                break;
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if (in_array($info['http_code'], [200, 204])) {

            return json_decode($response, true);

        } else {
            $error_details = array(
                'url' => $url,
                'status' => $info['http_code'],
                'response' => substr($response, 0, 140),
                'body' => array(
                    'url' => $url,
                    'header' => $header,
                    'method' => $method,
                    'post_data' => $post_data,
                )
            );

            throw new SdyException($error_details);
        }
    }

    /**
     * HTTP Get.
     *
     * @param string     $path      Request path.
     * @param string     $header    Http header which is created by Base#getHeader.
     * @param array|null $params    Query array of the request.
     * @return mixed
     * @throws SdyException
     */
    public function get($path, $header, array $params = null)
    {
        $url = $this->host . '/' . $path;
        isset($params) && $url .= '?' . http_build_query($params);
        return $this->curl($url, $header, 'get');
    }

    /**
     * Http Post.
     *
     * @param string $path      Request path.
     * @param string $header    Http header which is created by Base#getHeader.
     * @param mixed  $data      Request body content.
     * @return mixed
     * @throws SdyException
     */
    public function post($path, $header, $data)
    {
        $url = $this->host . '/' . $path;
        return $this->curl($url, $header, 'post', json_encode($data));
    }

    /**
     * Http Put.
     *
     * @param string $path      Request path.
     * @param string $header    Http header which is created by Base#getHeader.
     * @param mixed  $data      Request body content.
     * @return mixed
     * @throws SdyException
     */
    public function put($path, $header, $data)
    {
        $url = $this->host . '/' . $path;
        return $this->curl($url, $header, 'put', json_encode($data));
    }

    /**
     * HTTP Delete.
     *
     * @param  string  $path    Request path.
     * @param  string  $header  Http header which is created by Base#getHeader.
     * @return mixed
     * @throws SdyException
     */
    public function delete($path, $header)
    {
        $url = $this->host . '/' . $path;
        return $this->curl($url, $header, 'delete');
    }

}