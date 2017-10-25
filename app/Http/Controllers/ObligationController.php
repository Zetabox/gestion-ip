<?php namespace App\Http\Controllers;
use DB;
use Response;
use App\Obligation;
use App\ObligationDetail;
use App\User;
use Auth;
use App\Domaine;
use Input;
use App\RessourceObligation;
use App\Categorie;
use App\Http\Requests;
use App\Http\Requests\SearchFormRequest;
use App\Http\Requests\ObligationFormRequest;
use App\Http\Requests\EditObligationFormRequest;
use App\Http\Requests\AddDetailFormRequest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ObligationController extends Controller {

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
		//$results = DB::table('users')->orderBy('name')->get();
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$sens = (isset($_GET['sens'])) ? $_GET['sens'] : 'ASC';
		$onglet = (isset($_GET['onglet'])) ? $_GET['onglet'] : 'batiment';
		//echo $sort;
		//if(isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$batiments = Obligation::where('domaine_id',1)->where('client_id',0)->orwhere('client_id',Auth::user()->id_client)->orderBy($sort, $sens)->paginate(10);
		$vehicules = Obligation::where('domaine_id',2)->where('client_id',0)->orwhere('client_id',Auth::user()->id_client)->orderBy($sort, $sens)->paginate(10);
		$materiels = Obligation::where('domaine_id',3)->where('client_id',0)->orwhere('client_id',Auth::user()->id_client)->orderBy($sort, $sens)->paginate(10);
		$rhs = Obligation::where('domaine_id',4)->where('client_id',0)->orwhere('client_id',Auth::user()->id_client)->orderBy($sort, $sens)->paginate(10);
		$fiscals = Obligation::where('domaine_id',5)->where('client_id',0)->orwhere('client_id',Auth::user()->id_client)->orderBy($sort, $sens)->paginate(10);
		
		return view('obligation')->with('batiments',$batiments)->with('vehicules',$vehicules)->with('materiels',$materiels)->with('rhs',$rhs)->with('fiscals',$fiscals)->with('sort',$sort)->with('sens',$sens)->with('onglet',$onglet);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$domaine=Domaine::where('id',$id)->first();
		$categories=DB::table('categories')->where('domaine_id',$id)->get();
		$categories = Categorie::where('domaine_id',$id)->lists('name','id');
		return view('obligationcreate')->with('domaine',$domaine)->with('categories',$categories);
	}

	/**
	 * PostCreate.
	 *
	 * @return Response
	 */

	public function postcreate(ObligationFormRequest $request)
	{
		//
		$id=DB::table('obligations')->insertGetId(array('name'=>$request->input('name'),'domaine_id'=>$request->input('domaine_id'),'categorie_id'=>$request->input('categorie'),'description'=>$request->input('description'),'txtref'=>$request->input('txtref'),
			'dma'=>$request->input('dma'),'law'=>$request->input('txtloi'),'comment'=>$request->input('comment'),'actif'=>0,'source'=>$request->input('source'),'client_id'=>Auth::user()->id_client));
		//return Response::make($id);
		return redirect('/obligation/list/'.$request->input('domaine_id'));
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

	public function adddetail(AddDetailFormRequest $request)
	{
		// Function d'ajout d'un détail d'obligation
		$id=DB::table('obligations_details')->insertGetId(array('obligation_id'=>$request->input('obligation_id'),'frequence'=>$request->input('frequence'),'frequence_type'=>$request->input('frequence_type'),'txt_1'=>$request->input('txt_1'),'txt_2'=>$request->input('txt_2')));
		
		
		return redirect('/obligation/edit/'.$request->input('obligation_id'));



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
		$client_id = Auth::user()->id_client;
		//$lettres = Lettre::where('domaine_id',$id)->orderBy($sort, $sens)->paginate(10);
		return view('obligationlist')->with('domaines',$domaines)->with('results',$results)->with('sort',$sort)->with('sens',$sens)->with('id',$domaine_id)->with('client_id',$client_id);


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
		return view('obligationshow')->with('results',$results)->with('id',$id)->with('domaines',$domaines)->with('categories',$categories)->with('obligationdetails',$obligationdetails);
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

		$results =Obligation::where('id',$id)->where('client_id',Auth::user()->id_client)->first();
		if(!$results) return redirect('/obligation/list/1');

		$domaine=Domaine::where('id',$results->domaine_id)->first();
		$categories=DB::table('categories')->where('domaine_id',$results->domaine_id)->lists('name','id');
		$obligationdetails=DB::table('obligations_details')->where('obligation_id',$id)->get();
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

		return view('obligationedit')->with('results',$results)->with('id',$id)->with('domaine',$domaine)->with('categories',$categories)->with('obligationdetails',$obligationdetails)->with('detailSupp',$detailSupp)->with('suppObligation',$suppObligation);
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

		$roles = Auth::user()->roles()->lists('name');
		$domaines = Domaine::wherein('name',$roles)->get();
		
		if($id==0) $id=$domaines->first()->id;
		
		$client_id = Auth::user()->id_client;
		$obligations = Obligation::where('domaine_id',$id)->orderBy($sort, $sens)->paginate(10);
		return view('obligationlist')->with('domaines',$domaines)->with('results',$obligations)->with('sort',$sort)->with('sens',$sens)->with('id',$id)->with('client_id',$client_id);

	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(EditObligationFormRequest $request)
	{
		//
		$obligation = Obligation::find($request->id);
		$obligation->name = $request->name;
		//$obligation->domaine_id = $request->domaine;
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
		return redirect('/obligation/edit/'.$request->id);
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
		$domaine_id = $obligation->domaine_id;
		$obligation->delete();
		return redirect('/obligation/list/'.$domaine_id);
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
		return redirect('/obligation/edit/'.$obligation_id);
	}

}
