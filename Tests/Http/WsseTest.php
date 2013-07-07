<?php


namespace Happyr\ApiClient\Tests\Http;


use Happyr\ApiClient\Http\Wsse;

/**
 * Class WsseTest
 *
 * Test the wsse class
 */
class WsseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Get a Wsse object
     *
     *
     * @return Wsse
     */
    protected function getWsse()
    {
        $wsse=new Wsse('foo','bar');

        return $wsse;
    }

    /**
     * Validate the format on the headers
     */
    public function testGetHeaders()
    {
        $wsse=$this->getWsse();
        $this->vaidateHeaders($wsse);
    }

    /**
     * Validate the wsse header
     *
     * @param Wsse &$wsse
     *
     */
    protected function vaidateHeaders(Wsse &$wsse){
        $header=$wsse->getHeaders();

        $pattern='/UsernameToken Username="([^"]+)", PasswordDigest="([^"]+)", Nonce="([^"]+)", Created="([^"]+)"/';
        $this->assertRegExp($pattern,$header[1], 'Wsse header did not match pattern');


    }
}
