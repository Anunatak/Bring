<?php namespace Anunatak\Bring;

use GuzzleHttp\Client;
use App;

class Bring {

	/**
	 * The endpoint to the API for most calls
	 * 
	 * @var string Endpoint URL
	 * @access protected
	 */
	protected static $endpoint = 'https://api.bring.com/';

	/** 
	 * The endpoint to the API for tracking calls
	 * 
	 * @var string Endpoint URL
	 * @access protected
	 */
	protected static $tracking = 'http://sporing.bring.no/';

	/**
	 * Retrieve information about a postcode
	 * 
	 * @see http://developer.bring.com/api/postalcodeapi.html#json
	 * 
	 * @param int $postalCode A valid postal code
	 * @param string $country The country code
	 * 
	 * @return array An array of data
	 * @access public
	 */
	public static function postalCode( $postalCode, $country = 'no' ) {

		// create query args
		$query 		= array(
			'clientUrl'		=> App::make('url')->to('/'),
			'country'		=> (string)$country,
			'pnr'			=> (int)$postalCode
		);

		// the url base
		$url 		= self::$endpoint . 'shippingguide/api/postalCode.json?' . http_build_query($query);

		return self::request($url);

	}

	/**
	 * Retrieves list of the alternative locations for package pickup near a postal code
	 * 
	 * @see http://developer.bring.com/api/pickuppointapi.html#json
	 * 
	 * @param int $postalCode A valid postal code
	 * @param string $country The country code
	 * 
	 * @return array An array of pickup points
	 * @access public
	 */
	public static function pickupPoints( $postalCode, $country = 'no' ) {

		// the country needs to be uppercase
		$country 	= strtoupper($country);

		// create an url
		$url 		= self::$endpoint . 'pickuppoint/api/pickuppoint/'. $country . '/postalCode/'. $postalCode .'.json';

		return self::request($url);

	}

	/**
	 * Retrieves the tracking history of a tracking number
	 * 
	 * Only works for packages in Norway
	 * 
	 * @see http://developer.bring.com/api/trackingapi.html#json
	 * 
	 * @param string $trackingNumber A valid tracking number
	 * 
	 * @return array An array with tracking history
	 * @access public
	 */
	public static function trackPackage( $trackingNumber ) {

		// create an url
		$url 		= self::$tracking . 'sporing.json?q='. $trackingNumber;

		return self::request($url, false);

	}

	/**
	 * Perform a request using the GuzzleHttp Client
	 * 
	 * @param string $url The URL
	 * 
	 * @return array An array of data
	 * @access private
	 */
	private static function request( $url, $ssl = true ) {
		
		// create an instance of a guzzle client
		$client = new Client();

		$config = [];

		if( $ssl ) {
			$config = ['config' => [
		        'curl' => [
		            CURLOPT_SSLVERSION => 3,
		            CURLOPT_PORT => 443,
		            CURLOPT_SSL_CIPHER_LIST => 'SSLv3'
		        ]
		    ]];
		}

		// try getting a response and set the correct curl options
		$response = $client->get( $url, $config);

		return $response->json();

	}

}

?>