<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('societe')->unique();
			$table->string('name')->default('');
			$table->string('firstname')->default('');
			$table->string('email')->default('');
			$table->string('telephone')->default('');
			$table->longText('remarque');
			$table->date('begin_contract');
			$table->date('end_contract');
			$table->rememberToken();
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
		//
		Schema::drop('clients');
	}

}
