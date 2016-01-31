	<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
/*
 * unauthenticated group
 */
Route::group(array('before' => 'guest'),function()
{
	//default url directs user to the login page
	Route::get('/login',array(
		'as' => 'user-login-get',
		'uses' => 'AccountsController@getLoginPage'
	));
	//direct user to a warning page incase second phase of authentication fails
	Route::get('/warning',array(
		'as' => 'warning-page-get',
		'uses' => 'AccountsController@displayWarning'
	));
	Route::group(array('before' => 'csrf'),function()
	{
		//faculty routes
		Route::post('/login/loading',array(
			'as' => 'login-post',
			'uses' => 'AccountsController@postLogIn'
		));
	});
});

//authenticated group
Route::group(array('before'=>'auth'),function(){
	
	//logout method
	Route::get('/logout',array(
		'as' => 'user-logout',
		'uses' => 'AccountsController@logOut'
	));
	
	

	//default url directs user to the login page
	Route::get('/',array(
		'as' => 'user-dashboard-get',
		'uses' => 'AccountsController@getSelectDashboard'
	));
	
	//get functions to the voters dashboard	
	Route::get('/voter-home',array(
		'as' => 'voter-home-get',
		'uses' => 'VoterNavigationController@getVoterHome'
	));
	
	Route::get('/voter-guide',array(
		'as' => 'voter-guide-get',
		'uses' => 'VoterNavigationController@getVoterGuide'
	));
	
	Route::get('/voter-vote',array(
		'as' => 'voter-vote-get',
		'uses' => 'VoterNavigationController@getVoterVote'
	));
	Route::get('/voter-vote-next/{postid}',array(
		'as' => 'voter-vote-next-get',
		'uses' => 'VoterNavigationController@getVoterVoteNext'
	));
	Route::get('/voter-noelection',array(
		'as' => 'voter-noelection-get',
		'uses' => 'VoterNavigationController@getVoterNoElection'
	));
	
	//error incase the voter has already voted
	Route::get('/voter-voted',array(
		'as' => 'voter-voted-get',
		'uses' => 'VoterNavigationController@getVoterVoted'
	));
	
	Route::get('/voter-results',array(
		'as' => 'voter-results-get',
		'uses' => 'VoterNavigationController@getVoterResults'
	));
	
	
	//get functions to the admins dashboard	
	Route::get('/admin-home',array(
		'as' => 'admin-home-get',
		'uses' => 'AdminNavigationController@getAdminHome'
	));
	Route::get('/admin-new-candidate',array(
		'as' => 'admin-new-candidate-get',
		'uses' => 'AdminNavigationController@getNewCandidate'
	));
	Route::get('/admin-view-candidates',array(
		'as' => 'admin-view-candidates-get',
		'uses' => 'AdminNavigationController@getViewCandidates'
	));
	Route::get('/admin-new-election',array(
		'as' => 'admin-new-election-get',
		'uses' => 'AdminNavigationController@getNewElection'
	));
	Route::get('/admin-view-elections',array(
		'as' => 'admin-view-elections-get',
		'uses' => 'AdminNavigationController@getViewElections'
	));
	Route::get('/admin-new-faculty',array(
		'as' => 'admin-new-faculty-get',
		'uses' => 'AdminNavigationController@getNewFaculty'
	));
	Route::get('/admin-view-faculties',array(
		'as' => 'admin-view-faculties-get',
		'uses' => 'AdminNavigationController@getViewFaculties'
	));
	Route::get('/admin-new-post',array(
		'as' => 'admin-new-post-get',
		'uses' => 'AdminNavigationController@getNewPost'
	));
	Route::get('/admin-view-posts',array(
		'as' => 'admin-view-posts-get',
		'uses' => 'AdminNavigationController@getViewPosts'
	));
	Route::get('/admin-new-residence',array(
		'as' => 'admin-new-residence-get',
		'uses' => 'AdminNavigationController@getNewResidence'
	));
	Route::get('/admin-view-residence',array(
		'as' => 'admin-view-residence-get',
		'uses' => 'AdminNavigationController@getViewResidence'
	));
	Route::get('/admin-new-voter',array(
		'as' => 'admin-new-voter-get',
		'uses' => 'AdminNavigationController@getNewVoter'
	));
	Route::get('/admin-view-voters',array(
		'as' => 'admin-view-voters-get',
		'uses' => 'AdminNavigationController@getViewVoters'
	));
	/*
	* CSRF protection
	* */
	Route::group(array('before' => 'csrf'),function()
	{
		//common route to get the facephoto
		Route::post('/faceauth',array(
			'as' => 'faceauth-post',
			'uses' => 'AccountsController@faceUpload'
		));
		
		//faculty routes
		Route::post('/admin-new-candidates',array(
			'as' => 'admin-new-candidate-post',
			'uses' => 'AdminNavigationController@postNewCandidate'
		));
		Route::post('/admin-delete-candidate',array(
			'as' => 'admin-delete-candidate-post',
			'uses' => 'AdminNavigationController@postDeleteCandidate'
		));
		Route::post('/admin-edit-candidate',array(
			'as' => 'admin-edit-candidate-post',
			'uses' => 'AdminNavigationController@postEditCandidate'
		));
		
		//faculty routes
		Route::post('/admin-new-faculties',array(
			'as' => 'admin-new-faculty-post',
			'uses' => 'AdminNavigationController@postNewFaculty'
		));
		Route::post('/admin-delete-faculty',array(
			'as' => 'admin-delete-faculty-post',
			'uses' => 'AdminNavigationController@postDeleteFaculty'
		));
		Route::post('/admin-edit-faculty',array(
			'as' => 'admin-edit-faculty-post',
			'uses' => 'AdminNavigationController@postEditFaculty'
		));
		
		//residence routes
		Route::post('/admin-new-residence',array(
			'as' => 'admin-new-residence-post',
			'uses' => 'AdminNavigationController@postNewResidence'
		));
		Route::post('/admin-delete-residence',array(
			'as' => 'admin-delete-residence-post',
			'uses' => 'AdminNavigationController@postDeleteResidence'
		));
		Route::post('/admin-edit-residence',array(
			'as' => 'admin-edit-residence-post',
			'uses' => 'AdminNavigationController@postEditResidence'
		));
		
		//post routes
		Route::post('/admin-new-post',array(
			'as' => 'admin-new-post-post',
			'uses' => 'AdminNavigationController@postNewPost'
		));
		Route::post('/admin-delete-post',array(
			'as' => 'admin-delete-post-post',
			'uses' => 'AdminNavigationController@postDeletePost'
		));
		Route::post('/admin-edit-post',array(
			'as' => 'admin-edit-post-post',
			'uses' => 'AdminNavigationController@postEditPost'
		));
		
		//election routes
		Route::post('/admin-new-election',array(
			'as' => 'admin-new-election-post',
			'uses' => 'AdminNavigationController@postNewElection'
		));
		Route::post('/admin-delete-election',array(
			'as' => 'admin-delete-election-post',
			'uses' => 'AdminNavigationController@postDeleteElection'
		));
		Route::post('/admin-edit-election',array(
			'as' => 'admin-edit-election-post',
			'uses' => 'AdminNavigationController@postEditElection'
		));
		
		//voters routes
		Route::post('/admin-new-voters',array(
			'as' => 'admin-new-voter-post',
			'uses' => 'AdminNavigationController@postNewVoter'
		));
		Route::post('/admin-delete-voter',array(
			'as' => 'admin-delete-voter-post',
			'uses' => 'AdminNavigationController@postDeleteVoter'
		));
		Route::post('/admin-edit-voter',array(
			'as' => 'admin-edit-voter-post',
			'uses' => 'AdminNavigationController@postEditVoter'
		));
		
		
		//routes related to the super admin post functions
		//admin routes
		Route::post('/super-admin-new-admins',array(
			'as' => 'super-admin-new-admin-post',
			'uses' => 'SuperAdminNavigationController@postNewAdmin'
		));
		Route::post('/super-admin-delete-admin',array(
			'as' => 'super-admin-delete-admin-post',
			'uses' => 'SuperAdminNavigationController@postDeleteAdmin'
		));
		Route::post('/super-admin-edit-admin',array(
			'as' => 'super-admin-edit-admin-post',
			'uses' => 'SuperAdminNavigationController@postEditAdmin'
		));
		
	});
	
	//get functions for the super admin
	Route::get('/super-admin-home',array(
		'as' => 'super-admin-home-get',
		'uses' => 'SuperAdminNavigationController@getSuperAdminHome'
	));
	Route::get('/super-admin-new-admin',array(
		'as' => 'super-admin-new-admin-get',
		'uses' => 'SuperAdminNavigationController@getNewAdmin'
	));
	Route::get('/super-admin-view-admins',array(
		'as' => 'super-admin-view-admins-get',
		'uses' => 'SuperAdminNavigationController@getViewAdmins'
	));
});