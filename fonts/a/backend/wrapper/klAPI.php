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

// API includes
include_once ('server_connection.php');
include_once ('relation_link.php');

/**
 * Main class of KeyLemon PHP wrapper
 * @version 1.2.1
 * @author KeyLemon <info@keylemon.com>
 */
class KLAPI {

	//links
	private $get_face_link;
	private $post_face_link;

    private $post_multiview_link;

	private $get_model_link;
	private $post_model_link;
	private $post_speaker_model_link;
	private $put_model_link;
	private $delete_model_link;

	private $get_group_link;
	private $post_group_link;
	private $put_group_link;
	private $delete_group_link;

	private $get_identity_link;
	private $post_identity_link;
	private $post_identity_face_link;
	private $post_identity_speaker_link;
	private $put_identity_link;
	private $delete_identity_link;

	private $recognize_face_link;
	private $recognize_speaker_link;
	private $recognition_status;

	private $get_stream_link;
	private $post_stream_link;

	private $get_credentials_link;
	private $get_storage_link;
	private $get_usage_link;

	private $base64_auth;

	/**
	 * @param string $username The KeyLemon API username
	 * @param string $client_key The KeyLemon API key
	 * @param String $entryPointURL The URL of the server that host the API
	 * @throws \KL_Exception If the user isn't allowed to access to the API
	 */
	public function __construct($username, $client_key, $server, $user_agent = "PHP Wrapper") {

		if (is_null($username) || is_null($client_key))
			throw new KL_Exception(KL_Errors::Wrong_Parameters);

		$this->base64_auth = base64_encode($username.':'.$client_key);

		//instantiate links
		$this->get_face_link = new Relation_Link($this->base64_auth, $server.'/api/', 'face/', 'GET');
		$this->post_face_link = new Relation_Link($this->base64_auth, $server.'/api/', 'face/', 'POST');

        $this->post_multiview_link = new Relation_Link($this->base64_auth, $server.'/api/', 'face_detail/', 'POST');

		$this->get_model_link = new Relation_Link($this->base64_auth, $server.'/api/', 'model/', 'GET');
		$this->post_model_link = new Relation_Link($this->base64_auth, $server.'/api/', 'model/', 'POST');
		$this->post_speaker_model_link = new Relation_Link($this->base64_auth, $server.'/api/', 'speaker/model/', 'POST');
		$this->put_model_link = new Relation_Link($this->base64_auth, $server.'/api/', 'model/', 'PUT');
		$this->delet_modelLink = new Relation_Link($this->base64_auth, $server.'/api/', 'model/', 'DELETE');

		$this->get_group_link = new Relation_Link($this->base64_auth, $server.'/api/', 'group/', 'GET');
		$this->post_group_link = new Relation_Link($this->base64_auth, $server.'/api/', 'group/', 'POST');
		$this->put_group_link = new Relation_Link($this->base64_auth, $server.'/api/', 'group/', 'PUT');
		$this->delete_group_link = new Relation_Link($this->base64_auth, $server.'/api/', 'group/', 'DELETE');

		$this->get_identity_link = new Relation_Link($this->base64_auth, $server.'/api/', 'identity/', 'GET');
		$this->post_identity_link = new Relation_Link($this->base64_auth, $server.'/api/', 'identity/', 'POST');
		$this->post_identity_face_link = new Relation_Link($this->base64_auth, $server.'/api/', 'identity/face/', 'POST');
		$this->post_identity_speaker_link = new Relation_Link($this->base64_auth, $server.'/api/', 'identity/speaker/', 'POST');
		$this->put_identity_link = new Relation_Link($this->base64_auth, $server.'/api/', 'identity/', 'PUT');
		$this->delete_identity_link = new Relation_Link($this->base64_auth, $server.'/api/', 'identity/', 'DELETE');

		$this->recognize_face_link = new Relation_Link($this->base64_auth, $server.'/api/', 'recognize/', 'POST');
		$this->recognize_speaker_link = new Relation_Link($this->base64_auth, $server.'/api/', 'speaker/recognize/', 'POST');
		$this->recognition_status = new Relation_Link($this->base64_auth, $server.'/api/', 'status/', 'GET');

		$this->get_usage_link = new Relation_Link($this->base64_auth, $server.'/api/', 'infos/', 'GET');

		$this->get_stream_link = new Relation_Link($this->base64_auth, $server.'/api/', 'stream/', 'GET');
		$this->post_stream_link = new Relation_Link($this->base64_auth, $server.'/api/', 'stream/', 'POST');

		$this->get_image_link = new Relation_Link($this->base64_auth, $server.'/api/', 'image/', 'GET');

		Server_Connection::get_instance()->user_agent = $user_agent;

	}

