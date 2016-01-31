<?php
//namespace KLNamespace;

require_once ("klAPI.php");

define('LENA_URL', "http://upload.wikimedia.org/wikipedia/en/2/24/Lenna.png");
define('LEO_URL', "http://www.keylemon.com/images/saas/leonardo_di_caprio/Leonardo_Di_Caprio_1.jpg");
define('PENELOPE_URLS', serialize( array(                                                                                                                                                           
      "http://www.keylemon.com/images/saas/penelope/Penelope_Cruz_1.jpg",
      "http://www.keylemon.com/images/saas/penelope/Penelope_Cruz_2.jpg",
      "http://www.keylemon.com/images/saas/penelope/Penelope_Cruz_3.jpg",
      "http://www.keylemon.com/images/saas/penelope/Penelope_Cruz_4.jpg")
));

define('FIDEL_URL', "https://www.keylemon.com/audio/tests_webservice/fidel_castro_we_have_the_power.mp3");
define('ARMSTRONG_URL', "http://upload.wikimedia.org/wikipedia/commons/4/48/Frase_de_Neil_Armstrong.ogg");

abstract class KLTest extends PHPUnit_Framework_TestCase {

    public $CONFIG;

    public function setUp(){
        $this->CONFIG = array();
        $this->CONFIG['API_HOST'] = "https://klws.keylemon.com";
        $this->CONFIG['USER'] = "test";
        $this->CONFIG['KEY']  = "test";
        $this->api = new klAPI($this->CONFIG["USER"], $this->CONFIG["KEY"], $this->CONFIG["API_HOST"]);
    }

    function download_url($url){
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}

class WrapperTest extends KLTest
{
    /**
     * @group face_test
     */
    public function testFaceDetect() {
        $response = $this->api->detect_faces(array(LENA_URL));
        $this->assertObjectHasAttribute("faces", $response);
        $this->assertObjectHasAttribute("face_id", $response->faces[0]);

        $face_id = $response->faces[0]->face_id;

        $response = $this->api->get_face($face_id);
        $this->assertObjectHasAttribute("face_id", $response);
        $this->assertObjectHasAttribute("image_url", $response);
        $this->assertObjectHasAttribute("w", $response);
        $this->assertObjectHasAttribute("h", $response);
        $this->assertObjectHasAttribute("x", $response);
        $this->assertObjectHasAttribute("y", $response);

        $response = $this->api->get_face("invalid_face_id");
        $this->assertObjectHasAttribute("errors", $response);

        # Test get face with properties
        $response = $this->api->get_face($face_id, true);
        $this->assertEquals($response->gender, "female");
        $this->assertObjectHasAttribute("age", $response);

        # Test detect face with properties
        $response = $this->api->detect_faces(array(LENA_URL), null, true);
        $this->assertObjectHasAttribute("faces", $response);
        $this->assertObjectHasAttribute("face_id", $response->faces[0]);
        $this->assertEquals("female", $response->faces[0]->gender);
        $this->assertObjectHasAttribute("age", $response->faces[0]);

    }

    /**
     * @group face_test
     */
    public function testFaceDetectWrongUrl(){
        try {
            $response = $this->api->detect_faces(array("INVALID_URL"));
        }catch (KL_Exception $expected) {
            return;
        }        
    }

    /**
     * @group model_test
     */
    public function testCreateGetUpdateModel() {
        $response = $this->api->create_model(unserialize(PENELOPE_URLS), null, null, "Penelope");
        $this->assertObjectHasAttribute("model_id", $response);
        $this->assertObjectHasAttribute("faces", $response);
        $this->assertObjectHasAttribute("modality", $response);
        $this->assertEquals("Penelope", $response->name);
        $this->assertEquals("face", $response->modality);
        $model_id = $response->model_id;

        $response = $this->api->get_model($model_id);
        $this->assertEquals($model_id, $response->model_id);
        $this->assertEquals(4, $response->nb_faces);

        $response = $this->api->edit_model_name($model_id, "pene new name");
        $this->assertEquals("pene new name", $response->name);

        $response = $this->api->delete_model($model_id);
    }

    /**
     * @group model_test
     */
    public function testCreateSpeakerModel() {
        $response = $this->api->create_speaker_model(array(FIDEL_URL), null, "funny fidel");
        $this->assertObjectHasAttribute("model_id", $response);
        $this->assertObjectHasAttribute("modality", $response);
        $this->assertEquals("funny fidel", $response->name);
        $this->assertEquals("speaker", $response->modality);
    }

