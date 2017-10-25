<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLettreTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('lettres', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('domaine_id')->unsigned();
			$table->foreign('domaine_id')->references('id')->on('domaines')
				->onUpdate('cascade')->onDelete('cascade');
			$table->string('name');
			$table->string('description');
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
		//
		Schema::drop('lettres');
	}

}
