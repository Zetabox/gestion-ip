<?PHP
Route::filter('Admin_role', function()
{
    // check the current user
    if (!Entrust::hasRole('Admin')) {
        App::abort(403);
    }
});


