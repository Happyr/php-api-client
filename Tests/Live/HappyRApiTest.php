<?php

namespace HappyR\ApiClient\Tests\Live;

use HappyR\ApiClient\HappyRApi;

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
     * @var HappyRApi client
     *
     *
     */
    protected $client;

    /**
     * get the client
     */
    public function setUp()
    {
        $this->client=LiveApiClient::get();
    }


    /**
     * Test to fetch many companies and one specific
     */
    public function testGetCompanies()
    {
        $type='HappyR\ApiClient\Entity\Company';

        $collection=$this->client->getCompanies();
        $entity=$collection[0];
        $this->assertTrue(is_array($collection));
        $this->assertInstanceOf($type,$entity);

        $this->assertInstanceOf($type,$this->client->getCompany($entity->id));
    }


    /**
     * Test to fetch many opuses
     */
    public function testGetOpuses()
    {
        $type='HappyR\ApiClient\Entity\Opus';

        $collection=$this->client->getOpuses();
        $this->assertTrue(is_array($collection));
        $entity=$collection[0];
        $this->assertInstanceOf($type,$entity);

        $this->assertInstanceOf($type,$this->client->getOpus($entity->id));
    }


    /**
     * Test to fetch many potential profiles
     */
    public function testGetPotentialProfiles()
    {
        $type='HappyR\ApiClient\Entity\Potential\Profile';

        $collection=$this->client->getPotentialProfiles();
        $entity=$collection[0];
        $this->assertTrue(is_array($collection));
        $this->assertInstanceOf($type,$entity);

        $this->assertInstanceOf($type,$this->client->getPotentialProfile($entity->id));
    }

    /**
     * Test to fetch a statement
     */
    public function testGetPotentialStatement()
    {

        $type='HappyR\ApiClient\Entity\Potential\Statement';


      //  $this->assertInstanceOf($type,$this->client->getPotentialStatement($user,$profile));

    }

    /**
     * Test to push an answer
     */
    public function testPostPotentialAnswer()
    {


        //$this->assertTrue($this->client->postPotentialAnswer($user,$statement,$answer));

        //test wrong answer..
        //$this->assertFalse($this->client->postPotentialAnswer($user,$statement,$answer));
    }

    /**
     * Test to fetch Score
     */
    public function testGetPotentialScore()
    {

    }

    /**
     * Test the create user
     */
    public function testCreateUser()
    {


    }

    /**
     * Test create a user but conflicts
     * @expectedException \HappyR\ApiClient\Exceptions\UserConflictException
     */
    public function testCreateUserConflict()
    {

    }

    /**
     * Test to send a confirmation message
     */
    public function testSendUserConfirmation()
    {


    }

    public function testValidateUser()
    {

    }

}
