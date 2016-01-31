<?php
/*!
 * KeyLemon API
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
 
$_CONFIG = array();

//path to php wrapper to contact KeyLemon Cloud service
if(!defined('WRAPPER_PATH')) define ('WRAPPER_PATH' ,  dirname(__FILE__).'/wrapper/klAPI.php');
if(!defined('USERNAME')) define ('USERNAME', 'KEYLEMON_USERNAME');
if(!defined('KEY')) define ('KEY', 'KEYLEMON_KEY');
if(!defined('SERVER')) define ('SERVER', 'https://api.keylemon.com');

// advanced parameters
if(!defined('FACE_AUTHENTICATION_THRESHOLD')) define ('FACE_AUTHENTICATION_THRESHOLD', null);
if(!defined('SPEAKER_AUTHENTICATION_THRESHOLD')) define ('SPEAKER_AUTHENTICATION_THRESHOLD', 80);

