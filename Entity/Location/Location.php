<?php

namespace Happyr\ApiClient\Entity\Location;

use JMS\Serializer\Annotation as JMS;

class Location
{
	/**
	 * @JMS\Type("string")
	 */
	public $address;
	
	/**
	 * @JMS\Type("string")
	 */
	public $lng;
	
	/**
	 * @JMS\Type("string")
	 */
	public $lat;
	
	/**
	 * @JMS\Type("Happyr\ApiClient\Entity\Location\Country")
	 */
	public $country;
	
	/**
	 * @JMS\Type("Happyr\ApiClient\Entity\Location\City")
	 */
	public $city;
	
	/**
	 * @JMS\Type("Happyr\ApiClient\Entity\Location\Municipality")
	 */
	public $municipality;
	
	/**
	 * @JMS\Type("Happyr\ApiClient\Entity\Location\ZipCode")
	 */
	public $zipCode;
	
	
	
	
	
}