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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();


Route::get('/', array(
    'as' => 'home',
    'uses' => 'HomeController@index'
));


//Rutas del controlador de videos
Route::get('/crear-video', array(
    'as' => 'createVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@createVideo'
));

//Rutas del controlador para guardar videos
Route::post('/guardar-video', array(
    'as' => 'saveVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@saveVideo'
));

//Obtener la imagen del video
Route::get('/miniatura/{filename}', array(
    'as' => 'imageVideo',
    'uses' => 'VideoController@getImage',
));

//Obtener el video
Route::get('/video-file/{filename}', array(
    'as' => 'fileVideo',
    'uses' => 'VideoController@getVideo',
));

//Obtener la información del video
Route::get('/video/{video_id}', array(
    'as' => 'detailVideo',
    'uses' => 'VideoController@getVideoDetail',
));

//Guardar comentarios
Route::post('/comment', array(
    'as' => 'comment',
    'middleware' => 'auth',
    'uses' => 'CommentController@store',
));

//Eliminar comentario
Route::get('/delete-comment/{comment_id}', array(
    'as' => 'commentDelete',
    'middleware' => 'auth',
    'uses' => 'CommentController@delete',
));

//ELiminar un video
Route::get('/delete-video/{video_id}', array(
    'as' => 'videoDelete',
    'middleware' => 'auth',
    'uses' => 'VideoController@delete',
));

//editar un video
Route::get('/editar-video/{video_id}', array(
    'as' => 'videoEdit',
    'middleware' => 'auth',
    'uses' => 'VideoController@edit',
));

//editar un video
Route::post('/update-video/{video_id}', array(
    'as' => 'updateVideo',
    'middleware' => 'auth',
    'uses' => 'VideoController@update',
));

//buscar un video
Route::get('/buscar/{search?}/{filter?}', [
    'as' => 'videoSearch',
    'uses' => 'VideoController@search',
]);




//BORRAR CACHE CON LARAVEL
Route::get('/borrar-cache', function (){
    $code = Artisan::call('cache:clear');
});



//Informacion del canal del usuario
Route::get('/canal/{user_id}', [
    'as' => 'channel',
    'uses' => 'UserController@channel',
]);


