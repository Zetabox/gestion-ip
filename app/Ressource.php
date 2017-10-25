<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Ressource extends Model {

	//
	protected $table = 'ressources';

	 public function site()
     {
          return $this->belongsTo('App\Site', 'site_id');
     }


}
