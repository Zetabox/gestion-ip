<?php namespace App\Http\Controllers;
use App\Intervention;
use App\ObligationDetail;
use App\RessourceObligation;
use Input;
use Validator;
use Session;
use Redirect;
use Auth;
use App\Ressource;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Zizaco\Entrust\HasRole;
use Illuminate\Http\Request;

class InterventionController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function createUnique($id)
	{
		//
		$obligations = RessourceObligation::where('ressource_id',$id)->with('obligation_detail')->where('obligation_detail_id',Input::get('obligation_detail_id'))->get();
		$ressource = Ressource::find($id);
		return view('interventioncreate')->with('obligations',$obligations)->with('ressource',$ressource);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		//
		$obligations = RessourceObligation::where('ressource_id',$id)->with('obligation_detail')->get();
		$ressource = Ressource::find($id);
		return view('interventioncreate')->with('obligations',$obligations)->with('ressource',$ressource);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$messages = [
    			'date_format' => 'Le format de la date doit être sour la forme jj/mm/aaaa',
    			'required' => 'Date requise'
				];
		foreach (Input::get('obligation_detail') as $value)
		{
			$rules = array('date_'.$value => 'required|date_format:d/m/Y'); 
      		$validator = Validator::make(array('date_'.$value => Input::get('date_'.$value)), $rules, $messages);
      		if($validator->passes()){ 


      			$mydate= Input::get('date_'.$value);
      			@list($jour,$mois,$annee)=explode('/',$mydate);
   				$date_intervention =  @date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
      			$intervention = new Intervention;
      			$intervention->ressource_id = Input::get('ressource_id');
      			$intervention->obligation_detail_id = $value;
      			$intervention->date_intervention = $date_intervention;
      			$intervention->comment = Input::get('comment_'.$value);
      			$intervention->save();
      			if(\Entrust::can('Ressource_edit'))
		        	return Redirect::to('/ressource/edit/'.Input::get('ressource_id'));
		        else
		        	return Redirect::to('/ressource/show/'.Input::get('ressource_id'));
      		}
      		else
      		{
      			return Redirect::to('/intervention/create/'.Input::get('ressource_id'))->withInput()->withErrors($validator);
      		}
    	}
    	

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
