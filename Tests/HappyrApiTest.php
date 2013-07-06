<?php

namespace Happyr\ApiClient\Tests;

use Happyr\ApiClient\HappyrApi;
use Happyr\ApiClient\Entity\Company;
use Happyr\ApiClient\Entity\Opus;
use Happyr\ApiClient\Entity\Populus\Profile;
use Happyr\ApiClient\Entity\Populus\Question;
use Happyr\ApiClient\Entity\Populus\Score;
use Happyr\ApiClient\Entity\User;

use Mockery as m;

/**
 * Class HappyrApiTest
 *
 *
 */
class HappyrApiTest extends \PHPUnit_Framework_TestCase
{

    protected function getApi($url)
    {
        $connection=m::mock('\HappyR\ApiClient\Http\Connection');
        $connection->shouldReceive('sendRequest')
            ->with($url, m::any(), m::any('POST','GET'), m::any())
            ->once()
            ->andReturn('testResponse');

       $serializer=m::mock('\Happyr\ApiClient\Serializer\SerializerInterface');
       $serializer->shouldReceive('deserialize')
           ->with('testResponse','array<Happyr\ApiClient\Entity\Company>',m::any('xml','yml'))
           ->once();

        return new HappyrApi(null,$serializer,$connection);

    }


    public function testGetCompanies()
    {
        $api=$this->getApi('companies');
        $api->getCompanies();
    }



}
