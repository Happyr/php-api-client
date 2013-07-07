<?php


namespace Happyr\ApiClient\Tests\Http;


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

        return new Connection($conf,$request);
    }

    /**
     * Test to send a request
     */
    public function testSendRequest()
    {
        $connection=$this->getConnection();

        $this->assertInstanceOf('Happyr\ApiClient\Http\Response',$connection->sendRequest('url'));
    }

    /**
     * Test error
     * @expectedException Happyr\ApiClient\Exceptions\HttpException
     */
    public function testSendRequestError()
    {
        $connection=$this->getConnection(400);

        $connection->sendRequest('url');
    }

}
