<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ObligationFormRequest extends Request {

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
            'name' => 'required|unique:obligations',
            'domaine_id' => 'required',
            'categorie' => 'required',
            'dma' => 'required|date_format:d/m/Y',
        ];
	}

}
