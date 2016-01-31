<?php

class SuperAdminNavigationController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getSuperAdminHome()
	{
		return View::make('superadmin.super-admin-home');
	}
	public function getNewAdmin()
	{
		return View::make('superadmin.super-admin-new-admin');
	}
	public function getViewAdmins()
	{
		$admins = Admin::where('Active','=',TRUE)->get();
		View::share('admins',$admins);
		return View::make('superadmin.super-admin-view-admins');
	}
		public function postNewAdmin()
	{
		//verify the user input and create account
		$validator = Validator::make(Input::all(),array(
				'Identity_No'		=>'required',
				'Email'				=>'required|email',
				'Phone_Number'		=>'required',
				'First_Name'		=>'required',
				'Last_Name' 		=>'required',
				'Photo_1'			=>'image|required',
				'Photo_2'			=>'image|required',
				'Photo_3'			=>'image|required',
		));
		if($validator->fails())
		{
			return Redirect::route('super-admin-new-admin-get')
			->withErrors($validator)
			->withInput()->with('globalerror','Sorry!! The Data was not Saved, please retry');
		}
		else {
			$identitynumber = Input::get('Identity_No');
			$email= Input::get('Email');
			$phonenumber= Input::get('Phone Numer');
			$firstname= Input::get('First_Name');
			$lastname= Input::get('Last_Name');
			$photo_1= Input::file('Photo_1');
			$photo_2= Input::file('Photo_2');
			$photo_3= Input::file('Photo_3');
			
			
			 //register the new user
			 $newuser = User::create(array(
			 				'Identity_No'	=>$identitynumber,
			 				'First_Name'	=>$firstname,
			 				'Last_Name'		=>$lastname,
			 				'Password'		=>Hash::make($identitynumber),
							'Active'		=>TRUE,
			 ));
			 
			 //register the new user contact
			 $newcontact	= Contact::create(array(
			 				'Email'	=>$email,
			 				'Phone_Number'		=>$phonenumber,
			 ));
			 
			 //Save the three Photos
			 $photo1 = $this->postPhoto($photo_1);
			 $photo2 = $this->postPhoto($photo_2);
			 $photo3 = $this->postPhoto($photo_3);
			 
			 $newphotos = Photo::create(array(
			 				'photo_1'	=>$photo1,
			 				'photo_2'	=>$photo2,
							'photo_3'	=>$photo3,
			 ));
			 
			 //save the details to the students table
			 $newadmin = Admin::create(array(
			 				'Users_Id' 			=> $newuser->id,
			 				'Contacts_Id' 		=> $newcontact->id,
			 				'Photos_Id'			=> $newphotos->id,
			 ));
			 
			 if($newuser && $newcontact && $newphotos && $newadmin)
			 {
				return Redirect::route('super-admin-new-admin-get')
					->with('globalsuccess','New Admin Details Have been Added');	
			 }	
		}
	}

	
	public function postDeleteAdmin()
	{
		$admin_id = Input::get('Admin_ID');
		$admin= Admin::where('id','=',$admin_id)->first();
		$admin->Active = FALSE;
		if($admin->save())
		return Redirect::route('super-admin-view-admins-get')
					->with('globalsuccess','Admin details have been deleted');	
	}
	public function postEditAdmin()
	{
		
	}
	
	public function postPhoto($file)
	{
		//save the candidates photo to the candidate_photos directory
			$destinationPath = 'photos';
	        $ext      = $file->guessClientExtension();  // Get real extension according to mime type
	        $fullname = $file->getClientOriginalName(); // Client file name, including the extension of the client
	        $hashname = date('H.i.s').'-'.md5($fullname).'.'.$ext; // Hash processed file name, including the real extension
	        $upload_success = $file->move($destinationPath, $hashname);
			return $destinationPath . $hashname;
	}
	
}
