<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Lettre extends Model {

	//
	protected $table = 'lettres';

	public function domaine()
    {
        return $this->belongsTo('App\Domaine', 'domaine_id');
    }
}
