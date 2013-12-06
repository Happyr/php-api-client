<?php


namespace HappyR\ApiClient\Tests\Http;

use HappyR\ApiClient\Configuration;
use HappyR\ApiClient\Http\Client;

use Mockery as m;

/**
 * Class ConnectionTest
 *
 * Test the connection class
 */
class ConnectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Get a new connection with mocked dependencies
     *
     * @param int $httpStatus
     *
     * @return Client
     */
    protected function getConnection($httpStatus = 200)
    {
        $conf = new Configuration();

        $request = m::mock(
            'HappyR\ApiClient\Http\HttpRequestInterface',
            array(
                'setOption' => null,
                'execute' => 'response',
                'getInfo' => $httpStatus,
                'close' => null,
            )
        );

        $conn = new Client($conf, $request);

        return $conn;
        //die('Class: '.get_class($conn).' - '.print_r(get_class_methods($conn),true));
    }

    public function testNothing()
    {
        $this->assertTrue(true);
    }
}
