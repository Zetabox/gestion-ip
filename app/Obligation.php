<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Obligation extends Model {

	//
	 protected $table = 'obligations';

	 public function obligation_detail()
	 {
	 	return $this->hasMany('App\ObligationDetail','obligation_id', 'id');
	 }

}
