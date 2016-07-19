<?php

namespace Sudiyi\Open\Core;

/**
 * Class Config
 *
 * 基础配置信息
 *
 * @package Sudiyi\Open\Core
 */
class Config
{
    //=======【HTTP请求头部信息设置】=====================================
    //
    /**
     *
     * CONTENT_TYPE: http请求类型
     *
     */
    const CONTENT_TYPE = 'application/json;charset=UTF-8';

    //=======【开放平台接口地址设置】=====================================
    //
    /**
     *
     * HOST：速递易开放平台接口域名
     * AREA_URL：获取行政区域接口地址
     * LATTICE_URL：获取网点和设备信息接口地址
     * BOX_STATUS_URL：获取箱格状态接口地址
     * ONLINE_BOX_STATUS_URL：获取箱格状态和设备在线状态接口地址
     * RESV_URL:预约箱格接口地址
     * DEAD_LETTER_URL：获取死信接口地址
     * CLOSEST_URL：获取附近设备接口地址
     *
     */
    const HOST = 'http://open.sudiyi.cn';
    const AREA_URL = 'area';
    const LATTICE_URL = 'lattice';
    const BOX_STATUS_URL = 'boxStatus';
    const ONLINE_BOX_STATUS_URL = 'boxStatus/online';
    const RESV_URL = 'resv';
    const DEAD_LETTER_URL = 'deadletter';
    const CLOSEST_URL = 'closest';
}
