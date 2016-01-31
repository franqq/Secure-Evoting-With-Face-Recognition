<?php

/*!
 * KeyLemon API PHP Library
 * http://developers.keylemon.com/
 *
 * Copyright (c) 2015, keylemon.com
 * All rights reserved
 *
 *
 Redistribution and use in source and binary forms, with or without
 modification, are permitted provided that the following conditions are met:
 * Redistributions of source code must retain the above copyright
 notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright
 notice, this list of conditions and the following disclaimer in the
 documentation and/or other materials provided with the distribution.
 * Neither the name of the <organization> nor the
 names of its contributors may be used to endorse or promote products
 derived from this software without specific prior written permission.

 THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
 DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

 */

if (!function_exists('curl_init'))
	throw new Exception('CURL PHP extension required.');
if (!function_exists('json_decode'))
	throw new Exception('JSON PHP extension required.');

/**
 * Server_Connection is responsible to connect and requests server
 */
class Server_Connection {

	private static $instance;

	const SSL_VERIFYPEER = 2;
	const SSL_VERIFYHOST = 2;

	public $user_agent = "";

	private function __construct() {
	}

	public static function get_instance() {
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	public function download($base64_auth, $entry_point, $path){
		$full_url = $entry_point.$path;
		//check end of url
		if (substr($full_url, -1) !== '/') {
			$full_url .= '/';
		}
		$headers = array('Authorization: Basic '.$base64_auth);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_URL, $full_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 400);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, Server_Connection::SSL_VERIFYPEER);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, Server_Connection::SSL_VERIFYHOST);
		curl_setopt($ch, CURLOPT_CAINFO,  dirname(__FILE__).'/CA/KL_GlobalSignOrganizationValidationCA-G2.crt');
		$rawData = curl_exec($ch);
		$code    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		curl_close($ch);
		return $rawData;
	}

	public function make_request($base64_auth, $entry_point, $path, $method = 'GET', array $url_params = NULL, $data = NULL) {

		$full_url = $entry_point.$path;

		//check end of url
		if (substr($full_url, -1) !== '/') {
			$full_url .= '/';
		}

		$headers = array('Authorization: Basic '.$base64_auth);

		//prepare request
		$ch = curl_init();

		switch ($method) {
			case 'GET' :
				curl_setopt($ch, CURLOPT_HTTPGET, TRUE);

				if (!is_null($url_params)) {
					$full_url .= '?'.http_build_query($url_params);
				}

				break;

			case 'POST' :
				curl_setopt($ch, CURLOPT_POST, TRUE);

				//prepare the packet wrapper for the multipart
				$crlf = "\r\n";
				$boundary = '---------------------------10102754414578508781458777923';
				$delimiter = $crlf."--".$boundary;
				$preamble = "";
				$epilogue = "";
				$closeDelimiter = $delimiter."--";

				//construct body
				$multipart_body = '';

				//urls param in body
				if (!is_null($url_params)) {
					foreach ($url_params as $param => $value) {
				        $headers_form = 'Content-Disposition: form-data; name="'.$param.'"'.$crlf;
                        $multipart_body .= $preamble.$delimiter.$crlf.$headers_form.$crlf;
                        $multipart_body .= $value;
                        $multipart_body .= $closeDelimiter.$epilogue;					
					}
				}

				//data
				if (!is_null($data)) {

					$post = array();
					foreach ($data as $index => $image) {

						if (substr($image, 0, 1) == '@') {
							//get file content
							$image_data = file_get_contents(substr($image, 1));
						} else {
							//data directly
							$image_data = $image;
						}

						$headers_form = 'Content-Disposition: form-data; name="fileToUpload"; filename="dummy"'.$crlf;
						$multipart_body .= $preamble.$delimiter.$crlf.$headers_form.$crlf;
						$multipart_body .= $image_data;
						$multipart_body .= $closeDelimiter.$epilogue;
					}
				}

				curl_setopt($ch, CURLOPT_POSTFIELDS, $multipart_body);

				//add required information in header of the request
				$headers[] = 'Content-Type: multipart/form-data; boundary='.$boundary;

				break;
			case 'PUT' :
				if (!is_null($url_params)) {
					$full_url .= '?'.http_build_query($url_params);
				}

				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($url_params));
				break;
			case 'DELETE' :
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				break;
			default :
				break;
		}

		curl_setopt($ch, CURLOPT_URL, $full_url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);

		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 400);
		//timeout in seconds

		//ssl certificate
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, Server_Connection::SSL_VERIFYPEER);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, Server_Connection::SSL_VERIFYHOST);
		curl_setopt($ch, CURLOPT_CAINFO,  dirname(__FILE__).'/CA/KL_GlobalSignOrganizationValidationCA-G2.crt');

		//execute request
		$rawData = curl_exec($ch);

		//get code and content
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

		$result = json_decode($rawData);

		curl_close($ch);

		return $result;
	}

	public function __clone() {
		trigger_error('Cloning not authorized', E_USER_ERROR);
	}

	private function prepare_parameters(array $parameters) {

		if (count($parameters) == 0)
			return '';

		$parameters_string = '?';
		foreach ($parameters as $key => $value) {

			$parameters_string .= $key.'='.urlencode($value).'&';
		}
		$parameters_string = substr($parameters_string, 0, -1);
		return $parameters_string;
	}

}
