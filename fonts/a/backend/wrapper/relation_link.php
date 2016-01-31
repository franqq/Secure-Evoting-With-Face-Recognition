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

include_once ('server_connection.php');

/**
 * Relation_Link maps relation and file formats
 */
class Relation_Link {

	private $auth;
	private $base_url;
	private $path;
	private $method;

	/**
	 * This class is used to initialize the wrapper's method linked with the API
	 * @param string $data The json data
	 * @param string $relationName the name of the relation
	 * @param string $returnFormat the format expected for the response
	 */
	public function __construct($base64_auth, $base_url, $path, $method = 'GET') {
		$this->auth = $base64_auth;
		$this->base_url = $base_url;
		$this->path = $path;
		$this->method = $method;
	}

	/**
	 * Make the ajax request on href
	 * @param string data The json data to send
	 * @param string dataFormat The expected format response
	 * @return mixed The KeyLemon object
	 */
	public function request($resource = null, array $url_params = null, array $files = null) {
		return Server_Connection::get_instance()->make_request($this->auth, $this->base_url, $this->path.(is_null($resource) ? '' : $resource), $this->method, $url_params, $files);
	}

    public function download($resource = null) {
        return Server_Connection::get_instance()->download($this->auth, $this->base_url, $this->path.(is_null($resource) ? '' : $resource));
    }

}