    /**
     * @group model_test
     */
    public function testAdaptModel() {
        $response = $this->api->create_model(array_slice(unserialize(PENELOPE_URLS),0, 1));
        $this->assertObjectHasAttribute("model_id", $response);
        $this->assertEquals(1, $response->nb_faces);
        $model_id = $response->model_id;

        $response = $this->api->adapt_model($model_id, array_slice(unserialize(PENELOPE_URLS),1, 1));
        $this->assertEquals($model_id, $response->model_id);
        $this->assertEquals(2, $response->nb_faces);

        $response = $this->api->delete_model($model_id);
    }

    /**
     * @group model_test
     */
    public function testListModel() {
        $response = $this->api->list_models();
        $this->assertObjectHasAttribute("nb_models", $response);
        $this->assertLessThan(21, count($response->models));
    }

    /**
     * @group recognize_test
     */
    public function testRecognizeFace() {
        $response = $this->api->create_model(unserialize(PENELOPE_URLS), null, null, "Penelope");
        $this->assertObjectHasAttribute("model_id", $response);
        $model_id = $response->model_id;

        $one_face = array_slice(unserialize(PENELOPE_URLS), 0, 1);
        $response = $this->api->recognize_face(array($model_id), $one_face);
        $this->assertObjectHasAttribute("faces", $response);
        $this->assertGreaterThan(0.5, $response->faces[0]->results[0]->score);

        # Test with image of another person (get lower score)
        $response = $this->api->recognize_face(array($model_id), array(LENA_URL));
        $this->assertObjectHasAttribute("faces", $response);
        $this->assertLessThan(0.5, $response->faces[0]->results[0]->score);

        # Test mean
        $response = $this->api->recognize_face(array($model_id), unserialize(PENELOPE_URLS), null, null, null, TRUE);
        $this->assertObjectHasAttribute("models", $response);
        $this->assertGreaterThan(0.5, $response->models[0]->score);
    }

    /**
     * @group recognize_test
     */
    public function testRecognizeSpeaker() {
        $response = $this->api->create_speaker_model(array(FIDEL_URL), null, "funny fidel");
        $this->assertObjectHasAttribute("model_id", $response);
        $model_id = $response->model_id;

        $response = $this->api->recognize_speaker(array($model_id), null, array(FIDEL_URL), null, null, FALSE);
        $this->assertObjectHasAttribute("audios", $response);
        $this->assertGreaterThan(0.5, $response->audios[0]->results[0]->score);

        $response = $this->api->recognize_speaker(array($model_id), null, array(ARMSTRONG_URL), null, null, FALSE);
        $this->assertObjectHasAttribute("errors", $response);
        $this->assertEquals(23, $response->errors[0]->error_id);

    }

	/**
	 * @group recognize_test
	 */
	public function testRecognizeFaceAsync(){
		
		$response = $this->api->create_model(unserialize(PENELOPE_URLS), null, null, "Penelope");
        $this->assertObjectHasAttribute("model_id", $response);
        $model_id = $response->model_id;

        $one_face = array_slice(unserialize(PENELOPE_URLS), 0, 1);
				
        $response = $this->api->recognize_face_async($one_face, array(), array(), array($model_id));
        $this->assertObjectHasAttribute("status", $response);
		
		$this->assertEquals("PEN", $response->status->status);
		$this->assertEquals("0.00", $response->status->progress);
		
		do{
			$response = $this->api->get_status($response->status->status_id);
		}while($response->status->status != "FIN");
				
		$response = $this->api->get_status_result($response->status->status_id);
		
        # Test with image of another person (get lower score)
        $this->assertObjectHasAttribute("faces", $response);
        $this->assertGreaterThan(0.5, $response->faces[0]->results[0]->score);
		
	}

