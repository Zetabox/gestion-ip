<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddContratForm extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return \Auth::check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
		'begin_contract' => 'required|date_format:d/m/Y',
		'end_contract'	=> 'required|date_format:d/m/Y',
		'nb_obligations'=> 'required|integer',
		'nb_sites'		=> 'required|integer',
		'nb_utilisateurs' => 'required|integer'
		];
	}

}
