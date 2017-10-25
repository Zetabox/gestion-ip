<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRessourceObligation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('ressource_obligation', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('obligation_detail_id')->unsigned();
			$table->foreign('obligation_detail_id')->references('id')->on('obligations_details')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('ressource_id')->unsigned();
			$table->foreign('ressource_id')->references('id')->on('ressources')
				->onUpdate('cascade')->onDelete('cascade');
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
		Schema::drop('ressource_oblligation');
	}

}
