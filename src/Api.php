<?php

namespace Sudiyi\Open;

use Sudiyi\Open\Core\Base;
use Sudiyi\Open\Core\Config;
use Sudiyi\Open\Core\SdyException;
use Sudiyi\Open\Core\Http;

/**
 * Class Api
 * 
 * 接口访问类，包含所有对速递易开放平台API列表的封装
 * 
 * @package Sudiyi\Open
 */
class Api
{

    /**
     * @var string 接口版本号
     */
    public $version;

    /**
     * 构造函数
     *
     * @param String $partner_id  合作商家号,5位数字（开户邮件中可查看）
     * @param String $partner_key 合作商家密匙（必须配置，开户邮件中可查看）
     * @param String $version     接口版本号
     * @param int    $time_out    接口超时时间(单位:秒, 默认5秒)
     * @throws SdyException
     */
    public function __construct($partner_id, $partner_key, $version = 'v1', $time_out = 5)
    {
        $partner_id = trim($partner_id);
        $partner_key = trim($partner_key);
        $this->version = trim($version);

        if (! preg_match('/^\d{2,5}$/i', $partner_id))
            throw new SdyException("partner_id is invaild");

        if (empty($partner_key))
            throw new SdyException("partner_key is empty");

        if (! preg_match('/^v\d+$/i', $this->version))
            throw new SdyException("api version is wrong");

        $this->base = new Base($partner_id, $partner_key);
        $this->client = new Http(Config::HOST, $time_out);
    }

    /**
     * 预约箱格
     *
     * @param array $data  提交的数据
     * @return mixed
     */
    public function resv($data)
    {
        $path = $this->version . '/' . Config::RESV_URL;
        $header = $this->base->getHeader($path, 'post');

        return $this->client->post($path, $header, $data);
    }

    /**
     * 查看预约信息
     *
     * @param string $resv_order_no 订单号
     * @return mixed
     */
    public function  getResv($resv_order_no)
    {
        $path = $this->version . '/' . Config::RESV_URL . '/' . $resv_order_no;
        $header = $this->base->getHeader($path, 'get');

        return $this->client->get($path, $header);
    }

    /**
     * 取消预约箱格
     *
     * @param string $resv_order_no 订单号
     * @return mixed
     */
    public function cancelResv($resv_order_no)
    {
        $path = $this->version . '/' . Config::RESV_URL . '/' . $resv_order_no;
        $header = $this->base->getHeader($path, 'delete');
        
        return $this->client->delete($path, $header);
    }

    /**
     * 获取行政区域
     *
     * @return mixed
     */
    public function getArea()
    {
        $path = $this->version . '/' . Config::AREA_URL;
        $header = $this->base->getHeader($path, 'get');

        return $this->client->get($path, $header);
    }

    /**
     * 获取网点和设备信息
     *
     * @param integer $area_id 行政区域ID
     * @return mixed
     */
    public function getLattice($area_id)
    {
        $path = $this->version . '/' . Config::LATTICE_URL;
        $params = ['area' => $area_id];
        $header = $this->base->getHeader($path, 'get');

        return $this->client->get($path, $header, $params);
        
    }

    /**
     * 获取箱格状态,type为device,按照设备id获取，type为lattice,按照网点id获取
     *
     * @param integer $id   设备ID
     * @param string  $type 设备类型
     * @return mixed|void
     * @throws SdyException
     */
    public function getBoxStatus($type, $id)
    {
        if (! in_array($type, ['device', 'lattice']))
            throw new SdyException('Unknown $type was given in function getBoxStatus');

        $path = $this->version . '/' . Config::BOX_STATUS_URL;
        $params = [$type => $id];
        $header = $this->base->getHeader($path, 'get');

        return $this->client->get($path, $header, $params);
    }

    /**
     * 获取箱格状态和设备在线状态,type为device,按照设备id获取，type为lattice,按照网点id获取
     *
     * @param integer $id   设备ID
     * @param string  $type 设备类型
     * @return mixed
     * @throws SdyException
     */
    public function getOnlineBoxStatus($type, $id)
    {
        if (! in_array($type, ['device', 'lattice']))
            throw new SdyException('Unknown $type was given in function getOnlineBoxStatus');

        $path = $this->version . '/' . Config::ONLINE_BOX_STATUS_URL;
        $params = [$type => $id];
        $header = $this->base->getHeader($path, 'get');

        return $this->client->get($path, $header, $params);
    }

    /**
     * 获取死信
     *
     * @return mixed
     */
    public function getDeadLetter(){
        $path = $this->version . '/' . Config::DEAD_LETTER_URL;
        $header = $this->base->getHeader($path, 'get');

        return $this->client->get($path, $header);
    }

    /**
     * 查询订单当前的详细状态
     *
     * @param string $resv_order_no 订单号
     * @return mixed
     */
    public function getResvStatus($resv_order_no)
    {
        $path = $this->version . '/' . Config::RESV_URL;
        $params = ['resv_order_no' => $resv_order_no];
        $header = $this->base->getHeader($path, 'get');

        return $this->client->get($path, $header, $params);
    }

    /**
     * 获取附近设备
     *
     * @param string $lat 经度
     * @param string $lng 纬度
     * @return mixed
     */
    public function getClosest($lat, $lng)
    {
        $path = $this->version . '/' . Config::CLOSEST_URL;
        $params = ['lat' => $lat, 'lng' => $lng];
        $header = $this->base->getHeader($path, 'get');

        return $this->client->get($path, $header, $params);
    }
}

