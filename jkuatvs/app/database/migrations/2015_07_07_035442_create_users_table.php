<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('Identity_No', 15)->unique();;
			$table->string('First_Name', 60)->nullable();
			$table->string('Last_Name', 60)->nullable();
			$table->string('User_Level', 5)->nullable();
			$table->boolean('Active');
			$table->string('Password', 60);
			$table->string('Password_temp', 60);
			$table->string('Code', 60);
			$table->timestamps();
			$table->string('remember_token', 60);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
