<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update1Ressource extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('ressources', function(Blueprint $table)
		{
			$table->integer('domaine_id')->unsigned();
   			$table->foreign('domaine_id')->references('id')->on('domaines')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('categorie_id')->unsigned();
   			$table->foreign('categorie_id')->references('id')->on('categories')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->date('date_service');
            $table->string('reference');
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
		$table->dropcolumn('reference');
	}

}
