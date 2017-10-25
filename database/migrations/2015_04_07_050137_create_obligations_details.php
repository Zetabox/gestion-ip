<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObligationsDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('obligations_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('obligation_id')->unsigned();
			$table->foreign('obligation_id')->references('id')->on('obligations')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('frequence');
			$table->string('frequence_type')->default('Ans');
			$table->string('txt_1')->default('');
			$table->string('txt_2')->default('');
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
		Schema::drop('obligations_details');
	}

}
