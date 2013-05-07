<?php

namespace Happyr\ApiClient\Tests;

use Happyr\ApiClient\HappyrApi;
use Happyr\ApiClient\Entity\Company;

class HappyApiTest extends \PHPUnit_Framework_TestCase
{
    public function testCompany()
    {
    	$api=new HappyrApi();
        
		$object=$api->getCompany(1);
		
		$this->assertNotNull($object);
		$this->assertEquals(1, $object->id);
        $this->assertTrue($object instanceof Company);
    }
	
	public function testCompanies()
    {
    	$api=new HappyrApi();
        
		$objects=$api->getCompanies();

		$this->assertTrue(count($objects)>0, 'No companies in array');
		
		$object=$objects[0];
	    $this->assertTrue($object instanceof Company);
    }

	
}
