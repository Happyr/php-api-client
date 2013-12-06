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
     * @var DummyClient client
     *
     */
    protected $client;
    /**
     * Set up the test
     */
    public function setup()
    {
        $conf = new Configuration();
        $conf->baseUrl='base/';
        $this->client = new DummyClient($conf);
    }

    public function testBuildUrl()
    {
        $url=$this->client->buildUrl('foo', array('bar'=>'baz'));
        $this->assertEquals('base/foo?bar=baz', $url);

        $url=$this->client->buildUrl('foo', array('bar'=>'baz', 'foobar'=>1));
        $this->assertEquals('base/foo?bar=baz&foobar=1', $url);
    }
}

class DummyClient extends Client
{
    public function buildUrl($uri, array $filters = array())
    {
        return parent::buildUrl($uri, $filters);
    }
}
