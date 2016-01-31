<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuperadminsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('superadmins', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('Users_Id')->unsigned();
			$table->integer('cCntacts_Id')->unsigned();
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
		Schema::drop('superadmins');
	}

}
