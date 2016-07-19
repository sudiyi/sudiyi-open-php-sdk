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

SDK目录结构
```
|-- example
|   |-- api_use_demo.php        案例程序代码
|   `-- notify_demo.php         商户回调处理
|-- src
|   |-- Core
|   |    |-- Base.php           基础类，该类中定义数据类最基本的行为，包括：设置签名、生成MD5、生成Authorization、设置http请求头部信息等
|   |    |-- Config.php         商户配置
|   |    |-- Http.php           Http请求处理类
|   |    `-- SdyException.php   异常类
|   `-- Api.php                 接口封装类
|-- tests
|   |-- BaseTest.php            单元测试
|-- .gitignore
|-- autoload.php
|-- composer.json
|-- LICENSE.md
|-- phpunit.xml
`-- README.md
```


初始化Api类时需传递partner_id,partner_key,version
partner_id  合作商家号,5位数字（开户邮件中可查看）
partner_key 合作商家密匙（必须配置，开户邮件中可查看）
version     接口版本号(默认为v1)

SdyException为异常处理类，商户对接时可按照demo中的方式进行异常处理

