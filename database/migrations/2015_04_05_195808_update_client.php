<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClient extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('clients', function($table)
		{
   			 $table->integer('nb_obligations');
   			 $table->integer('nb_sites');
   			 $table->integer('nb_utilisateurs');
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
		Schema::table('clients', function($table)
		{
  			 $table->dropColumn('nb_obligations');
   			 $table->dropColumn('nb_sites');
   			 $table->dropColumn('nb_utilisateurs');
		});
	}

}
