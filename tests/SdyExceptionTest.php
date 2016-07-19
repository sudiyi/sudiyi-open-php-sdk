<?php

namespace Sudiyi\Open\Tests;

use Sudiyi\Open\Core\SdyException;

class SdyExceptionTest extends \PHPUnit_Framework_TestCase
{
    protected $errors;

    protected function setUp()
    {
        $this->errors = array(
            'url' => 'http://www.sudiyi.cn',
            'status' => 404,
            'response' => 'I am the test response!',
            'body' => array(
                'url' => 'http://www.sudiyi.cn',
                'header' => ['Content-type: application/json'],
                'method' => 'post',
                'post_data' => ['post' => 'nothing'],
            )
        );
    }

    /** 
     * @expectedException Sudiyi\Open\Core\SdyException
     * @expectedExceptionMessage a test sdyException
     */
    public function testNew()
    {
        throw new SdyException('a test sdyException');
    }
    
    public function testGetHTTPStatus()
    {
        try {
            throw new SdyException($this->errors);
        } catch (SdyException $e) {
            $this->assertEquals('404', $e->getHTTPStatus());
        }
    }
    
    public function testGetErrorCode()
    {
        try {
            throw new SdyException($this->errors);
        } catch (SdyException $e) {
            $this->assertEmpty($e->getErrorCode());
        }
    }

    public function testGetErrorResponse()
    {
        try {
            throw new SdyException($this->errors);
        } catch (SdyException $e) {
            $this->assertEquals('I am the test response!', $e->getErrorResponse());
        }
    }

    public function testGetErrorBody()
    {
        try {
            throw new SdyException($this->errors);
        } catch (SdyException $e) {
            $this->assertArrayHasKey('url', $e->getErrorBody());
            $this->assertCount(4, $e->getErrorBody());
        }
    }

}
