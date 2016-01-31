<?php
/*!
 * KeyLemon.js
 * https://developers.keylemon.com/
 *
 * Copyright (c) 2014, keylemon.com
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

require_once ( dirname(__FILE__).'/keylemon.class.php');

list($path) = explode('?', $_SERVER['REQUEST_URI']);

// if script was called directly from url, do not launch script
if(strpos($path,'.php') === false){

    $pathInfo = array();
    foreach (explode('/', $path) as $dir) {
        if (!empty($dir)) {
            $pathInfo[] = urldecode($dir);
        }
    }
    if (count($pathInfo) > 0) {
        $last = $pathInfo[count($pathInfo)-1];
        list($last) = explode('.', $last);
        $pathInfo[count($pathInfo)-1] = $last;
    }

    if ($pathInfo) {

        $function = end($pathInfo);

        $api = null;
        
        $user_agent = isset($_SESSION['USER-AGENT']);
        if(isset($_SESSION['USER-AGENT'])){
            $api = new klAPI(USERNAME, KEY, SERVER, $_SESSION['USER-AGENT']);
        }else{
            $api = new klAPI(USERNAME, KEY, SERVER);
        } 

        $keylemon = new Keylemon();
        $keylemon->process($api, $function, $_GET);
    }        
}