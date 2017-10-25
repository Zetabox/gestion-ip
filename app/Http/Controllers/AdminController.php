<?php namespace App\Http\Controllers;
use Auth;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Zizaco\Entrust\HasRole;

use App\User;
use DB;
use App\Contrat;
use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Zizaco\Entrust\Traits\Entrust;
use Entrust;




use Illuminate\Http\Request;

class AdminController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('checkrole');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//

		//$SuperAdministrateur=Auth::user()->hasRole('Admin'); 
		$SuperAdministrateur=Entrust::hasRole('SuperAdmin');
		//$SuperAdministrateur = User::where('name','=','eredia')->first();
		//$contrats = DB::table('contrats')->orderBy('end_contract','DESC')->groupBy('client_id')->with('client')->get();
		//$contrats = Contrat::orderBy('end_contract','ASC')->groupBy('client_id')->with('client')->get();
		//$contrats = Contrat::orderby('end_contract','desc')->lists('id');
		//$cc = Contrat::whereIn('id',$contrats)->groupBy('Client_id')->get();
		/*$contrats = Contrat::where(function($query)
				{
					$query->orderby('end_contract','desc');
				})->groupby('client_id')->with('client')->get();

		dd($contrats);*/


		$clients = Contrat::distinct()->select('client_id')->get();
		foreach ($clients as $client) {
			$contrats[] = Contrat::where('client_id',$client->client_id)->with('client')->orderBy('end_contract','desc')->first();
		}
		//dd($contrats);



		if(!isset($contrats)) $contrats = [];


		//dd($cc);
		return view('homeadmin')->with('contrats',$contrats);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
