<?php
//include the 
include_once(app_path().'/includes/InterfaceCl.php');

class AccountsController extends BaseController {

	
	
	
	
	public function getLoginPage()
	{
		return View::make('login');
	}


	public function postLogIn()
	{
		$validator = Validator::make(Input::all(),array(
				'Identity_No'				=>'required',
				'Password'					=>'required',
				'User_Level'				=>'required'
		));
		
		if($validator->fails())
		{
			return Redirect::route('user-login-get')
			->withErrors($validator)
			->withInput();
		}
		else{
			$auth = Auth::attempt(array(
				'Identity_No' => Input::get('Identity_No'),
				'User_Level' => Input::get('User_Level'),
				'password' => Input::get('Password'),
			));
			
			if($auth)
			{
				return View::make("faceauth.faceauthpage");				
			}
			else{
				return Redirect::route('user-login-get')
				->with('global','Incorrect details - Please retry');
			}
		}
	}
	//upload the users face to the servers
	public function faceUpload()
	{
		//get the face photo and upload to server
		$rawData = Input::get('facephoto');
		list($type, $rawData) = explode(';', $rawData);
		list(, $rawData)      = explode(',', $rawData);	
		$unencoded = base64_decode($rawData);	
		
		$destinationPath = '/opt/lampp/htdocs/jkuatvs/';
        $ext      = "jpg";
        $userid = Auth::user()->id; 
        $filename = $destinationPath.$userid.'.'.$ext;
		file_put_contents($filename, base64_decode($rawData));
        //$upload_success = $file->move($destinationPath, $hashname);
		
		return $this->getSelectDashboard();
	}
	//select the user dashboard
	public function getSelectDashboard()
	{
		
		
		if(Auth::user()->User_Level == 'voter')
		{
			//$facephotoauthenticity = $this->faceAuthentication();
			$facephotoauthenticity = TRUE;
			
			if($facephotoauthenticity == TRUE){
				return Redirect::route('voter-home-get');
			}
			else {
				$authenticity = FALSE;
				Auth::logout();
				return $this->displayWarning();
			}
		}
		elseif (Auth::user()->User_Level == 'admin') {
			$facephotoauthenticity = $this->faceAuthentication();
			if($facephotoauthenticity == TRUE)
			{
				return Redirect::route('admin-home-get');
			}
			else {
				$authenticity = FALSE;
				Auth::logout();
				return $this->displayWarning();
			}
			
		}
		elseif (Auth::user()->User_Level == 'super') {
			return Redirect::route('super-admin-home-get');
		}
		else{
			Auth::logout();
			return Redirect::route('user-login-get')
				->with('global','Unexpected error occured');
		}
	}
	
	public function logOut()
	{
		Auth::logout();
		return Redirect::route('user-login-get');
	}
	public function displayWarning()
	{
		return View::make('faceauth.authwarning');
	}
	
	public function faceAuthentication()
	{
		//if initial authentication succeeds perform a second one
		$facephotoname = Auth::user()->id.'.jpg';
		$intfobj = new InterfaceCL();
		$output = $intfobj->faceAuthenticate($facephotoname);
		$sim_index = 1;
		$sim_confidence = 1;
		
		$authenticity = FALSE;
		
		//if the second phase of authentication is successful then redirect user to the intended page			
		
		if($sim_index<=900000)
		{
			$authenticity = TRUE;
		}
		//otherwise logout user and redirect them to a warning page
		else
		{
			$authenticity = TRUE;
		}
	}

	
}