	/***********************************************************************
	 * METHOD FOR FACE MANAGEMENT
	 **********************************************************************/

	/**
	 * Get a face
	 * @param string $face_id The id of the face
	 * @return object Response
	 */
	public function get_face($face_id, $properties = false) {
		$params = array();
		if ($properties){
			$params['properties'] = true;
		}
		return $this->get_face_link->request($face_id, $params);
	}

	/**
	 * Get an image
	 * @param string $image_id The id of the image
	 * @return object Response
	 */
	public function get_image($image_id) {
		return $this->get_image_link->download($image_id);
	}

	/**
	 * Detect faces from image url or data
	 * @param array[string] $images_url Images urls
	 * @param array[string] $images_data Images data
	 * @return object Response
	 */
	public function detect_faces(array $images_url = NULL, array $images_data = NULL, $properties = false ) {

		$params = array();
		if (!is_null($images_url)) {
			$params['urls'] = $this->create_list_from_array($images_url);
		}

		if ($properties){
			$params['properties'] = true;
		}

		return $this->post_face_link->request(NULL, $params, $images_data);

	}

     /**
     * Detect faces from image url or data with gender detection
     * @param array[string] $images_url Images urls
     * @param array[string] $images_data Images data
     * @return object Response
     */
    public function detect_faces_mv(array $images_url = NULL, array $images_data = NULL) {

        $params = array();
        if (!is_null($images_url)) {
            $params['urls'] = $this->create_list_from_array($images_url);
        }

        return $this->post_multiview_link->request(NULL, $params, $images_data);

    }

	/***************************************************************************
	 * METHOD FOR FACEMODEL MANAGEMENT
	 **************************************************************************/

	/**
	 * Create a biometric model from faces
	 * @param array[string] $images_url The array of url pointing to an image
	 * @param array[string] $images_data The array of images data
	 * @param array[string] $faces_id The array of faces id
	 * @param string $name The name of the model (optional)
	 * @return object Response
	 */
	public function create_model(array $images_url = NULL, array $images_data = NULL, array $faces_id = NULL, $name = null) {

		$params = array();

		if (!is_null($images_url)) {
			$images_url = $this->create_list_from_array($images_url);
			$params['urls'] = $images_url;
		}

		if (!is_null($faces_id)) {
			$faces_id = $this->create_list_from_array($faces_id);
			$params['faces'] = $faces_id;
		}
		if (!is_null($name)) {
			$params['name'] = $name;
		}

		return $this->post_model_link->request(NULL, $params, $images_data);
	}

	/**
	 * Create a biometric model from speech
	 * @param array[string] $audio_url The array of url pointing to audio samples
	 * @param array[string] $audio_data The array of audio data
	 * @param string $name The name of the model (optional)
	 * @return object Response
	 */
	public function create_speaker_model(array $audio_url = NULL, array $audio_data = NULL, $name = null) {

		$params = array();

		if (!is_null($audio_url)) {
			$audio_url = $this->create_list_from_array($audio_url);
			$params['urls'] = $audio_url;
		}

		if (!is_null($name)) {
			$params['name'] = $name;
		}

		return $this->post_speaker_model_link->request(NULL, $params, $audio_data);
	}

	/**
	 * Get a model
	 * @param string $model_id The id of the model to get
	 * @return object Response
	 */
	public function get_model($model_id) {
		return $this->get_model_link->request($model_id);
	}

