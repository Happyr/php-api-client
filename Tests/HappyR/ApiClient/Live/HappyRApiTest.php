<?php

namespace HappyR\ApiClient\Live;

include __DIR__.'/LiveApiClient.php';

use Mockery as m;

/**
 * Test the real server
 *
 * @group live
 *
 */
class HappyRApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \HappyR\ApiClient\HappyRApi client
     *
     *
     */
    protected $client;

    /**
     * get the client
     */
    public function setUp()
    {
        $this->client = LiveApiClient::get();
    }



    /**
     * Test to fetch many potential profiles
     */
    public function testGetPotentialProfiles()
    {
        $type = 'HappyR\ApiClient\Entity\Potential\Pattern';

        $collection = $this->client->getPotentialApi()->getPatterns();
        $entity = $collection[0];
        $this->assertTrue(is_array($collection));
        $this->assertInstanceOf($type, $entity);

        $this->assertInstanceOf($type, $this->client->getPotentialApi()->getPattern($entity->id));
    }


}
