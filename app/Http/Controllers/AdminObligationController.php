<?php namespace App\Http\Controllers;
use DB;
use Response;
use App\Obligation;
use App\Domaine;
use App\Categorie;
use App\User;
use App\RessourceObligation;
use App\ObligationDetail;
use Input;
use Auth;
use App\Http\Requests;
use App\Http\Requests\SearchFormRequest;
use App\Http\Requests\AdminObligationEditFormRequest;
use App\Http\Requests\AdminAddDetailFormRequest;
use App\Http\Requests\AdminObligationFormRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AdminObligationController extends Controller {
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
		//$results = DB::table('users')->orderBy('name')->get();
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$sens = (isset($_GET['sens'])) ? $_GET['sens'] : 'ASC';

		//echo $sort;
		//if(isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$batiments = Obligation::where('domaine_id',1)->where('client_id',0)->orwhere('client_id',Auth::user()->id_client)->orderBy($sort, $sens)->paginate(2);
		$vehicules = Obligation::where('domaine_id',2)->where('client_id',0)->orwhere('client_id',Auth::user()->id_client)->orderBy($sort, $sens)->paginate(2);
		$materiels = Obligation::where('domaine_id',3)->where('client_id',0)->orwhere('client_id',Auth::user()->id_client)->orderBy($sort, $sens)->paginate(2);
		$rhs = Obligation::where('domaine_id',4)->where('client_id',0)->orwhere('client_id',Auth::user()->id_client)->orderBy($sort, $sens)->paginate(2);
		$fiscals = Obligation::where('domaine_id',5)->where('client_id',0)->orwhere('client_id',Auth::user()->id_client)->orderBy($sort, $sens)->paginate(2);
		
		return view('obligation')->with('batiments',$batiments)->with('vehicules',$vehicules)->with('materiels',$materiels)->with('rhs',$rhs)->with('fiscals',$fiscals)->with('sort',$sort)->with('sens',$sens);
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
		$results =Obligation::where('id',$id)->first();

		$domaines=DB::table('domaines')->get();
		$categories=DB::table('categories')->where('domaine_id',$results->domaine_id)->get();
		$obligationdetails=DB::table('obligations_details')->where('obligation_id',$id)->get();
		//var_dump($results);die();
		return view('admin.adminobligationshow')->with('results',$results)->with('id',$id)->with('domaines',$domaines)->with('categories',$categories)->with('obligationdetails',$obligationdetails);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		//
		
		//$id_user = \Auth::user()->id_client;
		$domaine=Domaine::where('id',$id)->first();
		$categories = Categorie::where('domaine_id',$id)->lists('name','id');
		return view('admin.adminobligationcreate')->with('domaine',$domaine)->with('categories',$categories);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AdminObligationFormRequest $request)
	{
		//
		$id=DB::table('obligations')->insertGetId(array('name'=>$request->input('name'),'domaine_id'=>$request->input('domaine_id'),'categorie_id'=>$request->input('categorie'),'description'=>$request->input('description'),'txtref'=>$request->input('txtref'),
			'dma'=>$request->input('dma'),'law'=>$request->input('txtloi'),'comment'=>$request->input('comment'),'actif'=>0,'source'=>$request->input('source'),'client_id'=>0));
		//return Response::make($id);
		return redirect('/admin/obligation/edit/'.$id);
	}
	
	public function adddetail(AdminAddDetailFormRequest $request)
	{
		// Function d'ajout d'un détail d'obligation
		$id=DB::table('obligations_details')->insertGetId(array('obligation_id'=>$request->input('obligation_id'),'frequence'=>$request->input('frequence'),'frequence_type'=>$request->input('frequence_type'),'txt_1'=>$request->input('txt_1'),'txt_2'=>$request->input('txt_2')));
		
		
		return redirect('/admin/obligation/edit/'.$request->obligation_id);



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
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$sens = (isset($_GET['sens'])) ? $_GET['sens'] : 'ASC';
		$domaines = Domaine::all();
		$obligations = Obligation::where('domaine_id',$id)->orderBy($sort, $sens)->paginate(10);
		return view('admin.adminobligationlist')->with('domaines',$domaines)->with('results',$obligations)->with('sort',$sort)->with('sens',$sens)->with('id',$id);

	}
	/**
	 * Search
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function search(SearchFormRequest $request)
	{
		//
		//$lettres = Lettre::where('name','LIKE %'.$request.'%');

		$q = Input::get('query');
		$domaine_id = $request->domaine_id;

  		if($q && $q != ''){
    		$searchTerms = explode(' ', $q);
    		$query = DB::table('obligations');

    		if(!empty($searchTerms)){

      			foreach($searchTerms as $term) {
        			$query->where('name', 'LIKE', '%'. $term .'%')->where('domaine_id',$domaine_id);
      			}
    		}
    		$results = $query->paginate(10);
   		}
    	$domaines = Domaine::all();
    	$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$sens = (isset($_GET['sens'])) ? $_GET['sens'] : 'ASC';
		//$lettres = Lettre::where('domaine_id',$id)->orderBy($sort, $sens)->paginate(10);
		return view('admin.adminobligationlist')->with('domaines',$domaines)->with('results',$results)->with('sort',$sort)->with('sens',$sens)->with('id',$domaine_id);


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
		$detailSupp[] = null;
		$results =Obligation::where('id',$id)->first();
		$domaine=Domaine::where('id',$results->domaine_id)->first();
		$categories=DB::table('categories')->where('domaine_id',$results->domaine_id)->lists('name','id');
		$obligationdetails=DB::table('obligations_details')->where('obligation_id',$id)->get();
		// Vérification si l'obligation est utilisée par une ressource.
		foreach($obligationdetails as $obligation_detail)
		{
			$rere = RessourceObligation::where('obligation_detail_id',$obligation_detail->id)->exists();


			if($rere!=1)
			{
				$detailSupp[$obligation_detail->id] = 'ok';
			}
			else{
				$detailSupp[$obligation_detail->id] = 'nok';
			}
		}
		if(!array_search('nok',$detailSupp))
			$suppObligation='ok';
		else
			$suppObligation='nok';

		return view('admin.adminobligationedit')->with('results',$results)->with('id',$id)->with('domaine',$domaine)->with('categories',$categories)->with('obligationdetails',$obligationdetails)->with('detailSupp',$detailSupp)->with('suppObligation',$suppObligation);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(AdminObligationEditFormRequest $request)
	{
		//
		$obligation = Obligation::find($request->id);
		$obligation->name = $request->name;
		$obligation->domaine_id = $request->domaine_id;
		$obligation->categorie_id = $request->categorie;
		$obligation->source = $request->source;
		$obligation->txtref = $request->txtref;
		$obligation->dma = $request->dma;
		$obligation->law = $request->law;
		$obligation->comment = $request->comment;
		$obligation->description = $request->description;
		if ($request->actif) 
			$obligation->actif = '1';
		else
			$obligation->actif = '0';
		$obligation->save();
	
		$results =Obligation::where('id',$request->id)->first();
		$domaines=DB::table('domaines')->get();
		$categories=DB::table('categories')->where('domaine_id',$results->domaine_id)->get();
		//var_dump($results);die();
		//return view('obligationedit')->with('results',$results)->with('domaines',$domaines)->with('categories',$categories);
		return redirect('/admin/obligation/edit/'.$request->id);
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
		$obligation = Obligation::find($id);
		$obligation->delete();
		return redirect('/admin/obligation/list/1');
	}
		/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroydetail($id)
	{
		//
		$obligationdetail = ObligationDetail::find($id);
		$obligation_id = $obligationdetail->obligation_id;
		$obligationdetail->delete();
		return redirect('/admin/obligation/edit/'.$obligation_id);
	}

}
