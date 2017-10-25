<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Domaine;
use Auth;
use Input;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SearchFormRequest;
use App\Lettre;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class LettreTypeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function search(SearchFormRequest $request)
	{
		//
		//$lettres = Lettre::where('name','LIKE %'.$request.'%');

		$q = Input::get('query');
		$domaine_id = Input::get('domaine_id');

  		if($q && $q != ''){
    		$searchTerms = explode(' ', $q);
    		$query = DB::table('lettres');  

    		if(!empty($searchTerms)){

      			foreach($searchTerms as $term) {
        			$query->where('description', 'LIKE', '%'. $term .'%')->orWhere('name', 'LIKE', '%'. $term .'%')->where('domaine_id',$domaine_id);
      			}
    		}
    		$results = $query->paginate(10);

    		//dd($results); 
   		}
    	$roles = Auth::user()->roles()->lists('name');
		$domaines = Domaine::wherein('name',$roles)->get();
		
		
    	$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$sens = (isset($_GET['sens'])) ? $_GET['sens'] : 'ASC';
		//$lettres = Lettre::where('domaine_id',$id)->orderBy($sort, $sens)->paginate(10);
		return view('lettretype')->with('domaines',$domaines)->with('results',$results)->with('sort',$sort)->with('sens',$sens)->with('id',$domaine_id);
    	//echo $request->query;die();

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
	public function liste($id)
	{
		//
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$sens = (isset($_GET['sens'])) ? $_GET['sens'] : 'ASC';
		$roles = Auth::user()->roles()->lists('name');
		$domaines = Domaine::wherein('name',$roles)->get();
		
		if($id==0) $id=$domaines->first()->id;
		$lettres = Lettre::where('domaine_id',$id)->orderBy($sort, $sens)->paginate(10);
		return view('lettretype')->with('domaines',$domaines)->with('results',$lettres)->with('sort',$sort)->with('sens',$sens)->with('id',$id);
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($filename)
	{
		//
		$entry = Lettre::where('filename', '=', $filename)->firstOrFail();
		$file = Storage::disk('local')->get('lettres/'.$entry->domaine_id.'/'.$entry->filename);		
		//return (new Response($file, 200))->header('Content-Type', $entry->mime);
		//return (new Response($file, 200))->header(array('Content-Type' => $entry->mime,'Content-Disposition' => 'attachment; filename="pp.pdf"'));
		//return Response::download($file,$entry->original_filename,['Content-Type' => $entry->mime,'Content-Disposition' => 'attachment; filename="pp.pdf"']);
		$headers = array(
    		'Content-type'          => $entry->mime,
    		'Content-Disposition'   => 'attachment; filename="' . $entry->original_filename . '"'
		);
		return (new Response( $file, 200, $headers));
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
