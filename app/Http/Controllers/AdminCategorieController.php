<?php namespace App\Http\Controllers;


use DB;
use Response;
use Hash;
use App\Domaine;
use App\Ressource;
use App\Categorie;
use App\User;
use App\Http\Requests;


use App\Http\Requests\CategorieRequestForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Zizaco\Entrust\HasRole;
use Session;

class AdminCategorieController extends Controller {
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
		$categories = Categorie::where('domaine_id', 1)->paginate(10);
		$domaines = Domaine::all();
		return view('admin.admincategorielist')->with('categories',$categories)->with('domaines',$domaines)->with('id',1);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function liste($id)
	{
		//
		$categories = Categorie::where('domaine_id', $id)->paginate(10);
		$domaines = Domaine::all();
		return view('admin.admincategorielist')->with('categories',$categories)->with('domaines',$domaines)->with('id',$id);
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
	public function store(CategorieRequestForm $request)
	{
		//
		$categorie = new Categorie;
		$categorie->name = $request->name;
		$categorie->domaine_id = $request->id;
		$categorie->save();
		return redirect('/admin/categorie/list/'.$request->id);
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
		$categorie = Categorie::where('id',$id)->first();
		$suppCategorie = Ressource::where('categorie_id',$id)->exists();
		return view('admin.admincategorieupdate')->with('categorie',$categorie)->with('suppCategorie',$suppCategorie);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CategorieRequestForm $request)
	{
		//
		$categorie = Categorie::find($request->id);
		$categorie->name = $request->name;
		$categorie->save();
		return redirect('admin/categorie/list/'.$categorie->domaine_id);
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
		$categorie = Categorie::find($id);
		$domaine_id = $categorie->domaine_id;
		$categorie->delete();
		return redirect('/admin/categorie/list/'.$domaine_id);
	}

}
