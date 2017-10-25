<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteUser extends Model {

	//
	protected $table = 'site_user';
	public function site()
	{
		return $this->belongsTo('App\Site');
	}
	public function user()
	{
		return $this->belongsTo('App\User');
	}

}
