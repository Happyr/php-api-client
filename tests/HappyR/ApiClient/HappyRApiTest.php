<?php


namespace HappyR\ApiClient\Tests;

use HappyR\ApiClient\HappyRApi;
use HappyR\ApiClient\Configuration;
use HappyR\ApiClient\Http\Client;

use Mockery as m;

/**
 * Class HappyRApiTest
 *
 * @author Tobias Nyholm
 *
 */
class HappyRApiTest extends \PHPUnit_Framework_TestCase
{
    const APP_ID='123456789';
    const APP_SECRET='987654321';

    /**
     * @var DummyApi api
     *
     */
    protected $api;

    public function setUp()
    {
        $this->api = new DummyApi(new Configuration(self::APP_ID, self::APP_SECRET));
    }

    public function testConstructor()
    {
        $conf=$this->api->getConfiguration();
        $this->assertEquals($conf->identifier, '123456789',
            'Expect the App ID to be set.');
        $this->assertEquals($conf->secret, '987654321',
            'Expect the API secret to be set.');
    }

    public function testApi()
    {
        $data=array('foobar'=>'test');;
        $method='POST';
        $uri='foobar';
        $expected='baz';

        $client = m::mock('HappyR\ApiClient\Http\Client')
            ->shouldReceive('sendRequest')->once()->with($uri, $data, $method)->andReturn($expected)
            ->getMock();


        $api=$this->getMock('HappyR\ApiClient\HappyRApi', array('getHttpClient'));
        $api->expects($this->once())->method('getHttpClient')->will($this->returnValue($client));

        $result=$api->api($uri, $data, $method);
        $this->assertEquals($expected, $result);

    }

    public function testGetLoginUrl()
    {
        $redirectUrl='currentUrl';
        $state='random';
        $conf=new Configuration();
        $conf->baseUrl='base';
        $conf->identifier=self::APP_ID;
        $expected='base/candidate/login/api_key='.self::APP_ID."&state=$state&redirect_url=".urlencode($redirectUrl);


        $api=$this->getMock('HappyR\ApiClient\HappyRApi', array('establishCSRFTokenState', 'getState'));
        $api->expects($this->once())->method('establishCSRFTokenState');
        $api->expects($this->once())->method('getState')->will($this->returnValue($state));

        $api->setConfiguration($conf);

        $this->assertEquals($expected, $api->getLoginUrl($redirectUrl));
   }

    public function testEstablishCSRFTokenState()
    {
        $_SESSION['happyr_ac_state']=null;
        $this->api->establishCSRFTokenState();

        $state=$this->api->getState();
        $this->assertNotNull($state, 'CSRF token was not created');
        $this->assertEquals($state, $_SESSION['happyr_ac_state']);

        $this->api->establishCSRFTokenState();
        $this->assertEquals($state, $this->api->getState());
        $this->assertEquals($state, $_SESSION['happyr_ac_state']);

    }

    public function testGetCodeEmpty()
    {
        unset($_REQUEST['code']);
        $this->assertNull($this->api->getCode());
    }

    public function testGetCode()
    {
        $state='bazbar';
        $_REQUEST['code']='foobar';
        $_REQUEST['state']=$state;

        $api=$this->getMock('HappyR\ApiClient\Tests\DummyApi', array('getState', 'setState'), array(), '', false);
        $api->expects($this->once())->method('setState')->with($this->equalTo(null));
        $api->expects($this->once())->method('getState')->will($this->returnValue($state));

        $this->assertEquals('foobar', $api->getCode());
    }

    /**
     * @expectedException \Exception
     */
    public function testGetCodeInvalidCode()
    {
        $api=$this->getMock('HappyR\ApiClient\Tests\DummyApi', array('getState'), array(), '', false);
        $api->expects($this->once())->method('getState')->will($this->returnValue('bazbar'));

        $_REQUEST['code']='foobar';
        $_REQUEST['state']='invalid';

        $this->assertEquals('foobar', $api->getCode());
    }


}

class DummyApi extends HappyRApi {
    public function getHttpClient($forceNew = false)
    {
        return parent::getHttpClient($forceNew);
    }

    public function getCode()
    {
        return parent::getCode();
    }

    public function establishCSRFTokenState()
    {
        parent::establishCSRFTokenState();
    }

    public function setState($state)
    {
        return parent::setState($state);
    }

    public function getState()
    {
        return parent::getState();
    }
}