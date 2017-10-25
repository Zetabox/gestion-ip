<?php namespace App\Http\Controllers;
use DB;
use Response;
use Hash;
use App\Client;
use App\Ressource;
use App\User;
use Input;
use App\Contrat;
use App\Site;
use App\Http\Requests;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\SearchFormRequest;
use App\Http\Requests\EditClientFormRequest;
use App\Http\Requests\FormuleClientFormRequest;
use App\Http\Requests\AddClientUserFormRequest;
use App\Http\Requests\AdminNewClientFormRequest;
use App\Http\Requests\AddContratForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Zizaco\Entrust\HasRole;
use Session;

class AdminClientController extends Controller {


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
	 * Affichage de la liste des clients.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
				//
		//$results = DB::table('users')->orderBy('name')->get();
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'societe';
		$sens = (isset($_GET['sens'])) ? $_GET['sens'] : 'ASC';
		//if(isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$results = Client::orderBy($sort, $sens)->paginate(10);
		if($sens=='ASC')
			$sens='DESC';
		else
			$sens='ASC';
		
		return view('admin.adminclient')->with('results',$results)->with('sort',$sort)->with('sens',$sens);
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return view('admin.adminnewclient');
	}

	/**
	 * Création d'un nouveau client.
	 *
	 * @return Response
	 */
	public function store(AdminNewClientFormRequest $request)
	{
		//
		$client = new Client;
		$client->societe = $request->societe;
		$client->name = $request->name;
		$client->firstname = $request->firstname;
		$client->email = $request->email;
		$client->telephone = $request->telephone;
		$client->remarque = $request->remarque;
		$client->begin_contract = date("Y-m-d");
		$client->end_contract = date("Y-m-d", strtotime('now +1 year'));
		$client->nb_obligations = 1;
		$client->nb_utilisateurs = 1;
		$client->nb_sites = 1;
		$client->save();

		$user = new User;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = Hash::make('apka');
		$user->id_client =  $client->id;
		$user->actif = 1;
		$user->save();
		// Ajout des droits de l'utilisateur
		$role=Role::Where('name','Admin')->get();
		$user->attachRoles($role);
		

		$site = new Site();
	    $site->name = "Etablissement principal";
	    $site->client_id = $client->id;
	    $site->user_id = $user->id;
	    $site->save();
	    $role = new Role();
	    $role->name = $site->id;
	    $role->display_name = 'site '.$request->name;
	    $role->description = "--autorisation sur le site--";
	    $role->save();
	    
	    
	    $permission = new Permission();
	    $permission->name = $site->id;
	    $permission->display_name = '--autorisation sur le site--';
	    $permission->save();
	    $role->attachPermission($permission);
	    $user->attachRole($role);

	    $roledomaines = Role::where('description','--autorisation sur le domaine--')->get();
	    $user->attachRoles($roledomaines);


		return redirect('admin/client/edit/'.$client->id)->with('onglet', 'profile');
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
	 * Edition d'un compte client.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// Choix de l'onglet qui a été ouvert
		$onglet = Session::get('onglet') ?: 'profile';
		// Information du client
		$results =Client::where('id',$id)->first();
		// Utilisateurs du client
		$utilisateurs =User::where('id_client',$id)->get();
		// Liste des sites du client
		$sites = Site::where('client_id',$id)->orderby('name')->with('ressource')->get();
		// Nombre d'utilisateur du client
		$nb_uti = User::Where('id_client',$id)->count();
		// Liste des Rôles pour les droits du client
		$rolesListe = Role::Where('description','!=','--autorisation sur le site--')->where('description','!=','--autorisation sur le domaine--')->get();
		/*$nb_obligations_clients=DB::table('ressource_obligation')->leftjoin('ressources', 'ressources.id','=','ressource_obligation.ressource_id')->whereIn('site_id',function($query) use ($id)
            {
                $query->select(DB::raw('id'))
                	->from('sites')
                	->whereRaw('sites.client_id='.$id);
            })->count();
        */
		// select distinct obligation_detail_id from tuto.ressource_obligation where ressource_id in (select id from tuto.ressources where site_id=4);
		$contrats = Contrat::where('client_id',$id)->orderby('end_contract','desc')->get();
		$nb_obligations_clients = 0;
		foreach ($sites as $site) {
			$site_id = $site->id;
			$nb_obligations_clients += DB::table('ressource_obligation')->distinct()->select('obligation_detail_id')->whereIn('ressource_id',function($query) use ($site_id)
		{
			$query->select(DB::raw('id'))
				->from('ressources')
				->whereRaw('ressources.site_id='.$site_id);
		})->count();
		}
		




		return view('admin.admineditclient')->with('results',$results)->with('id',$id)->with('utilisateurs',$utilisateurs)->with('nb_uti',$nb_uti)->with('onglet',$onglet)->with('roles',$rolesListe)->with('nb_obligations_clients',$nb_obligations_clients)
		->with('sites',$sites)->with('contrats',$contrats);
	}


	/**
	* Ajout d'un nouveau utilisateur pour le client
	*
	* @param name, email, password, id_client
	* @return Id
	*/
	public function addUser(AddClientUserFormRequest $request)
	{
		
		// Création de l'utilisateur
		//$user = User::create(['name' => $request->name,'email' => $request->email, 'password' => Hash::make($request->password), 'id_client' => $request->id_client, 'actif' => 0]);
		$user = new User;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->id_client =  $request->id_client;
		$user->actif = 1;
		$user->save();
		// Ajout des droits de l'utilisateur
		foreach($request->roles as $role)
		{
			$user->roles()->attach($role);
		}
		$roledomaines = Role::where('description','--autorisation sur le domaine--')->get();
	    $user->attachRoles($roledomaines);
		return redirect('admin/client/edit/'.$request->id_client)->with('onglet', 'compte');
	}

	/**
	 * Search Client.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function search(SearchFormRequest $request)
	{
		//
		//$lettres = Lettre::where('name','LIKE %'.$request.'%');

		$q = Input::get('query');
		

  		if($q && $q != ''){
    		$searchTerms = explode(' ', $q);
    		$query = DB::table('clients');  

    		if(!empty($searchTerms)){

      			foreach($searchTerms as $term) {
        			$query->where('societe', 'LIKE', '%'. $term .'%')->orWhere('name', 'LIKE', '%'. $term .'%');
      			}
    		}
    		$results = $query->paginate(10);

    		//dd($results); 
   		}
    	
    	$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$sens = (isset($_GET['sens'])) ? $_GET['sens'] : 'ASC';
		return view('admin.adminclient')->with('results',$results)->with('sort',$sort)->with('sens',$sens);
	}

	/**
	* Ajout d'un nouveau utilisateur pour le client
	*
	* @param name, email, password, id_client
	* @return Id
	*/
	public function editUser($id)
	{
		
		// Création de l'utilisateur
		$user = User::find($id);
		// Ajout des droits de l'utilisateur
		$userRoles = User::find($id)->roles;
		foreach ($userRoles as $userRole) {
			$userRoleListe[]=$userRole->name;
		}
		if(!isset($userRoleListe)) 
			$userRoleListe[] = null;
		$rolesListe = Role::Where('description','!=','--autorisation sur le site--')->where('description','!=','--autorisation sur le domaine--')->get();
		$suppUser = Site::where('user_id',$id)->exists();

		return view('admin.admincompteedit')->with('user', $user)->with('roles',$rolesListe)->with('userroles',$userRoleListe)->with('suppUser',$suppUser);
	}
	/**
	* Ajout d'un nouveau utilisateur pour le client
	*
	* @param name, email, password, id_client
	* @return Id
	*/
	public function updateUser(UserFormRequest $request)
	{
		
		// Mise à jour de l'utilisateur
		$user = User::find($request->id);
		$user->name = $request->name;
		if(Input::has('password'))
			$user->password = Hash::make($request->password);
		$user->email = $request->email;

		
		if(Input::has('actif'))
		{
			$user->actif = 1;
		}
		else
		{
			$user->actif = 0;
		}
		//dd($request);
		$user->save();
		$roles = User::find($request->id)->roles;
		$user->detachRoles($roles);
		$user->attachRoles($request->roles);
		$roledomaines = Role::where('description','--autorisation sur le domaine--')->get();
	    $user->attachRoles($roledomaines);
	    $sitelist = Site::where('client_id',$user->id_client)->lists('id');
	  	
	    $sites = Role::whereIn('name',$sitelist)->get();

	    $user->attachRoles($sites);
		return redirect('admin/client/edit/'.$user->id_client)->with('onglet', 'compte');
	}
	/**
	 * Mise à jour des informations du client
	 *
	 * @param  name, firstname,email, telephone,remarque,  $id du client
	 * @return Response
	 */
	public function update(EditClientFormRequest $request)
	{
		$client = Client::find($request->id);
		$client->name = $request->name;
		$client->firstname = $request->firstname;
		$client->email = $request->email;
		$client->telephone = $request->telephone;
		$client->remarque = $request->remarque;
		$client->save();
		return redirect('admin/client/edit/'.$request->id)->with('onglet', 'profile');
		
	}

	/**
	 * Mise à jour des informations du client
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateFormule(FormuleClientFormRequest $request)
	{
		$client = Client::find($request->id);
		$client->nb_obligations = $request->nb_obligations;
		$client->nb_sites = $request->nb_sites;
		$client->nb_utilisateurs = $request->nb_utilisateurs;
		$client->save();
	
		return redirect('admin/client/edit/'.$request->id)->with('onglet', 'formule');
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
		//$sites = Site::where('client_id',$id)->delete();
		$site = Site::Where('client_id',$id);
		$site->delete();
		$users = User::where('id_client',$id)->delete();
		$client = Client::find($id);
		$client->delete();
		return redirect('/admin/client/');
	}
	/**
	* Ajout d'un contrat
	*
	* @param request Form
	* @return Contrats
	*/
	public function addContrat(AddContratForm $request)
	{
		$tmp_begin_contract= Input::get('begin_contract');
      	@list($jour,$mois,$annee)=explode('/',$tmp_begin_contract);
   		$begin_contract =  @date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
   		$tmp_end_contract= Input::get('end_contract');
      	@list($jour,$mois,$annee)=explode('/',$tmp_end_contract);
   		$end_contract =  @date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
		$contrat = new Contrat;
		$contrat->client_id = $request->client_id;
		$contrat->begin_contract = $begin_contract;
		$contrat->end_contract = $end_contract;
		$contrat->nb_obligations = $request->nb_obligations;
		$contrat->nb_sites = $request->nb_sites;
		$contrat->nb_utilisateurs = $request->nb_utilisateurs;
		$contrat->save();
		return redirect('/admin/client/edit/'.$request->client_id)->with('onglet','contrats');
	}
	/**
	 * Supression d'un utilisateur
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroyUser($id)
	{
		//
		$user = User::find($id);
		$client_id = $user->id_client;
		$user->delete();
		return redirect('admin/client/edit/'.$client_id)->with('onglet', 'compte');
	}

}
