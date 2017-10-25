<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateObligation2 extends Migration {

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
   			 $table->integer('client_id')->default(0);
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
  			  $table->dropColumn('client_id');
		});
	}

}
