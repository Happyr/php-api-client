<?php


namespace HappyR\ApiClient\Tests\Http;


use Happyr\ApiClient\Configuration;
use Happyr\ApiClient\Http\Connection;

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
     * @return Connection
     */
    protected function getConnection($httpStatus=200)
    {
        $conf=new Configuration();


        $request=m::mock('Happyr\ApiClient\Http\HttpRequestInterface',array(
                'setOption'=>null,
                'execute'=>'response',
                'getInfo'=>$httpStatus,
                'close'=>null,
            )
        );
        $request->shouldReceive('createNew')->once()->andReturn(m::self());

        $conn= new Connection($conf,$request);

        return $conn;
        //die('Class: '.get_class($conn).' - '.print_r(get_class_methods($conn),true));
    }

    /**
     * Test to send a request
     *
     * @runInSeparateProcess
     */
    public function testSendRequest()
    {
        $connection=$this->getConnection();


        $this->assertInstanceOf('Happyr\ApiClient\Http\Response', $connection->sendRequest('url'));
    }

    /**
     * Test error
     * @expectedException Happyr\ApiClient\Exceptions\HttpException
     * @runInSeparateProcess
     */
    public function testSendRequestError()
    {
        $connection=$this->getConnection(400);

        $connection->sendRequest('url');
    }

}
