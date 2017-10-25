<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateObligation1 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('obligations', function($table)
		{
   			 $table->integer('categorie_id');
   			 $table->string('description')->default('');
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
			Schema::table('obligations', function($table)
		{
  			  $table->dropColumn('categorie_id');
  			  $table->dropColumn('description');
		});
	}

}
