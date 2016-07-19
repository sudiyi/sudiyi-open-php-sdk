<?php

namespace Sudiyi\Open\Tests;

use Sudiyi\Open\Core\Http;

class HttpTest extends \PHPUnit_Framework_TestCase
{
    protected $http;
    
    public function testGet()
    {
        $this->http = new Http('http://sposter.net', 5);
        $result = $this->http->get('proxy/getnum', array('Content-type: application/json'));
        $this->assertArrayHasKey('result', $result);
        $this->assertArrayHasKey('packages_count', $result);
    }
    
    public function testGetInvalidJson()
    {
        $this->http = new Http('http://sposter.net', 5);
        $result = $this->http->get('/', []);
        $this->assertNull($result);
    }

    /** @noinspection PhpUndefinedNamespaceInspection */
    /** @noinspection PhpUndefinedClassInspection */
    /**
     * @expectedException Sudiyi\Open\Core\SdyException
     */
    public function testGetWithSdyException()
    {
        $this->http = new Http('http://bod.sudiyi.cn', 5);
        $this->http->get('404', []);
    }
    
    public function testPost()
    {
        $this->http = new Http('http://sposter.net', 5);
        $result = $this->http->post('/', [], ['post' => 'nothing']);
        $this->assertNull($result);
    }

    public function testDelete()
    {
        $this->http = new Http('http://sposter.net', 5);
        $result = $this->http->delete('/', []);
        $this->assertNull($result);
    }

    public function testPut()
    {
        $this->http = new Http('http://sposter.net', 5);
        $result = $this->http->put('/', [], ['put' => 'nothing']);
        $this->assertNull($result);
    }
        


}
