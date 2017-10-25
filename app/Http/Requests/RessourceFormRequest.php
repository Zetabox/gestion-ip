<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class RessourceFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		//return true;
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
            'date_service' => 'sometimes|required|date_format:d/m/Y',
            'name'		   => 'sometimes|required',
            'reference'		=> 'sometimes|required'

        ];
	}

}
