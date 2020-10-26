<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'IndexController@index')->name('index');

Route::get('/film/characters/{name}', 'FilmController@getFilmCharacters')->name('film.characters');
Route::get('/species', 'MammalController@getMammals')->name('species');
Route::get('/people/import/', 'PeopleController@importPeople')->name('people.import');
Route::get('/people/backup/{file?}', 'PeopleController@backupPeople')->name('people.backup');
Route::get('/people/update', 'PeopleController@updatePeople')->name('people.update');


Route::get('/people/create', 'PeopleController@create')->name('people.create');
Route::post('/people/store', 'PeopleController@store')->name('people.store');


