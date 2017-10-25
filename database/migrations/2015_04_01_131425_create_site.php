<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSite extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('sites', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->default('');
			$table->string('address')->default('');
			$table->string('zip')->default('');
			$table->string('city')->default('');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('client_id')->unsigned();
			$table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade')->onUpdate('cascade');;
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
		Schema::drop('sites');
	}

}
