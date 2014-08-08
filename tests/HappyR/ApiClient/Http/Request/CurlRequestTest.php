<?php


namespace Happyr\ApiClient\Tests\Http\Request;

use Happyr\ApiClient\Http\Request\CurlRequest;
use Mockery as m;

/**
 * Class CurlRequestTest
 *
 * Test the connection class
 */
class CurlRequestTest extends \PHPUnit_Framework_TestCase
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
        $this->client = new Dummy();
    }

    public function testBuildUrl()
    {
        $url=$this->client->buildUrl('foo', array('bar'=>'baz'));
        $this->assertEquals('foo?bar=baz', $url);

        $url=$this->client->buildUrl('foo', array('bar'=>'baz', 'foobar'=>1));
        $this->assertEquals('foo?bar=baz&foobar=1', $url);
    }
}

class Dummy extends CurlRequest
{
    public function buildUrl($uri, array $filters = array())
    {
        return parent::buildUrl($uri, $filters);
    }

    public function preparePostData($ch, array $data = array())
    {
        parent::preparePostData($ch, $data);
    }
}
