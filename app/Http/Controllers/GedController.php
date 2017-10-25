<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Input;
use Validator;
use Redirect;
use Request;
use Session;
use App\Ged;
use DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Http\Requests\GedRequestForm;

//use Illuminate\Http\Request;

class GedController extends Controller {

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
	public function create($ressource_id)
	{
		//

		return view('ged')->with('ressource_id',$ressource_id);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(GedRequestForm $request)
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
		  return Redirect::to('/ged/create/'.$request->ressource_id)->withInput()->withErrors($validator);
		}
		else {
		  // checking file is valid.
			if (Input::file('image')->isValid()) {
				$file = Request::file('image');

		    	$destinationPath = 'uploads'; // upload path
			    $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
			    $fileName = rand(11111,99999).'.'.$extension; // renameing image
			    //Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
			    Storage::disk('local')->put('geds/'.Auth::user()->id_client.'/'.$request->ressource_id.'/'.$fileName,  File::get($file));
			    $Ged = new Ged();
			    $Ged->ressource_id = $request->ressource_id;
				$Ged->name = $request->name;
				$Ged->description = $request->description;
				$Ged->mime = Input::file('image')->getClientMimeType();
				$Ged->filename = $fileName;
				$Ged->original_filename = Input::file('image')->getClientOriginalName();
				$Ged->save();
			    Session::flash('success', 'Fichier téléchargé avec succès'); 
			    return Redirect::to('/ged/create/'.$request->ressource_id);
			}
			else {
				// sending back with error message.
			    Session::flash('error', 'Fichier invalide');
			    return Redirect::to('/ged/create/'.$request->ressource_id);
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
		//
		$entry = Ged::where('filename', '=', $filename)->firstOrFail();
		$file = Storage::disk('local')->get('geds/'.Auth::user()->id_client.'/'.$entry->ressource_id.'/'.$entry->filename);
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
		$ged = Ged::find($id);
		$ressource_id = $ged->ressource_id;
		$filename = $ged->filename;
		$ged->delete();
		if (Storage::exists('geds/'.AUth::user()->id_client.'/'.$ressource_id.'/'.$filename))
		{
    		Storage::delete('geds/'.AUth::user()->id_client.'/'.$ressource_id.'/'.$filename);
		}
		return redirect::to('/ressource/edit/'.$ressource_id);

	}

}
