<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model {

	//
	protected $table = 'sites';

	public function responsable()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function client()
    {
    	return $this->belongsTo('App\Client', 'client_id');
    }
    public function ressource()
    {
    	return $this->hasMany('App\Ressource', 'site_id','id');
    }

}