<?php 	namespace App\Http\Controllers;
use DB;

use App\User;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Zizaco\Entrust\HasRole;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class start extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		 
		$superadmin = new Role();
	    $superadmin->name = 'SuperAdmin';
	    $superadmin->display_name ='apka';
	    $superadmin->description ='utilisateur apka';
	    $superadmin->save();
	  
	 	$admin = new Role();
	    $admin->name = 'Admin';
	    $admin->display_name ='client';
	    $admin->description ='utilisateur admin client';
	    $admin->save();

	    $user = new Role();
	    $user->name = 'User';
	    $user->display_name = 'Utilisateur client';
	    $user->description = 'Utilisateur client';
	    $user->save();
	  
	    $read = new Permission();
	    $read->name = 'Oblicagtion';
	    $read->display_name = 'lire les obligations';
	    $read->save();
	  
	    $edit = new Permission();
	    $edit->name = 'Obligation_edit';
	    $edit->display_name = 'Editer et créer des obligations';
	    $edit->save();

	    $user->attachPermission($read);
	    $admin->attachPermission($read);
	    $admin->attachPermission($edit);
	    $superadmin->attachPermission($read);
	    $superadmin->attachPermission($edit);
	 
	    $adminRole = DB::table('roles')->where('name', '=', 'Admin')->pluck('id');
	    $superadminRole = DB::table('roles')->where('name', '=', 'SuperAdmin')->pluck('id');
	    $userRole = DB::table('roles')->where('name', '=', 'User')->pluck('id');
	    // print_r($userRole);
	    // die();
	  
	    $user1 = User::where('name','=','eredia')->first();
	    //var_dump($superadminRole);
	    
	    //$user1->attachRole($superadminRole);
	    
	    $user1->roles()->attach($superadminRole);
	    $user2 = User::where('name','=','olive')->first();
	    $user2->roles()->attach($adminRole);
	    $user3 = User::where('name','=','Laurent')->first();
	    $user3->roles()->attach($userRole);
	    return 'Woohoo!';

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
