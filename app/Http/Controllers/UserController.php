<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Input;
use App\User;
use Entrust;
use App\Site;
use App\SiteUser;
use App\Domaine;
use App\Client;
use App\Http\Requests\AddUserFormRequest;
use App\Http\Requests\UserFormRequest;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Zizaco\Entrust\HasRole;

use Illuminate\Http\Request;

class UserController extends Controller {

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
		$users= User::where('id_client',Auth::user()->id_client)->get();
		return view('userslist')->with('users',$users);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$nb_user = User::where('id_client',Auth::user()->id_client)->count();
		$nb_max_user = Client::where('id',Auth::user()->id_client)->lists('nb_utilisateurs');
		//echo $nb_max_user[0];die();
		if(intval($nb_user) >=  $nb_max_user[0])
			return redirect('/utilisateur/list')->withInput()->with('error','Nombre maximum d\'utilisateurs');

		$rolesListe = Role::where('name','<>','SuperAdmin')->where('description','!=','--autorisation sur le site--')->where('description','!=','--autorisation sur le domaine--')->get();
		$domainesListe = Role::Where('description','--autorisation sur le domaine--')->get();
		$sites = Site::where('client_id',Auth::user()->id_client)->lists('name','id');
		$sitesListe = Site::where('client_id',Auth::user()->id_client)->get();
		return view('usercreate')->with('roles',$rolesListe)->with('sites',$sites)->with('sitesListe',$sitesListe)->with('domainesListe',$domainesListe);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddUserFormRequest $request)
	{
		//
		$user = User::create(['name' => $request->name,'email' => $request->email, 'password' => Hash::make($request->password), 'id_client' => Auth::user()->id_client, 'actif' => 1]);
		//$adminRole = DB::table('roles')->where('name', '=', 'Admin')->pluck('id');
		
		if(!is_null($request->roles))
		{
			foreach($request->roles as $role)
			{
				$user->roles()->attach($role);
			}
		}
		if(!is_null($request->sites))
		{
			foreach($request->sites as $site)
			{
				$rolesite = Role::where('name',$site)->get();
				$user->attachRoles($rolesite);
			}
		}
		if(!is_null($request->domaines))
		{
		foreach($request->domaines as $domaine)
			{
				$roledomaine = Role::where('name',$domaine)->get();
				$user->attachRoles($roledomaine);
			}
		}
		return redirect('/utilisateur/list');
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
		$supp=1;
		
		if(Entrust::hasRole('Admin'))
		{
			$user = User::find($id);
			if(empty($user)) return redirect('utilisateur/list');
			if($user->id_client!=Auth::user()->id_client)
			{
				return redirect('utilisateur/list');
			}
		}
		else return redirect('utilisateur/list');
		
		$userRoles = User::find($id)->roles;
		foreach ($userRoles as $userRole) {
			$userRoleListe[]=$userRole->name;
		}
		if(!isset($userRoleListe)) 
			$userRoleListe[] = null;

		$sites = Site::where('client_id',Auth::user()->id_client)->lists('name','id');

		$SiteUser = SiteUser::where('user_id',$id)->first();
		if(!isset($SiteUser))
			$Site_User=0;
		else
			$Site_User=$SiteUser->site_id;
		$rolesListe = Role::where('name','<>','SuperAdmin')->where('description','!=','--autorisation sur le site--')->where('description','!=','--autorisation sur le domaine--')->get();
		$sitesListe = Site::where('client_id',Auth::user()->id_client)->get();
		foreach($sitesListe as $userSite)
		{
			if($user->can($userSite->id)) $userSiteListe[] = $userSite->name;
		}
		if(!isset($userSiteListe)) 
			$userSiteListe[] = null;
		$domainesListe = Role::where('description','--autorisation sur le domaine--')->get();
		foreach ($domainesListe as $userDomaine) {
			if($user->can($userDomaine->name)) $userDomaineListe[] = $userDomaine->name;
		}
		if(!isset($userDomaineListe)) 
			$userDomaineListe[] = null;
		if($user->hasRole('Admin')) $supp=0;
		return view('useredit')->with('user',$user)->with('roles',$rolesListe)->with('userroles',$userRoleListe)->with('sites',$sites)->with('SiteUser',$Site_User)->with('sitesListe',$sitesListe)->with('usersites',$userSiteListe)
		->with('userdomaines',$userDomaineListe)->with('domainesListe',$domainesListe)->with('supp',$supp);



	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UserFormRequest $request)
	{
		//
		if(Entrust::hasRole('Admin'))
		{
			$user = User::find($request->id);
			if(empty($user)) return redirect('utilisateur/list');
			if($user->id_client!=Auth::user()->id_client)
			{
				return redirect('utilisateur/list');
			}
		}
		else return redirect('utilisateur/list');
		
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
		$user->save();
		$SiteUser = SiteUser::where('user_id',$request->id)->first();
		if(isset($SiteUser))
		{
			$SiteUser->site_id = $request->site_id;
			$SiteUser->save();
		}
		else
		{
			$SiteUser = new SiteUser;
			$SiteUser->user_id = $request->id;
			$SiteUser->site_id = $request->site_id;
			$SiteUser->save();
		}

		$roles = User::find($request->id)->roles;
		$user->detachRoles($roles);
		if(!is_null($request->roles))
			$user->attachRoles($request->roles);
		if(!is_null($request->sites))
		{
			foreach ($request->sites as $sites) {
				$rolesite = Role::where('name',$sites)->get();
				//dd($rolesite);
				$user->attachRoles($rolesite);
			}
		}
		if(!is_null($request->domaines))
		{
			foreach ($request->domaines as $domaine) {
				$rolesdomaine = Role::where('name',$domaine)->get();
				//dd($rolesite);
				$user->attachRoles($rolesdomaine);
			}
		}
		return redirect('utilisateur/list');
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
		if(Entrust::hasRole('Admin'))
		{
			$user = User::find($id);
			if($user->id_client==Auth::user()->id_client)
			{
				$user->delete();
			
			}
		}
		return redirect('utilisateur/list'); 
	}

}
