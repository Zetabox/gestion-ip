<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObligation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('obligations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->default('');
			$table->string('source')->default('');
			$table->string('txtref')->default('');
			$table->string('dma')->default('');
			$table->string('law')->default('');
			$table->string('comment')->default('');
			$table->boolean('actif')->default(false);
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
		Schema::drop('obligations');
	}

}