    /**
     * @group stream_test
     */
    public function testStream(){
        $response = $this->api->create_model(unserialize(PENELOPE_URLS), null, null, "Penelope");
        $this->assertObjectHasAttribute("model_id", $response);
        $model_id = $response->model_id;

        $response = $this->api->open_new_stream($model_id, null);
        $this->assertObjectHasAttribute("uid", $response);
        $stream_uid = $response->uid;

        $penelope_image_data = array($this->download_url(unserialize(PENELOPE_URLS)[0]));
        for ($i = 0; $i < 3; $i++){
            $response = $this->api->post_new_image($stream_uid, $penelope_image_data);
        }

        $response = $this->api->get_stream_state($stream_uid);
        $this->assertObjectHasAttribute("authenticated", $response);
        $this->assertEquals(TRUE, $response->authenticated);
        $this->assertEquals(TRUE, $response->closed);

        # Same test but with impostor
        $response = $this->api->open_new_stream($model_id, null);
        $this->assertObjectHasAttribute("uid", $response);
        $stream_uid = $response->uid;

        $lena_image_data = array($this->download_url(LEO_URL));
        for ($i = 0; $i < 3; $i++){
            $response = $this->api->post_new_image($stream_uid, $lena_image_data);
        }

        $response = $this->api->get_stream_state($stream_uid);
        $this->assertObjectHasAttribute("authenticated", $response);
        $this->assertEquals(FALSE, $response->authenticated);
        $this->assertEquals(FALSE, $response->closed);

    }

    /**
     * @group group_test
     */
    public function testCreateGroup() {
        $response = $this->api->create_group(null, "empty group");
        $this->assertObjectHasAttribute("group_id", $response);
        $this->assertObjectHasAttribute("nb_models", $response);
        $this->assertEquals(0, $response->nb_models);
        $this->assertEquals("empty group", $response->name);

        $group_id = $response->group_id;
        $response = $this->api->edit_group_name($group_id, "new group name");
        $this->assertEquals("new group name", $response->name);
    }

    /**
     * @group group_test
     */
    public function testAddAndRemoveModelGroup() {
        $one_url = array_slice(unserialize(PENELOPE_URLS), 0, 1);
        $response = $this->api->create_model($one_url, null, null, "Penelope");
        $this->assertObjectHasAttribute("model_id", $response);
        $model_id1 = $response->model_id;

        $response = $this->api->create_model($one_url, null, null, "Penelope");
        $this->assertObjectHasAttribute("model_id", $response);
        $model_id2 = $response->model_id;

        $response = $this->api->create_group(array($model_id1), "some group");
        $this->assertObjectHasAttribute("group_id", $response);
        $this->assertObjectHasAttribute("nb_models", $response);
        $this->assertEquals(1, $response->nb_models);
        $group_id = $response->group_id;

        $response = $this->api->add_models_to_group($group_id, array($model_id2));
        $this->assertEquals(2, $response->nb_models);

        $response = $this->api->remove_model_from_group($group_id, $model_id2);
        $this->assertEquals(1, $response->nb_models);

        $response = $this->api->delete_group($group_id);

    }

    /**
     * @group group_test
     */
    public function testAddAndRemoveMemberGroup() {
        $one_url = array_slice(unserialize(PENELOPE_URLS), 0, 1);
        $response = $this->api->create_model($one_url, null, null, "Penelope");
        $this->assertObjectHasAttribute("model_id", $response);
        $model_id1 = $response->model_id;

        $response = $this->api->create_model($one_url, null, null, "Penelope");
        $this->assertObjectHasAttribute("model_id", $response);
        $model_id2 = $response->model_id;

        $response = $this->api->create_identity(null, null, null, "identity", null);
        $this->assertObjectHasAttribute("identity_id", $response);
        $this->assertObjectHasAttribute("nb_models", $response);
        $this->assertEquals(0, $response->nb_models);
        $identity_id = $response->identity_id;

        $response = $this->api->create_group(null, "group 1");
        $this->assertObjectHasAttribute("group_id", $response);
        $this->assertObjectHasAttribute("nb_models", $response);
        $this->assertObjectHasAttribute("nb_groups", $response);
        $this->assertObjectHasAttribute("nb_identities", $response);
        $this->assertEquals(0, $response->nb_models);
        $group_id1 = $response->group_id;

        $response = $this->api->create_group(array($model_id1), "group 2");
        $this->assertObjectHasAttribute("group_id", $response);
        $this->assertObjectHasAttribute("nb_models", $response);
        $this->assertObjectHasAttribute("nb_groups", $response);
        $this->assertObjectHasAttribute("nb_identities", $response);
        $this->assertEquals(1, $response->nb_models);
        $group_id2 = $response->group_id;

        $response = $this->api->add_member_to_group($group_id2, array($model_id2), null, null);
        $this->assertEquals(2, $response->nb_models);
        $this->assertEquals(0, $response->nb_groups);
        $this->assertEquals(0, $response->nb_identities);

        $response = $this->api->add_member_to_group($group_id2, null, array($group_id1), null);
        $this->assertEquals(2, $response->nb_models);
        $this->assertEquals(1, $response->nb_groups);
        $this->assertEquals(0, $response->nb_identities);

        $response = $this->api->add_member_to_group($group_id2, null, null, array($identity_id));
        $this->assertEquals(2, $response->nb_models);
        $this->assertEquals(1, $response->nb_groups);
        $this->assertEquals(1, $response->nb_identities);

        $response = $this->api->remove_member_from_group($group_id2, $group_id1);
        $this->assertEquals(2, $response->nb_models);
        $this->assertEquals(0, $response->nb_groups);
        $this->assertEquals(1, $response->nb_identities);

        $response = $this->api->remove_member_from_group($group_id2, $model_id2);
        $this->assertEquals(1, $response->nb_models);
        $this->assertEquals(0, $response->nb_groups);
        $this->assertEquals(1, $response->nb_identities);

        $response = $this->api->remove_member_from_group($group_id2, $identity_id);
        $this->assertEquals(1, $response->nb_models);
        $this->assertEquals(0, $response->nb_groups);
        $this->assertEquals(0, $response->nb_identities);
    }

