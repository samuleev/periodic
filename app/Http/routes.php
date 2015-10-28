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

Route::get('/journal', array('uses' => 'JournalController@index', 'as' => 'journal.index'));
Route::get('/journal/{prefix}', array('uses' => 'JournalController@show', 'as' => 'journal.details'))->where('prefix', '[a-z]*');
Route::get('/journal/{prefix}/{selectedYear}', array('uses' => 'EditionController@byYear', 'as' => 'editions.by_year'))->where(array('prefix' => '[a-z]*', 'selectedYear' => '[1-2][0-9]{3}'));
Route::get('/journal/{prefix}/{selectedYear}/{number}', array('uses' => 'EditionController@show', 'as' => 'edition.details'))->where(array('prefix' => '[a-z]*', 'selectedYear' => '[1-2][0-9]{3}', 'number' => '[1-9][0-9]*'));
Route::get('/article/{id}', array('uses' => 'ArticleController@show', 'as' => 'article.details'))->where('id', '[1-9][0-9]*');
Route::get('/article/{id}/download', array('uses' => 'ArticleController@download', 'as' => 'article.download'))->where('id', '[1-9][0-9]*');
Route::get('/import', array('uses' => 'ImportController@import', 'as' => 'import.main'));
Route::get('/author', array('uses' => 'AuthorController@index', 'as' => 'author.index'));