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
     * Test to fetch many companies
     */
    public function testGetCompanies()
    {
        $entities=$this->client->getCompanies();
        $this->assertInstanceOf('Array',$entities);
    }

    /**
     * Test to fetch a specific company
     */
    public function testGetCompany()
    {
        $id=33;
        $type='HappyR\ApiClient\Entity\Company';
        $this->assertInstanceOf($type,$this->client->getCompany($id));
    }

    /**
     * Test to fetch many opuses
     */
    public function testGetOpuses()
    {
        $this->assertInstanceOf('Array',$this->client->getOpuses());
    }

    /**
     * Test to fetch a specific Opus
     */
    public function testGetOpus()
    {
        $id=33;
        $type='HappyR\ApiClient\Entity\Opus';
        $this->assertInstanceOf($type,$this->client->getOpus($id));
    }

    /**
     * Test to fetch many potential profiles
     */
    public function testGetPotentialProfiles()
    {
        $this->assertInstanceOf('Array',$this->client->getPotentialProfiles());
    }

    /**
     * Test to fetch a specific Opus
     */
    public function testGetPotentialProfile()
    {
        $id=4;
        $type='HappyR\ApiClient\Entity\Potential\Profile';
        $this->assertInstanceOf($type,$this->client->getPotentialProfile($id));
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
        $uid=513;
        $pid=2;
        $type='HappyR\ApiClient\Entity\Potential\Score';
        $api=$this->getApi('potential/score', $type,
            array('user_id'=>$uid, 'pattern_id'=>$pid), 200);

        $user=m::mock('HappyR\ApiClient\Entity\User')
            ->shouldReceive('')->andSet('id',$uid)
            ->getMock();

        $profile=m::mock('HappyR\ApiClient\Entity\Potential\Profile')
            ->shouldReceive('')->andSet('id', $pid)
            ->getMock();

        $this->assertInstanceOf($type,$api->getPotentialScore($user,$profile));

        //test error
        $api=$this->getApi('potential/score', null,
            array('user_id'=>$uid, 'pattern_id'=>$pid),412);

        $this->assertFalse($api->getPotentialScore($user,$profile));
    }

    /**
     * Test the create user
     */
    public function testCreateUser()
    {
        $email="test@mail.se";
        $type='HappyR\ApiClient\Entity\User';
        $api=$this->getApi('users', $type,
            array('email'=>$email),201);

        $this->assertInstanceOf($type,$api->createUser($email));

        //test error
        $api=$this->getApi('users', null,
            array('email'=>$email),400);

        $this->assertFalse($api->createUser($email));

    }

    /**
     * Test create a user but conflicts
     * @expectedException \HappyR\ApiClient\Exceptions\UserConflictException
     */
    public function testCreateUserConflict()
    {
        $email="test@mail.se";
        $api=$this->getApi('users', null,
            array('email'=>$email),409);

        $api->createUser($email);
    }

    /**
     * Test to send a confirmation message
     */
    public function testSendUserConfirmation()
    {
        $email="test@mail.se";
        $api=$this->getApi('users/confirmation/send', null,
            array('email'=>$email),200);

        $this->assertTrue($api->sendUserConfirmation($email));

        //test errro
        $api=$this->getApi('users/confirmation/send', null,
            array('email'=>$email),400);

        $this->assertFalse($api->sendUserConfirmation($email));

    }

    public function testValidateUser()
    {
        $email="test@mail.se";
        $token='123';
        $type='HappyR\ApiClient\Entity\User';
        $api=$this->getApi('users/confirmation/validate', $type,
            array('email'=>$email, 'token'=>$token),200);


        $this->assertInstanceOf($type,$api->validateUser($email,$token));

        //test error
        $api=$this->getApi('users/confirmation/validate', null,
            array('email'=>$email, 'token'=>$token),400);


        $this->assertFalse($api->validateUser($email,$token));

    }

}
