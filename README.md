# Sudiyi Open Platform SDK for PHP

[![Latest Stable Version](https://poser.pugx.org/sudiyi/sudiyi-open-php-sdk/version)](https://packagist.org/packages/sudiyi/sudiyi-open-php-sdk)
[![Build Status](https://travis-ci.org/sudiyi/sudiyi-open-php-sdk.svg?branch=master)](https://travis-ci.org/sudiyi/sudiyi-open-php-sdk)
[![Coverage Status](https://coveralls.io/repos/github/sudiyi/sudiyi-open-php-sdk/badge.svg?branch=master)](https://coveralls.io/github/sudiyi/sudiyi-open-php-sdk?branch=master)

## 概述

速递易开放平台是速递易为企业或商户开通的速递易箱格接口，无缝对接PC网站、微信公众号、APP，帮助商家提升配送效率，降低配送成本，解决快件最后100米难题。

## 运行环境
- PHP 5.3+
- cURL extension

## 安装方法

1. 如果您通过composer管理您的项目依赖，可以在你的项目根目录运行：

        $ composer require sudiyi/sudiyi-open-php-sdk

   或者在你的`composer.json`中声明对速递易开放平台 SDK 的依赖：

        "require": {
            "sudiyi/sudiyi-open-php-sdk": "~1.0"
        }

   然后通过`composer install`安装依赖。

2. 下载SDK源码，在您的代码中引入 SDK 目录下的`autoload.php`文件：

        require_once '/path/to/sudiyi-open-php-sdk/autoload.php';

## SDK 主要目录结构

```
|-- example
|   |-- api_use_demo.php        案例程序代码
|   `-- notify_demo.php         商户回调处理
|-- src
|   |-- Core
|   |    |-- Base.php           基础类
|   |    |-- Config.php         常量配置
|   |    |-- Http.php           Http请求处理类
|   |    `-- SdyException.php   异常类
|   `-- Api.php                 接口封装类
|-- tests/                      测试文件
|-- autoload.php                PSR-4 自动加载                     
`-- composer.json
```

## 快速使用

`Sudiyi\Open\Api` 是对速递易开方平台的接口封装,用户通过 Api 的实例来执行各种操作

### 初始化

```php
require_once'/path/to/sudiyi-open-php-sdk/autoload.php';

use Sudiyi\Open\Api;

$partner_id = "<您从速递易开放平台获得的 PartnerId>";
$partner_key = "<您从速递易开放平台获得的 PartnerKey>";

$sdyClient = new Api($partner_id, $partner_key);
```

### 调用接口

```php
$data = array(
    'device_id'         => 1000149,                         // 速递易设备ID
    'box_type'          => 2,                               // 箱格类型 0:大箱 1:中箱 2:小箱 3:冰箱
    'notify_url'        => 'http://your.url/to/notify.php', // 回调第三方系统的地址
    'auto_upgd'         => true,                            // 选填，是否可以自动升箱
    'sender_name'       => 'Stefans',                       // 选填，投递人姓名
    'sender_mobile'     => '18612345678',                   // 选填，投递人手机
    'order_no'          => '2015000001',                    // 第三方订单号,即自己平台的订单号
    'consignee_name'    => 'demon',                         // 收货人姓名
    'consignee_mobile'  => '15887654321',                   // 收货人手机号
    'payment'           => 0,                               // 选填，到付金额，如果不是到付件则为0
    'pay_type'          => 0,                               // 选填，超期付费方式 0:快递柜付费 1:从商户账户扣除
    'duration'          => 60                               // 选填，预约时长，单位分钟，默认240分钟
);

// 预约速递易箱格
$result = $sdyClient->resv($data);
echo "预约成功: \n";
var_dump($result);

$resv_order_no = $result['resv_order_no'];

// 查询预约状态
$result = $sdyClient->getResv($resv_order_no);
echo "查询预约状态: \n";
var_dump($result);
```

更多接口的调用方式，请参见 example 或参看[官方文档](http://opendoc.sudiyi.cn/api.html)。

### 返回结果处理

所有接口默认返回一个 Array 对象，若请求出错或返回的数据为空，SDK 会抛出一个 SdyException 异常。

```
预约成功: 
array(1) {
  'resv_order_no' =>
  int(20160719000001)
}

查询预约状态: 
array(3) {
  'status' =>
  int(1)
  'resv_order_no' =>
  int(20160719000001)
  'open_code' =>
  NULL
}
```

### 异常处理

SDK 执行过程中若遇到异常，将会抛出一个 SdyException 异常，用户可自行捕获并处理。

```php
use Sudiyi\Open\Api;
use Sudiyi\Open\Core\SdyException;

try {
    // 预约速递易箱格
    $result = $sdyClient->resv($data);
    $resv_order_no = $result['resv_order_no'];

    // 取消预约箱格
    $result = $sdyClient->cancelResv($resv_order_no);
    echo "取消预约箱格: \n";
    var_dump($result);
    

} catch (SdyException $e) {
    echo "============== ERROR ==============\n";
    echo $e->getMessage() . "\n";
    var_dump($e->getErrorBody());
    echo "===================================\n";
}
```

### 运行Sample程序

1. 修改 `example/api_use_demo.php`， 补充配置信息
2. 执行 `php ./example/api_use_demo.php`

### 运行单元测试

1. 执行`composer install`下载依赖的库
2. 设置环境变量

        export SDY_PARTNER_ID=partner_id
        export SDY_PARTNER_KEY=partner_key

3. 执行 `php vendor/bin/phpunit`

## 问题反馈

Goto: [ISSUES](https://github.com/sudiyi/sudiyi-open-php-sdk/issues)

## 开源协议

MIT