	/**
	 * List models
	 * @param int $offset The offset from which to return the models
	 * @param int $limit The number of models to return
	 * @return object Response
	 */
	public function list_models($offset = NULL, $limit = NULL) {

		$params = NULL;
		if (!is_null($offset)) {
			$params['offset'] = $offset;
		}

		if (!is_null($limit)) {
			$params['limit'] = $limit;
		}
		return $this->get_model_link->request(NULL, $params);
	}

	/**
	 * Set a name to a model
	 * @param string $model_id The id of the model
	 * @param string $name The name of the model
	 * @return object Response
	 */
	public function edit_model_name($model_id, $name) {

		$params = array();

		$params['name'] = $name;

		return $this->put_model_link->request($model_id, $params);

	}

	/**
	 * Perform face recognition
	 * @param array[string] models_id The models to test the faces again
	 * @param array[string] images_url The images url containing the face to test
	 * @param array[string] images_data The images data containing the face to test
	 * @param array[string] faces_id The faces to test
	 * @param integer max_result The maximum result returned (optional : set to NULL to use default value)
	 * @param boolean mean returns the recognition score as a mean onto the images sent
	 * @return object Response
	 */
	public function recognize($models_id, $images_url = NULL, $images_data = NULL, $faces_id = NULL, $max_result = NULL, $mean = FALSE) {
		trigger_error('Deprecated: this function is deprecated! Use recognize_face method instead.', E_NOTICE);
		return $this->recognizeFace($models_id, $images_data, $images_data, $faces_id, $max_result, $mean);
	}
	public function recognize_face($models_id, $images_url = NULL, $images_data = NULL, $faces_id = NULL, $max_result = NULL, $mean = FALSE) {

		$params = array();

		if (!is_null($images_url)) {
			$images_url = $this->create_list_from_array($images_url);
			$params['urls'] = $images_url;
		}
		if (!is_null($faces_id)) {
			$faces_id = $this->create_list_from_array($faces_id);
			$params['faces'] = $faces_id;
		}
		if (!is_null($models_id)) {
			$models_id = $this->create_list_from_array($models_id);
			$params['models'] = $models_id;
		}
		if (!is_null($max_result)) {
			$params['max_result'] = $max_result;
		}
		if ($mean) {
			$params['mean'] = TRUE;
		}

		return $this->recognize_face_link->request(NULL, $params, $images_data);
	}

	/**
	 * Perform an asynchronous face recognition
	 * @param array[string] images_url The images url containing the face to test
	 * @param array[string] images_data The images data containing the face to test
	 * @param array[string] faces_id The faces to test
	 * @param array[string] models_id The models to test the faces again
	 * @param integer max_result The maximum result returned (optional : set to NULL to use default value)
	 * @return object Response
	 */
	public function recognize_async(array $images_url, array $images_data, array $faces_id, array $models_id, $max_result = null) {
		trigger_error('Deprecated: this function is deprecated! Use recognize_face_async instead.', E_NOTICE);
		return $this->recognize_face_async($images_url, $images_data, $faces_id, $models_id, $max_result);
	}
	public function recognize_face_async(array $images_url, array $images_data, array $faces_id, array $models_id, $max_result = null) {

		$params = array();

		$params['async'] = 'true';

		if (!is_null($images_url)) {
			$images_url = $this->create_list_from_array($images_url);
			$params['urls'] = $images_url;
		}

		if (!is_null($faces_id)) {
			$faces_id = $this->create_list_from_array($faces_id);
			$params['faces'] = $faces_id;
		}

		if (!is_null($models_id)) {
			$models_id = $this->create_list_from_array($models_id);
			$params['models'] = $models_id;
		}

		if (!is_null($max_result)) {
			$max_result = $this->create_list_from_array($max_result);
			$params['max_result'] = $max_result;
		}

		return $this->recognize_face_link->request(NULL, $params, $images_data);

	}
	
