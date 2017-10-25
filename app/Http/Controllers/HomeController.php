<?php namespace App\Http\Controllers;
use Entrust;
use App\Domaine;
use App\Site;
use App\RessourceObligation;
use App\Intervention;
use App\Ressource;
use Auth;
use App\User;
use DB;
use Mail;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		//$this->middleware('checkrole');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Entrust::hasRole('SuperAdmin')) {
        	return redirect('/admin');
    	}
    	$siteListePermission[] = null;
    	$sitePermission = Site::where('client_id',Auth::user()->id_client)->get();
    	foreach ($sitePermission as $permission) {
    		if(Entrust::can($permission->id)) $siteListePermission[]=$permission->id;
    	}
		$dateNow = Date('Y-m-d');
		if(isset($_GET['site']) && $_GET['site']<>0)
		{
			$selection = $_GET['site'];
			$sites = Site::where('client_id',Auth::user()->id_client)->where('id',$selection)->orderby('name')->with('ressource')->get();
		}
			
		else
		{
			$selection = 0;
			$sites = Site::where('client_id',Auth::user()->id_client)->whereIn('id',$siteListePermission)->orderby('name')->with('ressource')->get();
		}
			
		
		$roles = Auth::user()->roles()->lists('name');
		$domaines = Domaine::wherein('name',$roles)->get();
		foreach ($domaines as $domaine) {
			$nb_obligations[$domaine->id] = 0;
			
			foreach ($sites as $site) {
				$site_id = $site->id;
				$nb_obligations[$domaine->id] += DB::table('ressource_obligation')->distinct()->select('obligation_detail_id')->whereIn('ressource_id',function($query) use ($site_id,$domaine)
			{
				$query->select(DB::raw('id'))
					->from('ressources')
					->whereRaw('ressources.site_id='.$site_id.' and ressources.domaine_id='.$domaine->id.' and ressources.actif=1');
			})->count();
			}
		}
		$retard=0;
		$nb_obligations_totale=0;
		foreach($domaines as $domaine) {
			$nb_obligations_retard[$domaine->id] = 0;
			$nb_obligations_30[$domaine->id] = 0;
			foreach ($sites as $site) {
				$ressources = Ressource::where('domaine_id',$domaine->id)->where('actif',1)->where('site_id',$site->id)->get();
				foreach ($ressources as $ressource) {
					$obligations = RessourceObligation::where('ressource_id',$ressource->id)->with('obligation_detail')->get();
					foreach ($obligations as $value) 
					{
						$nb_obligations_totale++;
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
							$nb_obligations_retard[$domaine->id]++;
							$nb_obligations_retard_id[]=$ressource->id;
							$retard++;
						}
								
						elseif (date('Y-m-d',strtotime($date_echeance))<=date('Y-m-d',strtotime($dateNow." +30 days"))) {
							$nb_obligations_30[$domaine->id]++;
							$nb_obligations_30_id[]=$ressource->id;
						}
					}
				}
				
			}
			
		}
		if(!isset($nb_obligations)) $nb_obligations = 0;
		if(!isset($nb_obligations_retard)) $nb_obligations_retard = 0;
		if(!isset($nb_obligations_30)) $nb_obligations_30 = 0;

		//dd($nb_obligations_retard);
		if($nb_obligations_totale>0)
			$taux_conformite = round(100 * (1-($retard/$nb_obligations_totale)));
		else
			$taux_conformite = 100;
		$sites = Site::where('client_id',Auth::user()->id_client)->whereIn('id',$siteListePermission)->orderby('name')->lists('name','id');

		return view('home')->with('nb_obligations',$nb_obligations)->with('domaines',$domaines)->with('nb_obligations_retard',$nb_obligations_retard)->with('nb_obligations_30',$nb_obligations_30)
		->with('retard',$retard)->with('taux_conformite',$taux_conformite)->with('selection',$selection)->with('sites',$sites);
	}

	

}
