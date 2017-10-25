<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateObligation3 extends Migration {

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
   			 $table->longtext('law')->change();
   			 $table->longtext('comment')->change();
   			 $table->longtext('description')->change();
   			 $table->longtext('source')->change();
   			 $table->longtext('txtref')->change();
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
	}

}
