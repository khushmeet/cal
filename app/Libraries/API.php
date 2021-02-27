<?php

namespace App\Libraries;

/**
 * API handles all the Curl Request
 *@category         Curl Library
 *@param            $_params, time_out
 *@var[PROTECTED]   $_url, $_params , $_strpieces
 *@var[Public]
 */

class API {
	
	protected $url = "";
	
	protected $params = [];
	
	protected $time_out = 15;
	
	protected $headers = [];

	protected $_html = false;
		
	protected $method = "GET";


    /**
    *Send the curl request via url
    *@param string
    *@return  array
    */
    protected function request($time_out = 13)
    {

		$time_out = $this->time_out ?? $time_out;

		$curl = curl_init();

		curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $time_out,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $this->method,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ));
		

		//curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
		
		if(!empty($this->params)) {
			$data = json_encode($this->params);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);	
		}
		
		$response = curl_exec($curl);
		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);
		
		return ['status_code' => $code,'response'=>self::decodeJson($response,true)];
				
    }
	
	/**
	 * decode Json first tests the input $string to check its json validity before 
	 * deciding to return a decode json array or object, otherwise the $string 
	 * is return unchanged
	 * 
	 * @param type:string $string 
	 * @param type:bool  $isArray 
	 * @return type:string,array,object
	 * 
	 */
	public function decodeJson($string, $isArray = false)
	{
		if($this->_html) {

			$string = htmlentities($string);
		
		}
		
		//	$string = stripslashes($string);
		$output = json_decode($string, $isArray);
	
		return (json_last_error() == JSON_ERROR_NONE ? $output : $string);
	}
	

	
}