    /**
     * @group group_test
     */
    public function testListGroup() {
        $response = $this->api->list_groups();
        $this->assertObjectHasAttribute("nb_groups", $response);
        $this->assertObjectHasAttribute("groups", $response);
    }

    /**
     * @group identity_test
     * create_identity : array $models_id = null,  array $urls=null, array $images_data=null, $name = null, $modality=null
     */
    public function testCreateIdentity() {
        $response = $this->api->create_identity(null, null, null, "empty identity", null);
        $this->assertObjectHasAttribute("identity_id", $response);
        $this->assertObjectHasAttribute("nb_models", $response);
        $this->assertEquals(0, $response->nb_models);
        $this->assertEquals("empty identity", $response->name);

        $identity_id = $response->identity_id;
        $response = $this->api->edit_identity_name($identity_id, "new identity name");
        $this->assertEquals("new identity name", $response->name);
    }

    /**
     * @group identity_test
     */
    public function testAddAndRemoveModelIdentity() {
        $one_url = array_slice(unserialize(PENELOPE_URLS), 0, 1);
        $response = $this->api->create_model($one_url, null, null, "Penelope");
        $this->assertObjectHasAttribute("model_id", $response);
        $model_id1 = $response->model_id;

        $response = $this->api->create_model($one_url, null, null, "Penelope");
        $this->assertObjectHasAttribute("model_id", $response);
        $model_id2 = $response->model_id;

        $response = $this->api->create_identity(array($model_id1), null, null, "some identity", null);
        $this->assertObjectHasAttribute("identity_id", $response);
        $this->assertObjectHasAttribute("nb_models", $response);
        $this->assertEquals(1, $response->nb_models);
        $identity_id = $response->identity_id;

        $response = $this->api->add_models_to_identity($identity_id, array($model_id2));
        $this->assertEquals(2, $response->nb_models);

        $response = $this->api->remove_model_from_identity($identity_id, $model_id2);
        $this->assertEquals(1, $response->nb_models);

        $response = $this->api->delete_identity($identity_id);
    }

    /**
     * @group identity_test
     */
    public function testListIdentity() {
        $response = $this->api->list_identities();
        $this->assertObjectHasAttribute("nb_identities", $response);
        $this->assertObjectHasAttribute("identities", $response);
    }

    /**
     * @group identity_test
     */
    public function testCreateModelShortcutIdentity() {
        $response = $this->api->create_identity(null, unserialize(PENELOPE_URLS), null, "face identity", "face");
        $this->assertObjectHasAttribute("identity_id", $response);
        $this->assertObjectHasAttribute("nb_models", $response);
        $this->assertEquals(1, $response->nb_models);

        $response = $this->api->create_identity(null, array(FIDEL_URL), null, "speaker identity", "speaker");
        $this->assertObjectHasAttribute("identity_id", $response);
        $this->assertObjectHasAttribute("nb_models", $response);
        $this->assertEquals(1, $response->nb_models);
    }
}

?>
