<?php

namespace Sudiyi\Open\Tests;

use Sudiyi\Open\Api;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    protected $api;
    protected $resv_order_no = 20160719000001;
    protected $device_id = 1000149;
    protected $area_id = 510109;
    
    protected function setUp()
    {
        $this->api = new Api(getenv('SDY_PARTNER_ID'), getenv('SDY_PARTNER_KEY'));
        
        $test_host = getenv('SDY_TEST_HOST');
        $test_host && $this->api->client->host = $test_host;
    }
    
    public function testResv()
    {
        $data = array(
            'device_id'         => $this->device_id,
            'box_type'          => 2,
            'notify_url'        => 'http://your.url/to/notify.php',
            'auto_upgd'         => true,
            'sender_name'       => 'Stefans',
            'sender_mobile'     => '18612345678',
            'order_no'          => '2015000001',
            'consignee_name'    => 'demon',
            'consignee_mobile'  => '15887654321',
        );
        
        $result = $this->api->resv($data);
        $this->assertArrayHasKey('resv_order_no', $result);
    }
    
    public function testGetResv()
    {
        $result = $this->api->getResv($this->resv_order_no);
        $this->assertArrayHasKey('resv_order_no', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('open_code', $result);
    }

    public function testGetResvStatus()
    {
        $results = $this->api->getResvStatus($this->resv_order_no);
        $result = array_pop($results);
        $this->assertArrayHasKey('resv_order_no', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('create_at', $result);
        $this->assertArrayHasKey('order_no', $result);
        $this->assertArrayHasKey('send_mobile', $result);
        $this->assertArrayHasKey('consignee_mobile', $result);
    }


    public function testCancelResv()
    {
        $result = $this->api->cancelResv($this->resv_order_no);
        $this->assertNull($result);
    }
    
    public function testGetArea()
    {
        $this->api->getArea();
    }
    
    public function testGetLattice()
    {
        $result = $this->api->getLattice($this->area_id);
        $this->assertEquals('array', gettype($result));
        $this->assertArrayHasKey('devices', $result[0]);
    }

    public function testGetBoxStatus()
    {
        $result = $this->api->getBoxStatus('device', $this->device_id);
        $this->assertArrayHasKey('small', $result);
        $this->assertArrayHasKey('medium', $result);
        $this->assertArrayHasKey('big', $result);
    }

    public function testGetOnlineBoxStatus()
    {
        $result = $this->api->getOnlineBoxStatus('device', $this->device_id);
        $this->assertEquals('array', gettype($result));
        $this->assertArrayHasKey('device', $result[0]);
    }

    public function testGetDeadLetter()
    {
        $result = $this->api->getDeadLetter();
        $this->assertArrayHasKey('post', $result);
        $this->assertArrayHasKey('put', $result);
    }

    public function testGetClosest()
    {
        $lat = 116.403119;
        $lng = 39.915378;
        $result = $this->api->getClosest($lat, $lng);
        $this->assertEquals('array', gettype($result));
    }

}
