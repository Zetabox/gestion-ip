<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RessourceObligation extends Model {

	//
	protected $table = 'ressource_obligation';
	public function obligation_detail()
	{
		return $this->belongsTo('App\ObligationDetail');
	}
	public function ressource()
	{
		return $this->belongsTo('App\Ressource');
	}

}