	/**
	 * Perform an asynchronous speaker recognition
	 * @param array[string] audio_urls The images url containing the face to test
	 * @param array[string] audios_data The images data containing the face to test
	 * @param array[string] models_id The models to test the faces again
	 * @param integer max_result The maximum result returned (optional : set to NULL to use default value)
	 * @param boolean mean returns the recognition score as a mean onto the images sent
	 * @return object Response
	 */
	public function recognize_speaker($models_id, $identity_id, $audio_urls = NULL, $audios_data = NULL, $max_result = NULL, $mean = FALSE) {

		$params = array();

		if (!is_null($audio_urls)) {
			$audio_urls = $this->create_list_from_array($audio_urls);
			$params['urls'] = $audio_urls;
		}
		if (!is_null($models_id)) {
			$models_id = $this->create_list_from_array($models_id);
			$params['models'] = $models_id;
		}
		if (!is_null($identity_id)) {
			$identity_id = $this->create_list_from_array($identity_id);
			$params['identities'] = $identity_id;
		}
		if (!is_null($max_result)) {
			$params['max_result'] = $max_result;
		}
		if ($mean) {
			$params['mean'] = TRUE;
		}

		return $this->recognize_speaker_link->request(NULL, $params, $audios_data);
	}
	
	/**
	 * Perform an asynchronous speaker recognition
	 * @param array[string] audio_urls The images url containing the face to test
	 * @param array[string] audios_data The images data containing the face to test
	 * @param array[string] models_id The models to test the faces again
	 * @param integer max_result The maximum result returned (optional : set to NULL to use default value)
	 * @return object Response
	 */
	public function recognize_speaker_async(array $audio_urls, array $audios_data, array $models_id, $max_result = null) {

		$params = array();

		$params['async'] = 'true';

		if (!is_null($audio_urls)) {
			$audio_urls = $this->create_list_from_array($audio_urls);
			$params['urls'] = $audio_urls;
		}

		if (!is_null($models_id)) {
			$models_id = $this->create_list_from_array($models_id);
			$params['models'] = $models_id;
		}

		if (!is_null($max_result)) {
			$max_result = $this->create_list_from_array($max_result);
			$params['max_result'] = $max_result;
		}

		return $this->recognize_speaker_link->request(NULL, $params, $audios_data);

	}
	
	/**
	 * Get the status of an asynchronous request
	 * @param string $status_uid The uid of the status returned during the recognition_async
	 * @return object Response
	 */
	public function get_status($status_uid){
		return $this->recognition_status->request($status_uid);
	}
	
	/**
	 * Get the result of an asynchornous request
	 * @param string $status_uid The uid of the status returned during the recognition_async
	 * @return object Response
	 */
	public function get_status_result($status_uid){
		return $this->recognition_status->request($status_uid . "/result");
	}
	

	/**
	 * Adapt the FaceModel with new faces
	 * @param string $model_id The id of the model to adapt
	 * @param array[string] The array of images urls
	 * @param array[string] The array of images data
	 * @param array[string] The array of faces id
	 * @return object Response
	 */
	public function adapt_model($model_id, array $images_url = NULL, array $images_data = NULL, array $faces_id = NULL) {

		$params = array();

		if (!is_null($images_url)) {
			$images_url = $this->create_list_from_array($images_url);
			$params['urls'] = $images_url;
		}

		if (!is_null($faces_id)) {
			$faces_id = $this->create_list_from_array($faces_id);
			$params['faces'] = $faces_id;
		}

		return $this->post_model_link->request($model_id, $params, $images_data);

	}

	/**
	 * Delete the model by the id
	 * @param string The model id to delete
	 * @return object Response
	 */
	public function delete_model($model_id) {
		return $this->delet_modelLink->request($model_id);
	}

	/***************************************************************************
	 * METHOD FOR GROUP MANAGEMENT
	 **************************************************************************/

	/**
	 * Get a group by id
	 * @param string $group_id The group id
	 * @return object Response
	 */
	public function get_group($group_id) {
		return $this->get_group_link->request($group_id);
	}

