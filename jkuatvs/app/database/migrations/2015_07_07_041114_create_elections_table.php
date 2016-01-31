<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('elections', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('Title', 60)->unique();
			$table->date('Starting_Date');
			$table->date('Clossing_Date');
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
		Schema::drop('elections');
	}

}
