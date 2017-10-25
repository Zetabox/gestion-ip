<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Site;
use App\User;
use App\Client;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\SiteFormRequest;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Zizaco\Entrust\HasRole;

class SiteController extends Controller {
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
		$sites = Site::where('client_id','=',Auth::user()->id_client)->with('responsable')->get();
		return view('site')->with('sites',$sites);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		$nb_site = Site::where('client_id',Auth::user()->id_client)->count();
		$nb_max_site = Client::where('id',Auth::user()->id_client)->lists('nb_sites');

		if(intval($nb_site) >=  $nb_max_site[0])
			return redirect('/site/list')->withInput()->with('error','Nombre maximum de sites');
		$users = User::where('id_client','=',Auth::user()->id_client)->lists('name','id');

		return view('sitecreate')->with('users',$users);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SiteFormRequest $request)
	{
		//
	    $site = new Site();
	    $site->name = $request->name;
	    $site->address = $request->address;
	    $site->city = $request->city;
	    $site->zip = $request->zip;
	    $site->client_id = Auth::user()->id_client;
	    $site->user_id = $request->responsable;
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
	    $user = User::find(Auth::id());
	    $user->attachRole($role);
	    return redirect('/site/list');
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
		$results =Site::where('id',$id)->first();
		$users = User::where('id_client','=',Auth::user()->id_client)->lists('name','id');
		return view('siteedit')->with('results' , $results)->with('users',$users);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(SiteFormRequest $request)
	{
		//
		//echo $request->name;die();
		$site = Site::find($request->id);
		$site->name = $request->name;
	    $site->address = $request->address;
	    $site->city = $request->city;
	    $site->zip = $request->zip;
	    $site->client_id = Auth::user()->id_client;
	    $site->user_id = $request->responsable;
	    $site->save();
	    return redirect('site/list');
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
		
		$site = Site::find($id);
		$role = Role::where('name',$id);
		
		$role->delete();
		$permission = Permission::where('name',$id);
		$permission->delete();
		$site->delete();
		return redirect('/site/list');
	}

}
