<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model {

	//
	protected $table = 'interventions';

	public function ressource()
	{
		return $this->belongsTo('Ressource');
	}

	public function obligation_detail()
	{
		return $this->belongsTo('App\ObligationDetail');
	}

}
