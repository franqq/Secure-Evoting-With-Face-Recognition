<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('candidates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('Users_Id')->unsigned();
			$table->integer('Students_Id')->unsigned();
			$table->integer('Posts_Id')->unsigned();
			$table->string('Motto', 100);
			$table->string('Photo', 200)->unique();
			$table->boolean('Active');
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
		Schema::drop('candidates');
	}

}
