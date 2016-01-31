<?php
//include the 
include_once(app_path().'/includes/InterfaceCl.php');

class AdminNavigationController extends BaseController {

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

	public function getAdminHome()
	{
		return View::make('admin.admin-home');
	}
	public function getNewCandidate()
	{
		$faculties = Faculty::where('Active','=',TRUE)->get();
		View::share('faculties',$faculties);
		$posts = Post::where('Active','=',TRUE)->get();
		View::share('posts',$posts);
		return View::make('admin.admin-new-candidate');
	}
	public function postNewCandidate()
	{
		//verify the user input and create account
		$validator = Validator::make(Input::all(),array(
				'Students_ID'		=>'required|max:15',
				'Post'				=>'required',
				'Motto'				=>'required',
				'Photo' 			=> 'image|max:3000'
		));
		if($validator->fails())
		{
			return Redirect::route('admin-new-candidate-get')
			->withErrors($validator)
			->withInput()->with('globalerror','Sorry!! The Data was not Saved, please retry');
		}
		else
		{
			$students_ID = Input::get('Students_ID');
			$post = Input::get('Post');
			$motto = Input::get('Motto');
			$file = Input::file('Photo');
			$studentsid = null;
			$user_id=null;
			
			
			//extract the users id
			$user = User::where('Identity_No','=',$students_ID);
			//check whether the user exists
			if($user->count())
			{
				$user = $user->first();
				$user_id = $user->id;
				$student = Student::where('Users_ID',$user_id)->first();
				$studentsid = $student->id;
			}
			else {
				return Redirect::route('admin-new-candidate-get')
				->withInput()->with('globalerror','Sorry!! This Student Doesn\'t Exist');
			}
			//save the candidates photo to the candidate_photos directory
			$destinationPath = 'candidates_photos';
	        $ext      = $file->guessClientExtension();  // Get real extension according to mime type
	        $fullname = $file->getClientOriginalName(); // Client file name, including the extension of the client
	        $hashname = date('H.i.s').'-'.md5($fullname).'.'.$ext; // Hash processed file name, including the real extension
	        $upload_success = $file->move($destinationPath, $hashname);
			
			//craete the new candidates information and save in the database
			 //register the new user
			 $newcandidate		= Candidate::create(array(
			 				'Users_Id'		=>$user_id,
			 				'Students_Id'	=>$studentsid,
			 				'Posts_Id'		=>$post,
			 				'Motto'			=>$motto,
			 				'Photo'			=>'candidates_photos/'.$hashname,
							'Active'		=>TRUE,
			 ));
			
			if($newcandidate)
			return Redirect::route('admin-new-candidate-get')
					->with('globalsuccess','Candidate details have been added');
		}
	}
	
