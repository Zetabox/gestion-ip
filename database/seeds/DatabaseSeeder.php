<?php


//comment 
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('ClientTableSeeder');
	}

}

class ClientTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		DB::table('clients')->truncate();
		$notices = [
 			['societe' => 'Société test', 'name' => 'un nom', 'begin_contract' => new DateTime, 'end_contract' => '2015-06-13', 'remarque' => ''],
 			['societe' => 'essai', 'name' => 'choix', 'begin_contract' => new DateTime, 'end_contract' => '2015-07-13', 'remarque' => '']
 		];
		DB::table('clients')->insert($notices);

	}
}
