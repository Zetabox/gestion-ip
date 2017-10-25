<?php 	namespace App\Http\Controllers;
use DB;

use App\User;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Zizaco\Entrust\HasRole;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StartRules extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		 
	  	
	 	$Admin = new Role();
	    $Admin->name = 'Admin';
	    $Admin->display_name ='Administrateur';
	    $Admin->description ='utilisateur pouvant gérer le logiciel';
	    $Admin->save();

	    $mandataire = new Role();
	    $mandataire->name = 'Mandataire';
	    $mandataire->display_name ='Utilisateur du logiciel';
	    $mandataire->description ='utilisateur pouvant gérer les marques';
	    $mandataire->save();

	    $compte = new Permission();
	    $compte->name = 'Créer les comptes';
	    $compte->display_name = 'Création des comptes';
	    $compte->save();
	  
	    $marque = new Permission();
	    $marque->name = 'Créer des marques';
	    $marque->display_name = 'Editer et créer les marques';
	    $marque->save();

		$Admin->attachPermission($compte);
		$Admin->attachPermission($marque);
		$mandataire->attachPermission($marque);


	    

	    	   
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
