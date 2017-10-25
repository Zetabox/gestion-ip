<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGedsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('geds', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('ressource_id')->unsigned();
			$table->foreign('ressource_id')->references('id')->on('ressources')
				->onUpdate('cascade')->onDelete('cascade');
			$table->string('name');
			$table->longtext('description')->nullable();
			$table->string('mime');
			$table->string('filename');
			$table->string('original_filename');
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
		Schema::drop('geds');
	}

}