	public function getViewCandidates()
	{
		$posts = Post::where('Active','=',TRUE)->get();
		View::share('posts',$posts);
		$candidates = Candidate::where('Active','=',TRUE)->get();
		View::share('candidates',$candidates);
		return View::make('admin.admin-view-candidates');
	}
	public function postDeleteCandidate()
	{
		$candidate_id = Input::get('Candidate_ID');
		$candidate= Candidate::where('id','=',$candidate_id)->first();
		$candidate->Active = FALSE;
		if($candidate->save())
		return Redirect::route('admin-view-candidates-get')
					->with('globalsuccess','Voter details have been deleted');	
	}
	public function postEditCandidate()
	{
		//verify the user input
		$validator = Validator::make(Input::all(),array(
				'Post'		=>'',
				'Motto'		=>'',
		));	
		if($validator->fails())
		{
			return Redirect::route('admin-view-candidates-get')
					->with('globalerror','Please Try Again');
		}
		else
		{
			$candidate_id = Input::get('Candidate_ID');
			$candidate= Candidate::where('id','=',$candidate_id)->first();
			$post= Input::get('Post');
			$motto = Input::get('Motto');
			
			$candidate->Post = $post;
			$candidate->Motto = $motto;
			
			
			
			if($voter->save())
			return Redirect::route('admin-view-elections-get')
					->with('globalsuccess','Voter Details have been edited');
		}
	}
	
	
	//elections
	public function getNewElection()
	{
		return View::make('admin.admin-new-election');
	}
	public function postNewElection()
	{
		//verify the user input and create account
		$validator = Validator::make(Input::all(),array(
				'Title'						=>'required|max:60',
				'Starting_Date'				=>'required',
				'Clossing_Date'				=>'required',
		));
		if($validator->fails())
		{
			return Redirect::route('admin-new-election-get')
			->withErrors($validator)
			->withInput()->with('globalerror','Sorry!! The Data was not Saved, please retry');
		}
		else {
			$title = Input::get('Title');
			$startingdate = date("Y-m-d",strtotime(Input::get('Starting_Date')));
			$clossingdate = date("Y-m-d",strtotime(Input::get('Clossing_Date')));
			 
			 //register the new user
			 $newelection		= Election::create(array(
			 				'Title'				=>$title,
			 				'Starting_Date'		=>$startingdate,
			 				'Clossing_Date'		=>$clossingdate,
							'Active'			=>TRUE,
			 ));
			 
			 if($newelection)
			 {
				return Redirect::route('admin-new-election-get')
					->with('globalsuccess','New Post Details Have been Added');	
			 }	
		}
	}
	public function getViewElections()
	{
		
		$elections = Election::where('Active','=',TRUE)->get();
		View::share('elections',$elections);
		return View::make('admin.admin-view-elections');
	}
	public function postDeleteElection()
	{
		$election_id = Input::get('Election_ID');
		$election = Faculty::where('id','=',$election_id)->first();
		$election->Active = FALSE;
		if($election->save())
		return Redirect::route('admin-view-elections-get')
					->with('globalsuccess','Faculty details have been deleted');	
	}
	public function postEditElection()
	{
		//verify the user input
		$validator = Validator::make(Input::all(),array(
				'Title'		=>'required|max:60',
				'Starting_Date'				=>'required',
				'Clossing_Date'				=>'required',
		));	
		if($validator->fails())
		{
			return Redirect::route('admin-view-elections-get')
					->with('globalerror','Please Try Again');
		}
		else
		{
			$title = Input::get('Title');
			$startingdate = date("Y-m-d",strtotime(Input::get('Starting_Date')));
			$clossingdate = date("Y-m-d",strtotime(Input::get('Clossing_Date')));
			$id = Input::get('Election_ID');
			
			$election= Election::where('id','=',$id)->first();
			$election->Title = $title;
			$election->Starting_Date = $startingdate;
			$election->Clossing_Date = $clossingdate;
			
			if($election->save())
			return Redirect::route('admin-view-elections-get')
					->with('globalsuccess','Election Details have been edited');
		}
	}


