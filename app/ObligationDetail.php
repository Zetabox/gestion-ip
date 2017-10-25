<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ObligationDetail extends Model {

	//
	protected $table = 'obligations_details';
	public function obligation()
	{
		return $this->belongsTo('App\Obligation','id','obligation_id');
	}
	public function ressource()
	{
		return $this->hasMany('App\Ressource','ressource_id');
	}

}
