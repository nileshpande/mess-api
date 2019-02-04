<?php

require_once 'firejwt/src/BeforeValidException.php';
require_once 'firejwt/src/ExpiredException.php';
require_once 'firejwt/src/SignatureInvalidException.php';
require_once 'firejwt/src/JWT.php';


use \Firebase\JWT\JWT;

$key = "only_nil_great";

$token = array(
   "iss" => "http://example.org",
   "aud" => "http://example.com",
   "iat" => 1356999524,
   "nbf" => 1357000000
);

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
*/
//$jwt = JWT::encode($token, $key);

	$headers = apache_request_headers();

	if(isset($headers))
	{
		$tokenathr = $headers['Authorization'];
		$tokenarry = (explode(" ",$tokenathr));
		
		$jwt = $tokenarry[1];
		
		try {
        $decoded = JWT::decode($jwt, $key, array('HS256'));
		$tokentest= true;
		} catch (\Exception $e) {
			$tokentest= false;
		}
		
		if(! $tokentest)
		{
			$data2 = array("status" => false, "responce_status_massage" => "Invalid Token");
			echo json_encode($data2,JSON_NUMERIC_CHECK);
			die();
		}
		else
		{ }
		
	}
	else
	{
		$data2 = array("status" => false, "responce_status_massage" => "No Token");
		echo json_encode($data2,JSON_NUMERIC_CHECK);
		die();
	}
	
	
	
	
	
	



//echo $jwt.'</br>';

//print_r($decoded);

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

//$decoded_array = (array) $decoded;

/**
* You can add a leeway to account for when there is a clock skew times   between
* the signing and verifying servers. It is recommended that this leeway should
* not be bigger than a few minutes.
*
* Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
*/
   //JWT::$leeway = 60; // $leeway in seconds
  // $decoded = JWT::decode($jwt, $key, array('HS256'));
   
   
 ?>