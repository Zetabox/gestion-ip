<?php namespace App\Http\Controllers;
use DB;
use App\User;
class Vue1Controller extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Vue1 Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

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
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		//$results = DB::table('users')->orderBy('name')->get();
		$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$sens = (isset($_GET['sens'])) ? $_GET['sens'] : 'ASC';
		echo $sort;
		//if(isset($_GET['sort'])) ? $_GET['sort'] : 'name';
		$results = User::orderBy($sort, $sens)->paginate(2);
		
		//$results = 'vraiment';

		//$results='oooooo';
		
		return view('vue1')->with('results',$results)->with('sort',$sort)->with('sens',$sens);
	}

}

