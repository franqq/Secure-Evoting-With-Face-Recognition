<?php

class VoterNavigationController extends BaseController {

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

	public function getVoterHome()
	{
		return View::make('voter.voter-home');
	}
	
	public function getVoterGuide()
	{
		return View::make('voter.voter-guide');
	}
	
	public function getVoterVote()
	{
		$post = Post::where('Active','=',TRUE)->first();
		View::share('post',$post);
		//get the candidates vieing fot the post 
		$candidates = Candidate::where('Posts_Id','=',$post->id)->get();
		View::share('candidates',$candidates);
		return View::make('voter.voter-vote');
	}
	public function getVoterVoteNext($postid)
	{
		$post = Post::where('id','>',$postid)->where('Active','=',TRUE);
		if($post->count())
		{
			$post = $post->first();
			View::share('post',$post);
			//get the candidates vieing fot the post 
			$candidates = Candidate::where('Posts_Id','=',$post->id)->get();
			View::share('candidates',$candidates);
			return View::make('voter.voter-vote-next');
		}
		else {
			return Redirect::route('voter-home-get')
			->with('globalsuccess','Thanks for Voting');
		}
	}
	public function getVoterNoElection()
	{
		return View::make('voter.voter-noelection');
	}
	
	public function getVoterVoted()
	{
		return View::make('voter.voter-voted');
	}
	public function getVoterResults()
	{
		return View::make('voter.voter-results');
	}
	

}
