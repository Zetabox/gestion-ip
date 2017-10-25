<?php namespace App\Http\Controllers;
use Input;
use Validator;
use Redirect;
use Request;
use App\Lettre;
use App\Domaine;
use Session;
use DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Requests;
use App\Http\Requests\LettreTypeFormRequest;
use App\Http\Requests\SearchFormRequest;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;

class AdminLettreTypeController extends Controller {
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
		
		return view('admin.adminlettrelist');
	}

	/**
	 * Création d'une nouvelle lettre type.
	 *
	 * @return Response
	 */
	public function create($id)
	{

		$domaine=Domaine::where('id',$id)->first();
		
		return view('admin.adminlettrecreate')->with('domaine',$domaine);
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
		$lettres = Lettre::where('domaine_id',$id)->orderBy($sort, $sens)->paginate(10);
		return view('admin.adminlettrelist')->with('domaines',$domaines)->with('results',$lettres)->with('sort',$sort)->with('sens',$sens)->with('id',$id);
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(LettreTypeFormRequest $request)
	{
		//
		

		// getting all of the post data
		$file = array('image' => Input::file('image'));
		// setting up rules
		$rules = array('image' => 'required'); //mimes:jpeg,bmp,png and for max size max:10000
		// doing the validation, passing post data, rules and the messages
		$validator = Validator::make($file, $rules);
		if ($validator->fails()) {
		  // send back to the page with the input data and errors
		  return Redirect::to('admin/lettre/create/'.$request->domaine_id)->withInput()->withErrors($validator);
		}
		else {
		  // checking file is valid.
			if (Input::file('image')->isValid()) {
				$file = Request::file('image');

		    	$destinationPath = 'uploads'; // upload path
			    $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
			    $fileName = rand(11111,99999).'.'.$extension; // renameing image
			    //Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
			    Storage::disk('local')->put('lettres/'.$request->domaine_id.'/'.$fileName,  File::get($file));
			    $lettre = new Lettre();
			    $lettre->domaine_id = $request->domaine_id;
				$lettre->name = $request->name;
				$lettre->description = $request->description;
				$lettre->mime = Input::file('image')->getClientMimeType();
				$lettre->filename = $fileName;
				$lettre->original_filename = Input::file('image')->getClientOriginalName();
				$lettre->save();
			    Session::flash('success', 'Fichier téléchargé avec succès'); 
			    return Redirect::to('admin/lettre/create/'.$request->domaine_id);
			}
			else {
				// sending back with error message.
			    Session::flash('error', 'Fichier invalide');
			    return Redirect::to('admin/lettre/create/'.$request->domaine_id);
			}
		}



	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($filename)
	{
		$entry = Lettre::where('filename', '=', $filename)->firstOrFail();
		$file = Storage::disk('local')->get('lettres/'.$entry->domaine_id.'/'.$entry->filename);
		//echo Storage::exists('lettres/'.$entry->domaine_id.'/'.$entry->filename);die();
		//$file = storage_path().'/app/'.'lettres/'.$entry->domaine_id.'/'.$entry->filename;
		
		//return (new Response($file, 200))->header('Content-Type', $entry->mime);
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
		$lettre = Lettre::find($id);
		return view('admin.adminlettreedit')->with('lettre',$lettre);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		//

		$file = array('image' => Input::file('image'));

		//$rules = array('image' => 'required'); //mimes:jpeg,bmp,png and for max size max:10000

		
		
		  // checking file is valid.
			if (Input::file('image')) {
				$file = Input::file('image');
				$lettre = Lettre::find(Input::get('id'));
				if (Storage::exists('lettres/'.$lettre->domaine_id.'/'.$lettre->filename))
				{
    				Storage::delete('lettres/'.$lettre->domaine_id.'/'.$lettre->filename);
				}
				$destinationPath = 'uploads'; // upload path
			    $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
			    $fileName = rand(11111,99999).'.'.$extension; // renameing image
			    //Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
			    Storage::disk('local')->put('lettres/'.$lettre->domaine_id.'/'.$fileName,  File::get($file));


			    $lettre->name = Input::get('name');
			    $lettre->description = Input::get('description');
				$lettre->mime = Input::file('image')->getClientMimeType();
				$lettre->filename = $fileName;
				$lettre->original_filename = Input::file('image')->getClientOriginalName();
				$lettre->save();
			    Session::flash('success', 'Fichier téléchargé avec succès'); 
			    return Redirect::to('admin/lettre/edit/'.$lettre->id);
			}
			else {
				// sending back with error message.
			    $lettre = Lettre::find(Input::get('id'));
			    $lettre->name = Input::get('name');
			    $lettre->description = Input::get('description');
			    $lettre->save();
			    return Redirect::to('admin/lettre/edit/'.Input::get('id'));
			}
		

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
    	$domaines = Domaine::all();
    	$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$sens = (isset($_GET['sens'])) ? $_GET['sens'] : 'ASC';
		//$lettres = Lettre::where('domaine_id',$id)->orderBy($sort, $sens)->paginate(10);
		return view('admin.adminlettrelist')->with('domaines',$domaines)->with('results',$results)->with('sort',$sort)->with('sens',$sens)->with('id',$domaine_id);
    	//echo $request->query;die();

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
		$lettre = Lettre::find($id);
		$domaine_id = $lettre->domaine_id;
		$filename = $lettre->filename;
		$lettre->delete();
		if (Storage::exists('lettres/'.$domaine_id.'/'.$filename))
		{
    		Storage::delete('lettres/'.$domaine_id.'/'.$filename);
		}
		return redirect::to('/admin/lettre/list/'.$domaine_id);

	}

}
