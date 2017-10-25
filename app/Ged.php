<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Ged extends Model {

	//
	protected $table = 'geds';

	public function ressource()
	{
		return $this->belongsTo('Ressource');
	}

}
