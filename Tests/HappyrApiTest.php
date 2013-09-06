<?php

namespace HappyR\ApiClient\Tests;

use HappyR\ApiClient\HappyRApi;

use Mockery as m;

/**
 * Class HappyRApiTest
 *
 *
 */
class HappyRApiTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Get an Api ojbect
     *
     *
     * @param string $url
     * @param string|null $returnObject
     * @param array|null $params
     * @param int $httpResponse
     *
     * @return HappyRApi
     */
    protected function getApi($url, $returnObject=null, $params=null, $httpResponse=200)
    {
        if($params==null){
            $params=m::any();
        }

        if($returnObject==null){
            $mockedReturn=null;
        }
        elseif(substr($returnObject,0,5)=='array'){
            $mockedReturn=m::mock('Collection');
        }
        else{
            $mockedReturn=m::mock($returnObject);
        }

        $response=m::mock('\HappyR\ApiClient\Http\Response',array(
            'getBody'=>'testResponse',
            'getCode'=>$httpResponse,
        ));

        $connection=m::mock('\HappyR\ApiClient\Http\Connection')
            ->shouldReceive('sendRequest')
            ->with($url, $params, m::any('POST','GET'))
            ->once()
            ->andReturn($response)
            ->getMock();

        $serializer=m::mock('\HappyR\ApiClient\Serializer\SerializerInterface')
            ->shouldReceive('deserialize')
            ->with('testResponse', $returnObject, m::any('xml','yml'))
            ->times($returnObject==null?0:1)
            ->andReturn($mockedReturn)
            ->getMock();

        return new HappyRApi(null,$serializer,$connection);

    }

    /**
     * Test to fetch many companies
     */
    public function testGetCompanies()
    {
        $api=$this->getApi('companies', 'array<HappyR\ApiClient\Entity\Company>');
        $this->assertInstanceOf('Collection',$api->getCompanies());
    }

    /**
     * Test to fetch a specific company
     */
    public function testGetCompany()
    {
        $id=33;
        $type='HappyR\ApiClient\Entity\Company';
        $api=$this->getApi('companies/'.$id, $type);
        $this->assertInstanceOf($type,$api->getCompany($id));
    }

    /**
     * Test to fetch many opuses
     */
    public function testGetOpuses()
    {
        $api=$this->getApi('opuses', 'array<HappyR\ApiClient\Entity\Opus>');
        $this->assertInstanceOf('Collection',$api->getOpuses());
    }

    /**
     * Test to fetch a specific Opus
     */
    public function testGetOpus()
    {
        $id=33;
        $type='HappyR\ApiClient\Entity\Opus';
        $api=$this->getApi('opuses/'.$id, $type);
        $this->assertInstanceOf($type,$api->getOpus($id));
    }

    /**
     * Test to fetch many populus profiles
     */
    public function testGetPopulusProfiles()
    {
        $api=$this->getApi('populus/profiles', 'array<HappyR\ApiClient\Entity\Populus\Profile>');
        $this->assertInstanceOf('Collection',$api->getPopulusProfiles());
    }

    /**
     * Test to fetch a specific Opus
     */
    public function testGetPopulusProfile()
    {
        $id=4;
        $type='HappyR\ApiClient\Entity\Populus\Profile';
        $api=$this->getApi('populus/profiles/'.$id, $type);
        $this->assertInstanceOf($type,$api->getPopulusProfile($id));
    }


    /**
     * Test to fetch a question
     */
    public function testGetPopulusQuestion()
    {
        $pid=93;
        $uid=5324;
        $type='HappyR\ApiClient\Entity\Populus\Question';
        $api=$this->getApi('populus/question', $type,
            array('user_id'=>$uid,'profile_id'=>$pid),200);

        $user=m::mock('HappyR\ApiClient\Entity\User')
            ->shouldReceive('')->andSet('id',$uid)->getMock();
        $profile=m::mock('HappyR\ApiClient\Entity\Populus\Profile')
            ->shouldReceive('')->andSet('id',$pid)->getMock();

        $this->assertInstanceOf($type,$api->getPopulusQuestion($user,$profile));


        //When there is no more questions
        $api=$this->getApi('populus/question', null,
            array('user_id'=>$uid,'profile_id'=>$pid),204);

        $this->assertNull($api->getPopulusQuestion($user,$profile));
    }

    /**
     * Test to push an answer
     */
    public function testPostPopulusAnswer()
    {
        $qid=93;
        $uid=5324;
        $aid=3;
        $api=$this->getApi('populus/question/'.$qid.'/answer', null,
            array('answer'=>$aid,'user_id'=>$uid),201);

        $user=m::mock('HappyR\ApiClient\Entity\User')
            ->shouldReceive('')->andSet('id',$uid)->getMock();
        $question=m::mock('HappyR\ApiClient\Entity\Populus\Question')
            ->shouldReceive('')->andSet('id',$qid)->getMock();
        $answer=m::mock('HappyR\ApiClient\Entity\Populus\Answer')
            ->shouldReceive('')->andSet('id',$aid)->getMock();

        $this->assertTrue($api->postPopulusAnswer($user,$question,$answer));

        //test wrong answer..
        $api=$this->getApi('populus/question/'.$qid.'/answer', null,
            array('answer'=>$aid,'user_id'=>$uid),400);
        $this->assertFalse($api->postPopulusAnswer($user,$question,$answer));
    }

    /**
     * Test to fetch Score
     */
    public function testGetPopulusScore()
    {
        $uid=513;
        $pid=2;
        $type='HappyR\ApiClient\Entity\Populus\Score';
        $api=$this->getApi('populus/score', $type,
            array('user_id'=>$uid, 'profile_id'=>$pid), 200);

        $user=m::mock('HappyR\ApiClient\Entity\User')
            ->shouldReceive('')->andSet('id',$uid)
            ->getMock();

        $profile=m::mock('HappyR\ApiClient\Entity\Populus\Profile')
            ->shouldReceive('')->andSet('id', $pid)
            ->getMock();

        $this->assertInstanceOf($type,$api->getPopulusScore($user,$profile));

        //test error
        $api=$this->getApi('populus/score', null,
            array('user_id'=>$uid, 'profile_id'=>$pid),412);

        $this->assertFalse($api->getPopulusScore($user,$profile));
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


    /**
     * Test to init with no params
     *
     *
     * @return HappyRApi
     */
    public function testInit()
    {
        return new HappyRApi();
    }







}
