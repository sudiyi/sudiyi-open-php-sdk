<?php
/**
 * Api use demo.
 */

require_once  __DIR__ . '/../autoload.php';

use Sudiyi\Open\Api;
use Sudiyi\Open\Core\SdyException;

/*
 * 合作商家号、合作商家密匙（开户邮件中可查看）
 * 本 Demo 使用速递易开放平台测试环境 (via setting $sdyObj->client->host.)
 */
$partner_id = '<您从速递易开放平台获得的 PartnerId>';
$partner_key = '<您从速递易开放平台获得的 PartnerKey>';

/* 尝试从环境变量中获取配置 */
if (intval($partner_id) == 0) {
    $partner_id = getenv('SDY_PARTNER_ID');
    $partner_key = getenv('SDY_PARTNER_KEY');
}

/* 初始化 Api 实例 */
$sdyObj = new Api($partner_id, $partner_key);

/* 修改测试服务器 Host (如果有配置) */
$test_host = getenv('SDY_TEST_HOST');
$test_host && $sdyObj->client->host = $test_host;


$area_id = 510109;
$device_id = 1000149;
$lat = 116.403119;
$lng = 39.915378;

$data = array(
    'device_id'         => $device_id,                      // 速递易设备ID
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

try {
    // 预约速递易箱格
    $result = $sdyObj->resv($data);
    echo "预约成功: \n";
    var_dump($result);

    $resv_order_no = $result['resv_order_no'];

    // 查询预约状态
    $result = $sdyObj->getResv($resv_order_no);
    echo "查询预约状态: \n";
    var_dump($result);

    // 查询订单当前的详细状态
    $result = $sdyObj->getResvStatus($resv_order_no);
    echo "查询订单当前的详细状态: \n";
    var_dump($result);

    // 取消预约箱格
    
    $result = $sdyObj->cancelResv($resv_order_no);
    echo "取消预约箱格: \n";
    if ($result == null)
        echo"此次预约已不能取消 \n";
    else
        var_dump($result);
        
    
    // 获取速递易的行政区域,查出来成都市的id为:510100,成都市高新区的id为：510109,其他城市根据自己需要来
    $result = $sdyObj->getArea();
    echo "获取行政区域: \n";
    var_dump($result);

    // 获取网点和设备信息,根据上面查出来的id进行查询，会查询出来该行政区的所有设备信息，比如查询出来 SDY成都高新区-世纪城路-龙湖世纪峰景B50 的设备id为 1001412，则可以预约了
    $result = $sdyObj->getLattice($area_id);
    echo "获取网点和设备信息: \n";
    var_dump($result);

    // 获取箱格状态,type为device,按照设备id获取，type为lattice,按照网点id获取
    $result = $sdyObj->getBoxStatus('device', $device_id);
    echo "获取箱格状态: \n";
    var_dump($result);

    // 获取箱格状态和设备在线状态,type为device,按照设备id获取，type为lattice,按照网点id获取
    $result = $sdyObj->getOnlineBoxStatus('device', $device_id);
    echo "获取箱格状态和设备在线状态: \n";
    var_dump($result);

    // 获取死信
    $result = $sdyObj->getDeadLetter();
    echo "获取死信: \n";
    var_dump($result);

    // 获取附近设备
    $result = $sdyObj->getClosest($lat, $lng);
    echo "获取附近设备: \n";
    var_dump($result);

} catch (SdyException $e) {
    echo "============== ERROR ==============\n";
    echo $e->getMessage() . "\n";
    var_dump($e->getErrorBody());
    echo "===================================\n";
}


