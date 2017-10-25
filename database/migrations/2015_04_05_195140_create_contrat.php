<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContrat extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('contrat', function(Blueprint $table)
		{

			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->foreign('client_id')->references('id')->on('clients')
                ->onUpdate('cascade')->onDelete('cascade');
			$table->date('begin_contract');
			$table->date('end_contract');
            $table->integer('nb_obligations');
   			$table->integer('nb_sites');
   			$table->integer('nb_utilisateurs');
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
		Schema::drop('contrat');
	}

}
