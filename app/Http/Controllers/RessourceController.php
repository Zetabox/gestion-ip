<?php namespace App\Http\Controllers;
use DB;
use Response;
use App\User;
use App\Domaine;
use Session;
use Auth;
use Input;
use App\Site;
use App\Ged;
use App\Categorie;
use App\Obligation;
use App\Intervention;
use App\ObligationDetail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ressource;
use App\RessourceObligation;
use App\Http\Requests\RessourceFormRequest;
use App\Http\Requests\SearchFormRequest;
use Entrust;

use Illuminate\Http\Request;

class RessourceController extends Controller {
	
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
		
		
		return redirect('ressource/list/0');

		
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function liste($id)
	{
		//
		//if(!$id) $id=1;
		$site_id = (isset($_GET['site'])) ? $_GET['site'] : 0;
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$sens = (isset($_GET['sens'])) ? $_GET['sens'] : 'ASC';
		$roles = Auth::user()->roles()->lists('name');
		$domaines = Domaine::wherein('name',$roles)->get();
		
		if($id==0) $id=$domaines->first()->id;
		$client_id = Auth::user()->id_client;
		$siteListePermission[] = null;
		$sitePermission = Site::where('client_id',Auth::user()->id_client)->get();
    	foreach ($sitePermission as $permission) {
    		if(Entrust::can($permission->id)) $siteListePermission[]=$permission->id;
    	}
		if($site_id<>0)
			$ressources = Ressource::where('domaine_id',$id)->where('site_id',$site_id)->with('site')->orderBy($sort, $sens)->paginate(10);
		else
			$ressources = Ressource::where('domaine_id',$id)->with('site')->whereIn('site_id',$siteListePermission)->orderBy($sort, $sens)->paginate(10);
		$sites = Site::where('client_id',Auth::user()->id_client)->whereIn('id',$siteListePermission)->lists('name','id');
		return view('ressourcelist')->with('domaines',$domaines)->with('results',$ressources)->with('sort',$sort)->with('sens',$sens)->with('id',$id)->with('client_id',$client_id)->with('sites',$sites);

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function dashboard($id)
	{
		//
		$domaines = Domaine::find($id);

		if(!Entrust::hasRole($domaines->name)) return redirect('/');
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
			
		
				
		
		$nb_obligations_retard_id[]=0;
		$nb_obligations_30_id[]=0;
			
			
			foreach ($sites as $site) {
				$ressources = Ressource::where('domaine_id',$id)->where('actif',1)->where('site_id',$site->id)->get();
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
							
							$nb_obligations_retard_id[]=$ressource->id;
							
						}
								
						elseif (date('Y-m-d',strtotime($date_echeance))<=date('Y-m-d',strtotime($dateNow." +30 days"))) {
							
							$nb_obligations_30_id[]=$ressource->id;
						}
					}
				}
				
			}
			$results_retard = Ressource::whereIn('id',$nb_obligations_retard_id)->paginate(10);
			$results_30 = Ressource::whereIn('id',$nb_obligations_30_id)->paginate(10);
		
		$roles = Auth::user()->roles()->lists('name');
		$domaines = Domaine::wherein('name',$roles)->get();
		$sites = Site::where('client_id',Auth::user()->id_client)->lists('name','id');
		return view('dashboardlist')->with('domaines',$domaines)->with('results_retard',$results_retard)->with('results_30',$results_30)->with('id',$id)->with('client_id',Auth::user()->id_client)->with('sites',$sites);

	}

	/**
	 * Search Ressource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function search(SearchFormRequest $request)
	{
		//
		
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$sens = (isset($_GET['sens'])) ? $_GET['sens'] : 'ASC';
	
		$q = Input::get('query');
		$domaine_id = Input::get('domaine_id');
		$client_id = Auth::user()->id_client;
		$site_id = (isset($_POST['site'])) ? $_POST['site'] : 0;
		$siteListePermission[] = null;
    	$sitePermission = Site::where('client_id',Auth::user()->id_client)->get();
    	foreach ($sitePermission as $permission) {
    		if(Entrust::can($permission->id)) $siteListePermission[]=$permission->id;
    	}
		//if($site_id<>0)
		//	$ressources = Ressource::where('domaine_id',$domaine_id)->where('site_id',$site_id)->with('site')->orderBy($sort, $sens)->paginate(10);
		//else
		//	$ressources = Ressource::where('domaine_id',$domaine_id)->with('site')->orderBy($sort, $sens)->paginate(10);
		$sites = Site::where('client_id',Auth::user()->id_client)->whereIn('id',$siteListePermission)->lists('name','id');

  		if($q && $q != ''){
    		$searchTerms = explode(' ', $q);
    		//$query = DB::table('ressources');  
    		$results = Ressource::with('site')->where(function($query) use ($searchTerms,$site_id,$domaine_id,$siteListePermission)
    		{
	    		if(!empty($searchTerms)){

	      			foreach($searchTerms as $term){
	      				if($site_id<>0)
	        				$query->where('name', 'LIKE', '%'. $term .'%')->where('domaine_id',$domaine_id)->where('site_id',$site_id)->whereIn('site_id',$siteListePermission);
	        			else
	        				$query->where('name', 'LIKE', '%'. $term .'%')->where('domaine_id',$domaine_id)->whereIn('site_id',$siteListePermission);
	        			
	      			}
	    		}
	    		//$results = $query->with('site')->paginate(10);
    		})->paginate(10);

    	
   		}
    	$roles = Auth::user()->roles()->lists('name');
		$domaines = Domaine::wherein('name',$roles)->get();
		
		

    	
		return view('ressourcelist')->with('domaines',$domaines)->with('results',$results)->with('sort',$sort)->with('sens',$sens)->with('id',$domaine_id)->with('client_id',$client_id)->with('sites',$sites)->with('select',$site_id);
	}
	public function assistant(RessourceFormRequest $request)
	{
		$id = $request->id;
		
		//echo $id.'<BR>'.$request->domaine;die();
		switch($id)
		{
			case 1:
				$domaine = Domaine::find($request->domaine_id);
				Session::put('domaine_name', $domaine->name);
				Session::put('domaine_id', $request->domaine_id);
				$categories = Categorie::where('domaine_id',$request->domaine_id)->lists('name','id');
				if(empty($categories))
				{
					Session::flash('message', 'Ce domaine ne contient pas de catégorie');
					return redirect('ressource/create');

				}
					
				$sites = Site::where('client_id',Auth::user()->id_client)->lists('name','id');
				if(empty($sites))
				{
					Session::flash('message', 'vous devez avant créer un site');
					return redirect('ressource/create');

				}
				return view('ressourcecreate1')->with('domaine_name',$domaine->name)->with('categories',$categories)->with('sites',$sites)->with('domaine_id',$request->domaine_id);
			case 2:
				$ressource = new Ressource;
				$ressource->name = $request->name;
				$ressource->site_id = $request->site_id;
				$ressource->domaine_id = $request->domaine_id;
				$ressource->categorie_id = $request->categorie_id;
				$ressource->date_service = implode('/', array_reverse( explode('/',$request->date_service) ) );
				$ressource->reference = $request->reference;
				$ressource->save();
				// 
				$ressource_id = $ressource->id;
				$obligations = Obligation::where('categorie_id',$request->categorie_id)->where('actif',1)->where(function($query)
				{
					$query->where('client_id',0)
					->orwhere('client_id',Auth::user()->id_client);
				})->with('obligation_detail')->get();
				

				//var_dump($obligations->obligation_detail->id);die();	
				//$obligations = Obligation::find(1)->obligation_detail;
		
				$categorie = Categorie::find($request->categorie_id);
				return view('ressourcecreate2')->with('domaine_name', Session::get('domaine_name'))->with('categorie_name',$categorie->name)
					->with('name',$request->name)->with('reference',$request->reference)->with('date_service',$request->date_service)->with('obligations',$obligations)->with('ressource_id',$ressource_id);

		}

	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function addobligation($id)
	{
		//
		$ressource = Ressource::where('id',$id)->first();
		$obligations = Obligation::where('categorie_id',$ressource->categorie_id)->where('actif',1)->where(function($query)
				{
					$query->where('client_id',0)
					->orwhere('client_id',Auth::user()->id_client);
				})->with('obligation_detail')->get();
		$obligations_details = DB::table('ressource_obligation')->select('obligation_detail_id')->where('ressource_id',$id)->get();
		foreach($obligations_details as $obd)
		{
			$tab[] = $obd->obligation_detail_id;
		}
		if(!isset($tab)) $tab=array();
		return view('addobligationdetail')->with('obligations',$obligations)->with('name',$ressource->name)->with('ressource_id',$id)->with('tab',$tab);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$roles = Auth::user()->roles()->lists('name');
		$domaines = Domaine::wherein('name',$roles)->get();
		
		
		return view('ressourcecreate')->with('domaines',$domaines);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(RessourceFormRequest $request)
	{
		// inscription des obligations
		if(isset($_POST['obligation_detail_id']))
		{
			foreach ($request->obligation_detail_id as $key) {
				$ressource_obligation = new RessourceObligation;
				$ressource_obligation->ressource_id = $request->ressource_id;
				$ressource_obligation->obligation_detail_id = $key;
				$ressource_obligation->save();
			}
		}
		
		if(isset($_POST['provenance']))
		{
			return redirect('/ressource/edit/'.$request->ressource_id);
		}
		else
		{
			return view('ressourceend')->with('ressource_id',$request->ressource_id);
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
		$now = date('Y-m-d'); 
		$ressource = Ressource::find($id);
		$obligations = RessourceObligation::where('ressource_id',$id)->with('obligation_detail')->get();
		
		foreach ($obligations as $value) 
		{
			$intervention = Intervention::where('ressource_id',$id)->where('obligation_detail_id',$value->obligation_detail->id)->orderBy('date_intervention','desc')->first();
			if(empty($intervention))
			{
				//echo 'pas intervention';
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
						$date_echeance = date('Y-m-d',strtotime($date_service." +".$value->obligation_detail->frequence." years"));
						break;
					case 'mois':
						$date_echeance = date('Y-m-d',strtotime($date_service." +".$value->obligation_detail->frequence." month"));
						break;
					case 'jours':
						$date_echeance = date('Y-m-d',strtotime($date_service." +".$value->obligation_detail->frequence." days"));
						break;
				}

			if(date('Y-m-d',strtotime($date_echeance))<=$now){
							
				$retard='Retard';
							
			}					
			elseif (date('Y-m-d',strtotime($date_echeance))<=date('Y-m-d',strtotime($now." +30 days"))) {
							
				$retard='30';
			}
			else{
				$retard='Ok';
			}
				
			
			$echeance[]= array('name'=>$value->obligation_detail->txt_1,'frequence'=>$value->obligation_detail->frequence.' '.$value->obligation_detail->frequence_type,'intervention'=>$intervention,'date_echeance'=>date('d-m-Y',strtotime($date_echeance)),'retard'=>$retard);
			
		}
		if(!isset($echeance)) $echeance[] = array();

		return view('ressourceshow')->with('ressource',$ressource)->with('domaine',Domaine::find($ressource->domaine_id))->with('categorie',Categorie::find($ressource->categorie_id))->with('obligations',$obligations)->with('echeance',$echeance);
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
		$now = date('Y-m-d'); 
		$ressource = Ressource::find($id);
		$obligations = RessourceObligation::where('ressource_id',$id)->with('obligation_detail')->get();
		$sites = Site::where('client_id',Auth::user()->id_client)->lists('name','id');
		$geds = Ged::where('ressource_id',$id)->get();
		
		foreach ($obligations as $value) 
		{
			$intervention = Intervention::where('ressource_id',$id)->where('obligation_detail_id',$value->obligation_detail->id)->orderBy('date_intervention','desc')->first();
			if(empty($intervention))
			{
				//echo 'pas intervention';
				$date_service = $ressource->date_service;
				$intervention = 'Aucune';
			}
			else
			{
				$date_service = $intervention->date_intervention;
				$intervention = date('d/m/Y',strtotime($date_service));

			}
			switch($value->obligation_detail->frequence_type)
				{
					case 'ans':
						$date_echeance = date('Y-m-d',strtotime($date_service." +".$value->obligation_detail->frequence." years"));
						break;
					case 'mois':
						$date_echeance = date('Y-m-d',strtotime($date_service." +".$value->obligation_detail->frequence." month"));
						break;
					case 'jours':
						$date_echeance = date('Y-m-d',strtotime($date_service." +".$value->obligation_detail->frequence." days"));
						break;
				}
				
			if(date('Y-m-d',strtotime($date_echeance))<=$now){
							
				$retard='Retard';
							
			}					
			elseif (date('Y-m-d',strtotime($date_echeance))<=date('Y-m-d',strtotime($now." +30 days"))) {
							
				$retard='30';
			}
			else{
				$retard='Ok';
			}
				$echeance[]= array('name'=>$value->obligation_detail->txt_1,'frequence'=>$value->obligation_detail->frequence.' '.$value->obligation_detail->frequence_type,'intervention'=>$intervention,'date_echeance'=>date('d-m-Y',strtotime($date_echeance)),'retard'=>$retard,'interventioncreer'=>$value->obligation_detail->id);
			
		}
		if(!isset($echeance)) $echeance[] = array();
		$interventions = Intervention::where('Ressource_id',$id)->with('obligation_detail')->orderby('date_intervention','DESC')->paginate(10);

		return view('ressourceedit')->with('ressource',$ressource)->with('domaine',Domaine::find($ressource->domaine_id))
		->with('categorie',Categorie::find($ressource->categorie_id))->with('obligations',$obligations)->with('echeance',$echeance)->with('sites',$sites)->with('interventions',$interventions)->with('geds',$geds);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(RessourceFormRequest $request)
	{
		//
		$ressource = Ressource::find($request->id);
		$ressource->name = $request->name;
		$ressource->site_id = $request->site_id;
		//$ressource->domaine_id = $request->domaine_id;
		//$ressource->categorie_id = $request->categorie_id;
		//$ressource->date_service = date("Y-m-d",strtotime($request->date_service));
		$ressource->date_service = implode('/', array_reverse( explode('/',$request->date_service) ) );
		$ressource->reference = $request->reference;
		$ressource->comment = $request->comment;
		if(Input::has('actif'))
		{
			$ressource->actif = 1;
		}
		else
		{
			$ressource->actif = 0;
		}
		$ressource->save();
		\Session::flash('message', 'Ressource mise à jour.');
		return redirect('/ressource/edit/'.$request->id);
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
		$ressource = Ressource::find($id);
		$domaine_id = $ressource->domaine_id;
		$ressource->delete();
		return redirect('/ressource/list/'.$domaine_id);
	}

}