	/**
	 * Create a group from face model
	 * @param array[string] The models to add into the group
	 * @return object Response
	 */
	public function create_group(array $models_id = null, $name = null) {

		$params = array();

		if (!is_null($name)) {
			$params['name'] = $name;
		}

		if (!is_null($models_id)) {
			$models_id = $this->create_list_from_array($models_id);
			$params['models'] = $models_id;
		}

		return $this->post_group_link->request(NULL, $params);

	}

	/**
	 * List all existing face model into a group
	 * @param string $models_id The id of the model
	 * @param integer $limit The number of model to get
	 * @param integer $offset The offset for the model
	 * @return object Response
	 */
	public function list_models_in_group($model_id, $limit = null, $offset = null) {

		$params = array();

		if (!is_null($limit)) {
			$limit = $this->create_list_from_array($limit);
			$params['limit'] = $limit;
		}
		if (!is_null($offset)) {
			$offset = $this->create_list_from_array($offset);
			$params['offset'] = $offset;
		}

		return $this->get_group_link->request($model_id, $params);
	}

	/**
	 * Get all existing groups
	 * @return object Response
	 */
	public function list_groups($limit=null, $offset=null) {
		$params = array();

		if (!is_null($limit)) {
			$limit = $this->create_list_from_array($limit);
			$params['limit'] = $limit;
		}
		if (!is_null($offset)) {
			$offset = $this->create_list_from_array($offset);
			$params['offset'] = $offset;
		}

		return $this->get_group_link->request(null, $params);

	}

	public function add_member_to_group($group_id, $models_id, $groups_id, $identities_id) {
		$params = array();
		if (!is_null($models_id)) {
			$models_id = $this->create_list_from_array($models_id);
			$params['models'] = $models_id;
		}
		if (!is_null($groups_id)) {
			$groups_id = $this->create_list_from_array($groups_id);
			$params['groups'] = $groups_id;
		}
		if (!is_null($identities_id)) {
			$identities_id = $this->create_list_from_array($identities_id);
			$params['identities'] = $identities_id;
		}

		return $this->post_group_link->request($group_id, $params);
	}

	public function remove_member_from_group($group_id, $member_id) {
		return $this->delete_group_link->request($group_id.'/'.$member_id, array());
	}

	/**
	 * Add models into a group
	 * @param string $group_id The id of the group
	 * @param array[string] $models_id The array of face model id to put in the group
	 * @return object Response
	 */
	public function add_models_to_group($group_id, $models_id) {
		return $this->add_member_to_group($group_id, $models_id, null, null);
	}

	/**
	 * Delete a group
	 * @return object Response
	 */
	public function delete_group($group_id) {
		return $this->delete_group_link->request($group_id);
	}

	/**
	 * Remove a face model contained in a group
	 * @param string $group_id The group id
	 * @param string $model_id The models to remove
	 * @return object Response
	 */
	public function remove_model_from_group($group_id, $model_id) {
		return $this->remove_member_from_group($group_id, $model_id);
	}

	/**
	 * Edit the name of a group
	 * @param string $group_id The id of the group to edit
	 * @param string $name The name of the group
	 * @return object Response
	 */
	public function edit_group_name($group_id, $name) {

		$params = array();
		
		$params['name'] = $name;

		return $this->put_group_link->request($group_id, $params);
	}

	/***************************************************************************
	 * METHOD FOR IDENTITY MANAGEMENT
	 **************************************************************************/

	/**
	 * Get a identity by id
	 * @param string $identity_id The identity id
	 * @return object Response
	 */
	public function get_identity($identity_id) {
		return $this->get_identity_link->request($identity_id);
	}

