<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('Users_Id')->unsigned();
			$table->integer('Faculties_Id')->unsigned();
			$table->integer('Residences_Id')->unsigned();
			$table->integer('Contacts_Id')->unsigned();
			$table->boolean('Active');
			$table->integer('Photos_Id')->unsigned();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('students');
	}

}