	//faculties
	public function getNewFaculty()
	{
		return View::make('admin.admin-new-faculty');
	}
	public function postNewFaculty()
	{
		//verify the user input and create account
		$validator = Validator::make(Input::all(),array(
				'Faculty_Name'		=>'required|max:200|unique:faculties',
				'Faculty_Alias'		=>'required|max:10|unique:faculties',
				'Description'		=>'',
		));
		if($validator->fails())
		{
			return Redirect::route('admin-new-faculty-get')
			->withErrors($validator)
			->withInput()->with('globalerror','Sorry!! The Data was not Saved, please retry');
		}
		else {
			$facultyname = Input::get('Faculty_Name');
			$facultyalias = Input::get('Faculty_Alias');
			$description = Input::get('Description');
			
			 
			 //register the new user
			 $newfaculty		= Faculty::create(array(
			 				'Faculty_Name'			=>$facultyname,
			 				'Faculty_Alias'			=>$facultyalias,
			 				'Description'	=>$description,
							'Active'		=>TRUE,
			 ));
			 
			 if($newfaculty)
			 {
				return Redirect::route('admin-new-faculty-get')
					->with('globalsuccess','New Faculty Details Have been Added');	
			 }	
		}
	}
	public function getViewFaculties()
	{
		$faculties = Faculty::where('Active','=',TRUE)->get();
		View::share('faculties',$faculties);
		return View::make('admin.admin-view-faculties');
	}
	public function postDeleteFaculty()
	{
		$faculty_id = Input::get('Faculty_ID');
		$faculty = Faculty::where('id','=',$faculty_id)->first();
		$faculty->Active = FALSE;
		if($faculty->save())
		return Redirect::route('admin-view-faculties-get')
					->with('globalsuccess','Faculty details have been deleted');	
	}
	public function postEditFaculty()
	{
		//verify the user input
		$validator = Validator::make(Input::all(),array(
				'Faculty_Name'		=>'required|max:200',
				'Faculty_Alias'		=>'required|max:10',
				'Description'		=>'',
		));	
		if($validator->fails())
		{
			return Redirect::route('admin-view-faculties-get')
					->with('globalerror','Please Try Again');
		}
		else
		{
			$facultyname = Input::get('Faculty_Name');
			$facultyalias = Input::get('Faculty_Alias');
			$facultydescription = Input::get('Description');
			$id = Input::get('Faculty_ID');
			
			$faculty = Faculty::where('id','=',$id)->first();
			$faculty->Faculty_Name = $facultyname;
			$faculty->Faculty_Alias = $facultyalias;
			$faculty->Description = $facultydescription;
			
			
			$saved = $faculty->save();
			if($saved)
			return Redirect::route('admin-view-faculties-get')
					->with('globalsuccess','Faculty Details have been edited');
		}
	}
	
