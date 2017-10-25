<?php



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::when('admin/*', 'SuperAdmin');

//Route::get('admin/1', 'AdminController@index', ['middleware' => 'checkrole']);

Route::get('admin/', [  
    'middleware' => 'checkrole',
    'uses' => 'AdminController@index'
]);

//Route::get('startrules', 'StartRules@index');

Route::get('admin/categorie','AdminCategorieController@index');
Route::get('admin/categorie/list/{id}', 'AdminCategorieController@liste');
Route::get('admin/categorie/edit/{id}','AdminCategorieController@edit');
Route::get('admin/categorie/destroy/{id}','AdminCategorieController@destroy');
Route::post('admin/categorie/update/','AdminCategorieController@update');
Route::post('admin/categorie/store', 'AdminCategorieController@store');

Route::get('admin/obligation/list/{id}', 'AdminObligationController@liste');
Route::get('admin/obligation/show/{id}', 'AdminObligationController@show');
Route::get('admin/obligation/edit/{id}', 'AdminObligationController@edit');
Route::post('admin/obligation/update', 'AdminObligationController@update');
Route::post('admin/obligation/search', 'AdminObligationController@search');
Route::get('admin/obligation/destroy/{id}','AdminObligationController@destroy');
Route::get('admin/obligationdetail/destroy/{id}','AdminObligationController@destroydetail');
Route::get('admin/obligation/create/{id}', 'AdminObligationController@create');
Route::post('admin/obligation/create', 'AdminObligationController@store');
Route::post('admin/obligation/adddetail', 'AdminObligationController@adddetail');

Route::get('admin/client/new', 'AdminClientController@create');
Route::get('admin/user/edit/{id}','AdminClientController@editUser');
Route::get('admin/user/destroy/{id}','AdminClientController@destroyUser');
Route::post('admin/user/update/{id}','AdminClientController@updateUser');
Route::post('admin/client/new', 'AdminClientController@store');
Route::get('admin', 'AdminController@index');
Route::get('admin/client', 'AdminClientController@index');
Route::get('admin/client/edit/{id}', 'AdminClientController@edit');
Route::post('admin/client/edit/{id}', 'AdminClientController@update');
Route::post('admin/client/updateFormule/{id}', 'AdminClientController@updateFormule');
Route::post('admin/client/createClient/{id}', 'AdminClientController@addUser');
Route::post('admin/client/search','AdminClientController@search');
Route::get('admin/client/destroy/{id}', 'AdminClientController@destroy');
Route::post('admin/client/addcontrat','AdminClientController@addContrat');




Route::get('admin/lettre','AdminLettreTypeController@index');
Route::get('admin/lettre/list/{id}','AdminLettreTypeController@liste');
Route::get('admin/lettre/create/{id}','AdminLettreTypeController@create');
Route::post('admin/lettre/store','AdminLettreTypeController@store');
Route::post('admin/lettre/update','AdminLettreTypeController@update');
Route::get('admin/lettre/edit/{id}','AdminLettreTypeController@edit');
Route::get('admin/lettre/destroy/{id}','AdminLettreTypeController@destroy');
Route::get('admin/lettre/show/{filename}','AdminLettreTypeController@show');
route::post('admin/lettre/search','AdminLettreTypeController@search');
Route::get('/admin/support/','SupportController@index');

Route::get('/', 'HomeController@index');
Route::get('/tutorial','TutorialController@index');

Route::get('home', 'HomeController@index');

Route::get('vue1', 'Vue1Controller@index');
Route::get('site/list', 'SiteController@index');
Route::get('site/create', 'SiteController@create');
Route::post('site/create', 'SiteController@store');
Route::post('site/update', 'SiteController@update');
Route::get('site/edit/{id}', 'SiteController@edit');
Route::get('site/destroy/{id}', 'SiteController@destroy');

Route::get('obligation/list/{id}', 'ObligationController@liste');
Route::get('obligation/create/{id}', 'ObligationController@create');
Route::get('obligation/edit/{id}', 'ObligationController@edit');
Route::get('obligation/show/{id}', 'ObligationController@show');
route::post('obligation/create', 'ObligationController@postcreate');
route::post('obligation/update', 'ObligationController@update');
Route::get('obligation/destroy/{id}','ObligationController@destroy');
Route::get('obligationdetail/destroy/{id}','ObligationController@destroydetail');
Route::post('obligation/adddetail', 'ObligationController@adddetail');
Route::post('obligation/search', 'ObligationController@search');


Route::get('ressource', 'RessourceController@index');
Route::get('ressource/create', 'RessourceController@create');
Route::post('ressource/create', 'RessourceController@assistant');
Route::get('ressource/assistant', 'RessourceController@assistant');
Route::post('ressource/store','RessourceController@store');
Route::post('ressource/update','RessourceController@update');
Route::get('ressource/list/{id}', 'RessourceController@liste');
Route::get('ressource/show/{id}','RessourceController@show');
Route::get('ressource/edit/{id}','RessourceController@edit');
Route::get('ressource/destroy/{id}','RessourceController@destroy');
Route::get('ressource/addobligation/{id}','RessourceController@addobligation');
route::post('ressource/search','RessourceController@search');
Route::get('ged/create/{ressource_id}','GedController@create');
Route::post('ged/store/','GedController@store');
Route::get('ged/show/{filename}','GedController@show');
Route::get('ged/destroy/{id}','GedController@destroy');
route::get('dashboard/list/{id}','RessourceController@dashboard');

Route::get('intervention/create/{id}','InterventionController@create');
Route::get('intervention/createUnique/{id}','InterventionController@createUnique');
Route::post('intervention/store','InterventionController@store');

Route::get('utilisateur/list','UserController@index');
route::get('utilisateur/create','UserController@create');
Route::post('utilisateur/store','UserController@store');
Route::get('utilisateur/edit/{id}','UserController@edit');
Route::get('utilisateur/destroy/{id}','UserController@destroy');
Route::post('utilisateur/update/{id}','UserController@update');
Route::get('lettre/list/{id}','LettreTypeController@liste');
Route::get('lettre/show/{filename}','LettreTypeController@show');
route::post('lettre/search','LettreTypeController@search');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::get('mail','MailController@mail_envoyer');
Route::get('mail_client','MailController@mail_client');


Route::get('{n}', function($n) { 
    return 'Je suis la page ' . $n . ' !'; 
})->where('n', '[1-3]');



