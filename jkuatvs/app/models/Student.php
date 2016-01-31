<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Student extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'students';
	protected $fillable = array('Users_Id','Faculties_Id','Residences_Id','Contacts_Id','Photos_Id','Active');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
	
	//relations
	public function User()
	{
		return $this->belongsTo('User','Users_Id','id');
	}
	public function Faculty()
	{
		return $this->belongsTo('Faculty','Faculties_Id','id');
	}
	public function Residence()
	{
		return $this->belongsTo('Residence','Residences_Id','id');
	}
	public function Contact()
	{
		return $this->belongsTo('Contact','Contacts_Id','id');
	}
	public function Photo()
	{
		return $this->belongsTo('Photo','Photos_Id','Id');
	}
	
	//sample code for relations
	/*
	public function User()
	{
		return $this->belongsTo('User','users_id','id');
	}
	public function Squeeb()
	{
		return $this->belongsTo('Squeeb','squeebs_id','id');
	}
	public function JobPhoto()
	{
		return $this->hasMany('JobPhoto','jobs_id');
	}*/

}