	//post manipulation functions
	public function getNewPost()
	{
		return View::make('admin.admin-new-post');
	}
	public function postNewPost()
	{
		//verify the user input and create account
		$validator = Validator::make(Input::all(),array(
				'Post_Name'		=>'required|max:200|unique:posts',
				'Description'			=>'',
		));
		if($validator->fails())
		{
			return Redirect::route('admin-new-post-get')
			->withErrors($validator)
			->withInput()->with('globalerror','Sorry!! The Data was not Saved, please retry');
		}
		else {
			$name = Input::get('Post_Name');
			$description = Input::get('Description');
			 
			 //register the new user
			 $newfaculty		= Post::create(array(
			 				'Post_Name'	=>$name,
			 				'Description'		=>$description,
							'Active'			=>TRUE,
			 ));
			 
			 if($newfaculty)
			 {
				return Redirect::route('admin-new-post-get')
					->with('globalsuccess','New Post Details Have been Added');	
			 }	
		}
	}
	public function getViewPosts()
	{
		$posts = Post::where('Active','=',TRUE)->get();
		View::share('posts',$posts);
		return View::make('admin.admin-view-posts');
	}
	public function postDeletePost()
	{
		$post_id = Input::get('Post_ID');
		$post= Post::where('id','=',$post_id)->first();
		$post->Active = FALSE;
		if($post->save())
		return Redirect::route('admin-view-posts-get')
					->with('globalsuccess','Post details have been deleted');	
	}
	public function postEditPost()
	{
		//verify the user input
		$validator = Validator::make(Input::all(),array(
				'Post_Name'		=>'required|max:200',
				'Description'		=>'',
		));	
		if($validator->fails())
		{
			return Redirect::route('admin-view-posts-get')
					->with('globalerror','Please Try Again');
		}
		else
		{
			$post_id = Input::get('Post_ID');
			$post= Post::where('id','=',$post_id)->first();
			$postname = Input::get('Post_Name');
			$postdescription = Input::get('Description');
			
			$post->Post_Name = $postname;
			$post->Description = $postdescription;
			
			
			$saved = $post->save();
			if($saved)
			return Redirect::route('admin-view-posts-get')
					->with('globalsuccess','Post Details have been edited');
		}
	}


	
	public function getNewResidence()
	{
		return View::make('admin.admin-new-residence');
	}
	public function postNewResidence()
	{
		//verify the user input and create account
		$validator = Validator::make(Input::all(),array(
				'Residence_Name'		=>'required|max:200|unique:residences',
				'Description'			=>'',
		));
		if($validator->fails())
		{
			return Redirect::route('admin-new-residence-get')
			->withErrors($validator)
			->withInput()->with('globalerror','Sorry!! The Data was not Saved, please retry');
		}
		else {
			$name = Input::get('Residence_Name');
			$description = Input::get('Description');
			
			 	 
			 //register the new user
			 $newresidence		= Residence::create(array(
			 				'Residence_Name'	=>$name,
			 				'Description'		=>$description,
							'Active'			=>TRUE,
			 ));
			 
			 if($newresidence)
			 {
				return Redirect::route('admin-new-residence-get')
					->with('globalsuccess','New Residence Details Have been Added');	
			 }	
		}
	}
	public function getViewResidence()
	{
		$residences = Residence::where('Active','=',TRUE)->get();
		View::share('residences',$residences);
		return View::make('admin.admin-view-residence');
	}
	public function postDeleteResidence()
	{
		$residence_id = Input::get('Residence_ID');
		$residence= Residence::where('id','=',$residence_id)->first();
		$residence->Active = FALSE;
		if($residence->save())
		return Redirect::route('admin-view-residence-get')
					->with('globalsuccess','Residence details have been deleted');	
	}
	public function postEditResidence()
	{
		//verify the user input
		$validator = Validator::make(Input::all(),array(
				'Residence_Name'	=>'required|max:200',
				'Description'		=>'',
		));	
		if($validator->fails())
		{
			return Redirect::route('admin-view-residence-get')
					->with('globalerror','Please Try Again');
		}
		else
		{
			$residence_id = Input::get('Residence_ID');
			$residence = Residence::where('id','=',$residence_id)->first();
			$residencename = Input::get('Residence_Name');
			$residencedescription = Input::get('Description');
			
			$residence->Residence_Name = $residencename;
			$residence->Description = $residencedescription;
			
			
			$saved = $residence->save();
			if($saved)
			return Redirect::route('admin-view-residence-get')
					->with('globalsuccess','Post Details have been edited');
		}
	}
	
	
	
	public function getNewVoter()
	{
		$faculties = Faculty::where('Active','=',TRUE)->get();
		View::share('faculties',$faculties);
		$residences = Residence::where('Active','=',TRUE)->get();
		View::share('residences',$residences);
		return View::make('admin.admin-new-voter');
	}		
	public function postNewVoter()
	{
		//verify the user input and create account
		$validator = Validator::make(Input::all(),array(
				'Identity_No'		=>'required',
				'Email'				=>'required|email',
				'Phone_Number'		=>'required',
				'First_Name'		=>'required',
				'Last_Name' 		=>'required',
				'Faculty'			=>'required',
				'Residence' 		=>'required',
				'Photo_1'			=>'image|required|mimes:jpeg,bmp,png',
				'Photo_2'			=>'image|required|mimes:jpeg,bmp,png',
				'Photo_3'			=>'image|required|mimes:jpeg,bmp,png',
		));
		if($validator->fails())
		{
			return Redirect::route('admin-new-voter-get')
			->withErrors($validator)
			->withInput()->with('globalerror','Sorry!! The Data was not Saved, please retry');
		}
		else {
			$identitynumber = Input::get('Identity_No');
			$email= Input::get('Email');
			$phonenumber= Input::get('Phone Numer');
			$firstname= Input::get('First_Name');
			$lastname= Input::get('Last_Name');
			$faculty_id= Input::get('Faculty');
			$residence_id= Input::get('Residence');
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
							'User_Level'	=>'voter',
			 ));
			 
