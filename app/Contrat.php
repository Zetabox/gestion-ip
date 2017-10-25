<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model {

	//
	protected $table = 'contrats';
	protected $dates = array('end_contract');


	public function client()
    {
        return $this->belongsTo('App\Client', 'client_id');
    }

}