	/**
	 * Create an identity
	 * @param array[string] The models to add into the identity
	 * @param string The identity name
	 * @param array[string] URLs to create a model from, then add model to identiy
	 * @param string The modality to use with the given URLs
	 * @return object Response
	 */
	public function create_identity(array $models_id = null,  array $urls=null, array $images_data=null, $name = null, $modality=null) {

		$params = array();

		if (!is_null($name)) {
			$params['name'] = $name;
		}

		if (!is_null($urls)) {
			$params['urls'] = $this->create_list_from_array($urls);
		}

		if (!is_null($models_id)) {
			$models_id = $this->create_list_from_array($models_id);
			$params['models'] = $models_id;
		}
		
		if(!is_null($modality)){
			if($modality == "face"){
				return $this->post_identity_face_link->request(NULL, $params, $images_data);
			}else if($modality == "speaker"){
				return $this->post_identity_speaker_link->request(NULL, $params, $images_data);
			}
		}else{
			return $this->post_identity_link->request(NULL, $params, $images_data);
		}

	}

	/**
	 * Get all existing identities
	 * @return object Response
	 */
	public function list_identities($limit=null, $offset=null){
		$params = array();

		if (!is_null($limit)) {
			$limit = $this->create_list_from_array($limit);
			$params['limit'] = $limit;
		}
		if (!is_null($offset)) {
			$offset = $this->create_list_from_array($offset);
			$params['offset'] = $offset;
		}
		return $this->get_identity_link->request(null, $params);
	}

	/**
	 * Add models into a identity
	 * @param string $identity_id The id of the identity
	 * @param array[string] $models_id The array of model id to put in the identity
	 * @return object Response
	 */
	public function add_models_to_identity($identity_id, array $models_id) {

		$params = array();

		if (!is_null($models_id)) {
			$models_id = $this->create_list_from_array($models_id);
			$params['models'] = $models_id;
		}

		return $this->post_identity_link->request($identity_id, $params);

	}

	/**
	 * Delete an identity
	 * @return object Response
	 */
	public function delete_identity($identity_id) {
		return $this->delete_identity_link->request($identity_id);
	}

	/**
	 * Remove a model from in a identity
	 * @param string $identity_id The identity id
	 * @param string $model_id The models to remove
	 * @return object Response
	 */
	public function remove_model_from_identity($identity_id, $model_id) {
		return $this->delete_identity_link->request($identity_id.'/'.$model_id, array());
	}

	/**
	 * Edit the name of a identity
	 * @param string $identity_id The id of the identity to edit
	 * @param string $name The name of the identity
	 * @return object Response
	 */
	public function edit_identity_name($identity_id, $name) {

		$params = array();
		
		$params['name'] = $name;

		return $this->put_identity_link->request($identity_id, $params);
	}

	/***************************************************************************
	 * METHOD FOR STREAM MANAGEMENT
	 **************************************************************************/
	/**
	 * Open a new stream
	 * @return String The UUID of the stream
	 */
	public function open_new_stream($modelId, $identityId, $threshold = NULL) {

		$params = array();

		if (!is_null($modelId)) {
			$params['model'] = $modelId;
		}
		if (!is_null($identityId)) {
			$params['identity'] = $identityId;
		}
		if (!is_null($threshold)) {
			$params['threshold'] = $threshold;
		}

		return $this->post_stream_link->request(NULL, $params);
	}

	/**
	 * Post a new image on the stream
	 * @param string $stream_uid The uid of the stream
	 * @param array[string] $images_data Images data
	 * @return array An empty array
	 */
	public function post_new_image($stream_uid, $images_data) {
		return $this->post_stream_link->request($stream_uid.'/', NULL, $images_data);
	}

	/**
	 * Get the state of the opened stream
	 * @param string $uid The stream UUID
	 * @return array The stream state
	 */
	public function get_stream_state($stream_uid) {
		return $this->get_stream_link->request($stream_uid, NULL);
	}

	/**
	 * Get the usage
	 */
	public function get_usage() {
		return $this->get_usage_link->request();
	}

	private function create_list_from_array(array $objects) {

		$object_list = "";

		if (is_null($objects))
			return NULL;

		if ($objects == NULL)
			return $object_list;

		foreach ($objects as $object) {
			$object_list = $object_list.$object.",";
		}

		$object_list = substr($object_list, 0, -1);

		return $object_list;
	}

}
