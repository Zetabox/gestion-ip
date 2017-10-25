<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObligationClient extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//

		Schema::create('obligations_clients', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('id_obligation');
			$table->bigInteger('id_client');
			$table->boolean('actif')->default(false);
			$table->timestamps();
		});	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('obligations_clients');
	}

}
