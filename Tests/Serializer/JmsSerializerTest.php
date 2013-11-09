<?php


namespace HappyR\ApiClient\Tests\Serializer;

use HappyR\ApiClient\Serializer\JmsSerializer;

class JmsSerializerTest extends \PHPUnit_Framework_TestCase
{

    public function testInit()
    {
        $service = new JmsSerializer();
    }
}
