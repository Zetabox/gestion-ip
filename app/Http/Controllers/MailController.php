<?php namespace App\Http\Controllers;

use Entrust;
use App\Domaine;
use App\Site;
use App\RessourceObligation;
use App\Intervention;
use App\Ressource;
use Auth;
use App\Contrat;
use App\User;
use DB;
use Mail;

class MailController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function mail_client()
	{
		//
		$dateNow = date('Y-m-d');
		$users = User::where('id_client',0)->get();
		
		$clients = Contrat::distinct()->select('client_id')->get();
		foreach ($clients as $client) {
			$contrats[] = Contrat::where('client_id',$client->client_id)->with('client')->orderBy('end_contract','desc')->first();
		}
		



		if(!isset($contrats)) $contrats = [];


		foreach($users as $user)
		{
			$data = array('contrats'=>$contrats,'name'=>$user->name,'email'=>$user->email);
			Mail::send('emails.client_retard', $data, function($message) use($user)
				{
					$message->to($user->email, $user->name)->subject('Gestion de vos obligations!');
				});
		}
		

	}

	public function mail_envoyer(){

		$dateNow = Date('Y-m-d');


		/*if(isset($_GET['site']) && $_GET['site']<>0)
		{
			$selection = $_GET['site'];
			$sites = Site::where('client_id',Auth::user()->id_client)->where('id',$selection)->orderby('name')->with('ressource')->get();
		}
			
		else
		{
			$selection = 0;
			$sites = Site::where('client_id',Auth::user()->id_client)->orderby('name')->with('ressource')->get();
		}*/
			
		$sites = Site::all();

			
			foreach ($sites as $site) {
				$nb_obligations_retard_id[]= null;
				$nb_obligations_30_id[]= null;
				
				$ressources = Ressource::Where('actif',1)->where('site_id',$site->id)->get();
				foreach ($ressources as $ressource) {
					$obligations = RessourceObligation::where('ressource_id',$ressource->id)->with('obligation_detail')->get();
					foreach ($obligations as $value) 
					{
						
						$intervention = Intervention::where('ressource_id',$ressource->id)->where('obligation_detail_id',$value->obligation_detail->id)->orderBy('date_intervention','desc')->first();
						if(empty($intervention))
						{
							$date_service = $ressource->date_service;
							$intervention = '';
						}
						else
						{
							$date_service = $intervention->date_intervention;
							$intervention = date('d/m/Y',strtotime($date_service));

						}
						switch($value->obligation_detail->frequence_type)
							{
								case 'ans':
									$date_echeance =  date('Y-m-d',strtotime($date_service." +".$value->obligation_detail->frequence." years"));
									break;
								case 'mois':
									$date_echeance =  date('Y-m-d',strtotime($date_service." +".$value->obligation_detail->frequence." month"));
									break;
								case 'jours':
									$date_echeance =  date('Y-m-d',strtotime($date_service." +".$value->obligation_detail->frequence." days"));
									break;
							}
							
						if(date('Y-m-d',strtotime($date_echeance))<=$dateNow){
							
							$nb_obligations_retard_id[]=$ressource->name.' - '.date('d/m/Y',strtotime($date_echeance));
							
							
						}
								
						elseif (date('Y-m-d',strtotime($date_echeance))<=date('Y-m-d',strtotime($dateNow." +30 days"))) {
							
							$nb_obligations_30_id[]=$ressource->name.' - '.date('d/m/Y',strtotime($date_echeance));
							
						}
					}
				}
			//$results_retard = Ressource::whereIn('id',$nb_obligations_retard_id)->lists('name');
			//$results_30 = Ressource::whereIn('id',$nb_obligations_30_id)->lists('name');
			if(count($nb_obligations_30_id)>1 || count($nb_obligations_retard_id)>1)
			{	
				$users = User::find($site->user_id);
				$data = array('ressource_retard'=>$nb_obligations_retard_id,'ressource_30'=>$nb_obligations_30_id,'name'=>$users->name,'email'=>$users->email,'site'=>$site->name);
				Mail::send('emails.essai', $data, function($message)
				{
					$message->to($users->email, $users->name)->subject('Gestion de vos obligations!');
				});
				}
			unset($nb_obligations_retard_id);
			unset($nb_obligations_30_id);
			
			}

		
		
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
