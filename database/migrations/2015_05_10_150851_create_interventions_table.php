<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterventionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('interventions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('ressource_id')->unsigned();
			$table->foreign('ressource_id')->references('id')->on('ressources')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('obligation_detail_id')->unsigned();
			$table->foreign('obligation_detail_id')->references('id')->on('obligations_details')
				->onUpdate('cascade')->onDelete('cascade');
			$table->datetime('date_intervention');
			$table->longtext('comment')->nullable();
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
		Schema::drop('interventions');
	}

}
