<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

$router->get('/', function () use ($router) {
    
    // echo app('hash')->make('password');
    try {
        DB::connection()->getPdo();
    } catch (\Exception $e) {
        print_r("Could not connect to the database.  Please check your configuration. error:" . $e );
    }
    return $router->app->version();

});
$router->post(
    'auth/login', 
    [
       'uses' => 'Auth\AuthController@authenticate'
    ]
);


$router->group(
    ['middleware' => 'jwt.auth'], 
    function() use ($router) {
        $router->get('users', function(Request $request) {
            
            $users = \App\User::all();
            return response()->json($users);
        });
    }
);
