<?php

namespace Sudiyi\Open\Tests;

use Sudiyi\Open\Core\Base;
use Sudiyi\Open\Core\Config;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    
    public $partner_id = '1';
    public $partner_key = 'key';
    
    public $valid_sign = <<<BBB
POST
MTA0N2MyZmY0YzYwMThkMTY5MzY0MjNlY2EyYzZiZmU=
application/json;charset=UTF-8
Thu, 14 Jul 2016 21:51:28 +0800
v1/resv
BBB;

    protected $base;
    protected $path;
    protected $method;
    protected $content_type;
    protected $date;

    protected function setUp()
    {
        $this->base = new Base($this->partner_id, $this->partner_key);
        $this->path = 'v1/' . Config::RESV_URL;
        $this->method = 'post';
        $this->content_type = $this->base->content_type;
        $this->date = 'Thu, 14 Jul 2016 21:51:28 +0800';
    }

    public function testMakeContentMD5()
    {
        $result = $this->base->makeContentMD5('myContent');
        $this->assertEquals('MTA0N2MyZmY0YzYwMThkMTY5MzY0MjNlY2EyYzZiZmU=', $result);
        
        return $result;
    }

    /**
     * @depends clone testMakeContentMD5
     */
    public function testMakeSign($content_md5)
    {
        $result = $this->base->makeSign($this->method, $content_md5, $this->content_type, $this->date, $this->path);
        $this->assertEquals($this->valid_sign, $result);

        return $result;
    }

    /**
     * @depends clone testMakeSign
     */
    public function testMakeAuthorization($info2sign)
    {
        $result = $this->base->makeAuthorization($info2sign);
        $this->assertEquals('SDY 1:AoWdzFUcPilsC+xWU8D4ZhL0qxQ=', $result);
        
        return $result;
    }
    
    public function testGetHeader()
    {
        $result = $this->base->getHeader($this->path, $this->method);
        $this->assertCount(4, $result);
        $this->assertEquals([0,1,2,3], array_keys($result));
    }

}