			 //register the new user contact
			 $newcontact	= Contact::create(array(
			 				'Email'	=>$email,
			 				'Phone_Number'		=>$phonenumber,
			 ));
			 
			 //Save the three Photos
			 $photo1 = $this->postPhoto($photo_1,$newuser->id);
			 $photo2 = $this->postPhoto($photo_2,$newuser->id);
			 $photo3 = $this->postPhoto($photo_3,$newuser->id);
			 
			 $newphotos = Photo::create(array(
			 				'photo_1'	=>$photo1,
			 				'photo_2'	=>$photo2,
							'photo_3'	=>$photo3,
			 ));
			 
			 //save the details to the students table
			 $newstudent = Student::create(array(
			 				'Users_Id' 			=> $newuser->id,
			 				'Faculties_Id' 		=> $faculty_id,
			 				'Residences_Id' 	=> $residence_id,
			 				'Contacts_Id' 		=> $newcontact->id,
			 				'Photos_Id'			=> $newphotos->id,
			 				'Active'			=> TRUE,
			 ));
			 
			 if($newuser && $newcontact && $newphotos && $newstudent)
			 {
			 	//update the eigenfaces model with to include the new facedata
			 	putenv("PYTHONPATH=/usr/lib/python2.7");
                putenv("LD_LIBRARY_PATH=/usr/local/lib");
				
				//call python class to create the eigenfaces models from the existing photos
			    exec("python /opt/lampp/htdocs/jkuatvs/eigensave.py /opt/lampp/htdocs/jkuatvs/photos");
				
				return Redirect::route('admin-new-voter-get')
					->with('globalsuccess','New Voter Details Have been Added');	
			 }	
		}
	}

	public function getViewVoters()
	{
		$faculties = Faculty::where('Active','=',TRUE)->get();
		View::share('faculties',$faculties);
		$residences = Residence::where('Active','=',TRUE)->get();
		View::share('residences',$residences);
		$voters = Student::where('Active','=',TRUE)->get();
		View::share('voters',$voters);
		return View::make('admin.admin-view-voters');
	}
	public function postDeleteVoter()
	{
		$voter_id = Input::get('Voter_ID');
		$voter= Student::where('id','=',$voter_id)->first();
		$voter->Active = FALSE;
		if($voter->save())
		return Redirect::route('admin-view-voters-get')
					->with('globalsuccess','Voter details have been deleted');	
	}
	public function postEditVoter()
	{
		//verify the user input
		$validator = Validator::make(Input::all(),array(
				'Faculty'		=>'',
				'Residence'		=>'',
		));	
		if($validator->fails())
		{
			return Redirect::route('admin-view-voters-get')
					->with('globalerror','Please Try Again');
		}
		else
		{
			$voter_id = Input::get('Voter_ID');
			$voter = Student::where('id','=',$voter_id)->first();
			$faculty= Input::get('Faculty');
			$residence = Input::get('Residence');
			
			$voter->Faculty = $faculty;
			$voter->Redidence = $residence;
			
			
			
			if($voter->save())
			return Redirect::route('admin-view-voters-get')
					->with('globalsuccess','Voter Details have been edited');
		}
	}
	
	public function postPhoto($file,$useridentity)
	{
		//save the candidates photo to the candidate_photos directory
			$destinationPath = 'photos/'.$useridentity;
	        $ext      = $file->guessClientExtension();  // Get real extension according to mime type
	        $fullname = $file->getClientOriginalName(); // Client file name, including the extension of the client
	        $hashname = date('H.i.s').'-'.md5($fullname).'.'.$ext; // Hash processed file name, including the real extension
	        $upload_success = $file->move($destinationPath, $hashname);
			return $destinationPath . $hashname;
	}
	
}
