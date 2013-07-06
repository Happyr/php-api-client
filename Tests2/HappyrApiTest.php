<?php

namespace Happyr\ApiClient\Tests;

use Happyr\ApiClient\HappyrApi;
use Happyr\ApiClient\Entity\Company;
use Happyr\ApiClient\Entity\Opus;
use Happyr\ApiClient\Entity\Populus\Profile;
use Happyr\ApiClient\Entity\Populus\Question;
use Happyr\ApiClient\Entity\Populus\Score;

use Happyr\ApiClient\Entity\User;


class HappyrApiTest extends \PHPUnit_Framework_TestCase
{

	public function testCompanies()
    {
    	$api=new HappyrApi();
        
		$objects=$api->getCompanies();

		$this->assertTrue(count($objects)>0, 'No companies in array');
		
		$object=$objects[0];
	    $this->assertTrue($object instanceof Company);
		
		$id=$object->id;
		$object=$api->getCompany($id);
		
		$this->assertNotNull($object);
		$this->assertEquals($id, $object->id);
        $this->assertTrue($object instanceof Company);
    }


	public function testOpuses()
    {
    	$api=new HappyrApi();
        
		$objects=$api->getOpuses();

		$this->assertTrue(count($objects)>0, 'No opuses in array');
		
		$object=$objects[0];
	    $this->assertTrue($object instanceof Opus);
		
		$id=$object->id;
		$object=$api->getOpus($id);
		
		$this->assertNotNull($object);
		$this->assertEquals($id, $object->id);
        $this->assertTrue($object instanceof Opus);
    }
	
	public function testPopulusProfiles()
    {
    	$api=new HappyrApi();
        
		$objects=$api->getPopulusProfiles();

		$this->assertTrue(count($objects)>0, 'No populus profiles in array');
		
		$object=$objects[0];
	    $this->assertTrue($object instanceof Profile);
		
		$id=$object->id;
		$object=$api->getPopulusProfile($id);
		
		$this->assertNotNull($object);
		$this->assertEquals($id, $object->id);
        $this->assertTrue($object instanceof Profile);
    }
	
	public function testPopulusQuestion()
    {
    	$api=new HappyrApi();
        
		$user=new User();
		$user->id='3-25e6680d-f1ce9-2b10b-d69555ce3';
		
		$profile=new Profile();
		$profile->id=1;
		
		$object=$api->getPopulusQuestion($user, $profile);
		
		$this->assertNotNull($object);
        $this->assertTrue($object instanceof Question);
		
		$this->assertTrue(count($object->answers)==5);
		$answer=$object->answers[3];
		$this->assertNotEmpty($answer->label);
		
		$this->assertTrue($api->postPopulusAnswer($user, $object, $answer));
		$answer->id=18;
		$this->assertFalse($api->postPopulusAnswer($user, $object, $answer));
    }
	
	public function testPopulusScore()
    {
    	$api=new HappyrApi();
        
		$user=new User();
		$user->id='3-25e6680d-f1ce9-2b10b-d69555ce3';
		
		$profile=new Profile();
		$profile->id=1;
		
		$object=$api->getPopulusScore($user, $profile);
		
		$this->assertFalse($object);
		/*$this->assertNotNull($object);
        $this->assertTrue($object instanceof Score);*/
		
    }
	
	public function testUsers()
    {
    	$api=new HappyrApi();
        
		$randomEmail='test'.time().'@test.com';
		$object=$api->createUser($randomEmail);
		
		$this->assertTrue($object instanceof User);
		$this->assertNotEmpty($object->id);
		
		$this->setExpectedException('Happyr\ApiClient\Exceptions\UserConflictException');
		
		$object=$api->createUser($randomEmail);
		
    }
	
	public function testDoubleUsers()
    {
    	$api=new HappyrApi();
        
		$email='tobias.nyholm@growyn.com';
		/*
		$bool=$api->sendUserConfirmation($email);
		
		$this->assertTrue($bool);
		*/
		/*
		$token='';
		$object=$api->validateUser($email, $token);
		
		$this->assertTrue($object instanceof User);
		$this->assertNotEmpty($object->id);
		
		*/
    }
	
	
	
}
