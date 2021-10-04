<?php

define('YOUR_AWS_ACCESS_KEY_ID', 'AKIAI7JOR3YDFD2IMMWA');
define('YOUR_AWS_SECRET_ACCESS_KEY', 'JkdAnKay7YjIDB2gNzXg6zfV/xiRJ4z4x/1vIYKp');
define('YOUR_ASSOCIATE_TAG', 'pm0c8-20');

$your_ebay_app_id = 'WebSolut-bd95-47da-8c5c-13bdd88f34ce';
$your_ebay_affiliate_tracking_id = '1234567890';
$your_ebay_affiliate_custom_id = 'k-man';

$cats = array(
		"Apparel & Accessories" => "Apparel_1036592_11450",
		"Arts" => "ArtsAndCrafts_2617941011_550",
		"Baby" => "Baby_165796011_2984",
		"Beauty" => "Beauty_3760911_26395",
		"Books" => "Books_283155_267",
		"Cell Phones & Accessories" => "Electronics_2335753011_15032",
		"Computers" => "PCHardware_541966_58058",
		"Electronics" => "Electronics_172282_293",
		"Health" => "HealthPersonalCare_3760901_26395",
		"Home" => "HomeGarden_1055398_11700",
		"Industrial" => "Industrial_16310161_12576",
		"Jewelry" => "Jewelry_3367581_281",
		"Sports" => "SportingGoods_3375251_888",
		"Toys" => "Toys_165793011_220",
		"Video Games" => "VideoGames_468642_1249",
		"Miscellaneous" => "Miscellaneous_324577011_99"
		);
		
$loc = array(
		"United States" => "com_EBAY-US",
		"United Kingdom" => "co.uk_EBAY-GB",
		"Australia" => "com_EBAY-AU",
		"Canada" => "ca_EBAY-ENCA",
		"Italy" => "it_EBAY-IT",
		"France" => "fr_EBAY-FR",
		"Spain" => "es_EBAY-ES",
		"Germany" => "de_EBAY-DE",
		"China" => "cn_EBAY-US",
		"Japan" => "co.jp_EBAY-US",
		"India" => "in_EBAY-IN",
		"Austria" => "com_EBAY-AT",
		"Switzerland" => "com_EBAY-CH",
		"Belgium" => "com_EBAY-FRBE",
		"Hong Kong" => "com_EBAY-HK",
		"Ireland" => "com_EBAY-IE",
		"Malaysia" => "com_EBAY-MY",
		"Netherlands" => "com_EBAY-NL",
		"Philippines" => "com_EBAY-PH",
		"Poland" => "com_EBAY-PL",
		"Singapore" => "com_EBAY-SG"
		);
		
	
function file_get_contents_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
 
    return $data;
}

function aws_signed_request($region, $params, $public_key, $private_key, $associate_tag=NULL, $version='2011-08-01')
{
    
    // some paramters
    $method = 'GET';
    $host = 'webservices.amazon.'.$region;
    $uri = '/onca/xml';
    
    // additional parameters
    $params['Service'] = 'AWSECommerceService';
    $params['AWSAccessKeyId'] = $public_key;
    // GMT timestamp
    $params['Timestamp'] = gmdate('Y-m-d\TH:i:s\Z');
    // API version
    $params['Version'] = $version;
    if ($associate_tag !== NULL) {
        $params['AssociateTag'] = $associate_tag;
    }
    
    // sort the parameters
    ksort($params);
    
    // create the canonicalized query
    $canonicalized_query = array();
    foreach ($params as $param=>$value)
    {
        $param = str_replace('%7E', '~', rawurlencode($param));
        $value = str_replace('%7E', '~', rawurlencode($value));
        $canonicalized_query[] = $param.'='.$value;
    }
    $canonicalized_query = implode('&', $canonicalized_query);
    
    // create the string to sign
    $string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;
    
    // calculate HMAC with SHA256 and base64-encoding
    $signature = base64_encode(hash_hmac('sha256', $string_to_sign, $private_key, TRUE));
    
    // encode the signature for the request
    $signature = str_replace('%7E', '~', rawurlencode($signature));
    
    // create request
    $request = 'http://'.$host.$uri.'?'.$canonicalized_query.'&Signature='.$signature;
    
    return $request;
}

?>