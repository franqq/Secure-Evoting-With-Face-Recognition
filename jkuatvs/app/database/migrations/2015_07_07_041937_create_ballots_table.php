<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBallotsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ballots', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('Students_Id')->unsigned();
			$table->integer('Posts_Id')->unsigned();
			$table->boolean('Casted');
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
		Schema::drop('ballots');
	}

}
