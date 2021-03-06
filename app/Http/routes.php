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

Route::get('/', array('uses' => 'JournalController@root', 'as' => 'journal.root'));
Route::get('/journal', array('uses' => 'JournalController@index', 'as' => 'journal.index'));
Route::get('/journal/eng', array('uses' => 'JournalController@indexEng', 'as' => 'eng.journal.index'));
Route::get('/journal/{prefix}/eng', array('uses' => 'JournalController@showEng', 'as' => 'eng.journal.details'))->where('prefix', '[a-z]*');
Route::get('/journal/{prefix}', array('uses' => 'JournalController@show', 'as' => 'journal.details'))->where('prefix', '[a-z]*');
Route::get('/journal/{prefix}/{selectedYear}', array('uses' => 'EditionController@byYear', 'as' => 'editions.by_year'))->where(array('prefix' => '[a-z]*', 'selectedYear' => '[1-2][0-9]{3}'));
Route::get('/journal/{prefix}/{selectedYear}/eng', array('uses' => 'EditionController@byYearEng', 'as' => 'eng.editions.by_year'))->where(array('prefix' => '[a-z]*', 'selectedYear' => '[1-2][0-9]{3}'));
Route::get('/journal/{prefix}/{selectedYear}/{number}', array('uses' => 'EditionController@show', 'as' => 'edition.details'))->where(array('prefix' => '[a-z]*', 'selectedYear' => '[1-2][0-9]{3}', 'number' => '[1-9][0-9]*'));
Route::get('/journal/{prefix}/{selectedYear}/{number}/eng', array('uses' => 'EditionController@showEng', 'as' => 'eng.edition.details'))->where(array('prefix' => '[a-z]*', 'selectedYear' => '[1-2][0-9]{3}', 'number' => '[1-9][0-9]*'));
Route::get('/journal/{prefix}/{selectedYear}/{number}/raw', array('uses' => 'EditionController@raw', 'as' => 'edition.raw'))->where(array('prefix' => '[a-z]*', 'selectedYear' => '[1-2][0-9]{3}', 'number' => '[1-9][0-9]*'));
Route::get('/journal/{prefix}/editor', array('uses' => 'JournalController@editor', 'as' => 'journal.editor'))->where('prefix', '[a-z]*');
Route::get('/journal/{prefix}/editor/eng', array('uses' => 'JournalController@editorEng', 'as' => 'eng.journal.editor'))->where('prefix', '[a-z]*');
Route::get('/journal/{prefix}/deputy-editor', array('uses' => 'JournalController@deputyEditor', 'as' => 'journal.deputy-editor'))->where('prefix', '[a-z]*');
Route::get('/journal/{prefix}/deputy-editor/eng', array('uses' => 'JournalController@deputyEditorEng', 'as' => 'eng.journal.deputy-editor'))->where('prefix', '[a-z]*');
Route::get('/journal/{prefix}/chapter', array('uses' => 'ChapterController@byJournal', 'as' => 'chapter.journal'))->where('prefix', '[a-z]*');
Route::get('/journal/{prefix}/chapter/eng', array('uses' => 'ChapterController@byJournalEng', 'as' => 'eng.chapter.journal'))->where('prefix', '[a-z]*');
Route::get('/article/{id}', array('uses' => 'ArticleController@show', 'as' => 'article.details'))->where('id', '[1-9][0-9]*');
Route::get('/article/{id}/{language}', array('uses' => 'ArticleController@alternative', 'as' => 'alternative.details'))->where(array('id' => '[1-9][0-9]*', 'language' => 'ukr|rus|eng'));
Route::get('/article/{id}/{fileName}', array('uses' => 'ArticleController@download', 'as' => 'article.download'))->where('id', '[1-9][0-9]*');
Route::get('/article/top', array('uses' => 'ArticleController@top', 'as' => 'article.top'));
Route::get('/import', array('uses' => 'ImportController@import', 'as' => 'import.main'));
Route::get('/author', array('uses' => 'AuthorController@index', 'as' => 'author.index'));
Route::get('/author/by_letter/{letter}', array('uses' => 'AuthorController@showByFirstSurnameLetter', 'as' => 'author.show_by_letter'))->where('letter', '[\w\W]{1,2}');
Route::get('/author/{id}', array('uses' => 'AuthorController@show', 'as' => 'author.details'))->where('id', '[1-9][0-9]*');
Route::get('/author/top50', array('uses' => 'AuthorController@top50', 'as' => 'author.top50'));
Route::get('/year', array('uses' => 'YearController@index', 'as' => 'year.index'));
Route::get('/year/{selectedYear}', array('uses' => 'ArticleController@byYear', 'as' => 'year.details'))->where(array('selectedYear' => '[1-2][0-9]{3}'));
Route::get('/topic', array('uses' => 'TopicController@index', 'as' => 'topic.index'));
Route::get('/topic/{id}', array('uses' => 'TopicController@show', 'as' => 'topic.details'))->where('id', '[1-9][0-9]*');
Route::get('/sitemap.xml', array('uses' => 'SitemapController@main', 'as' => 'sitemap.main'));
Route::get('/sitemap-article{page}.xml', array('uses' => 'SitemapController@article', 'as' => 'sitemap.article'))->where('page', '[1-9][0-9]*');
Route::get('/sitemap-pdf{page}.xml', array('uses' => 'SitemapController@pdf', 'as' => 'sitemap.pdf'))->where('page', '[1-9][0-9]*');
Route::get('/sitemap-author{page}.xml', array('uses' => 'SitemapController@author', 'as' => 'sitemap.author'))->where('page', '[1-9][0-9]*');
Route::get('/sitemap-alternative{page}.xml', array('uses' => 'SitemapController@alternative', 'as' => 'sitemap.alternative'))->where('page', '[1-9][0-9]*');
Route::get('/sitemap-misc.xml', array('uses' => 'SitemapController@misc', 'as' => 'sitemap.misc'));
Route::get('/search', array('uses' => 'SearchController@index', 'as' => 'search.index'));
Route::get('/search/eng', array('uses' => 'SearchController@index', 'as' => 'eng.search.index'));
Route::post('/search', array('uses' => 'SearchController@process', 'as' => 'search.process'));
Route::post('/search/eng', array('uses' => 'SearchController@process', 'as' => 'eng.search.process'));
Route::get('/referat-import', array('uses' => 'ReferatController@import', 'as' => 'referat-import.main'));
Route::get('/oai', array('uses' => 'OaiController@main', 'as' => 'oai.main'));
Route::post('/oai', array('uses' => 'OaiController@mainPost', 'as' => 'oai.mainPost'));
Route::get('/cooperation', array('uses' => 'PageController@cooperation', 'as' => 'page.cooperation'));
Route::get('/cooperation/eng', array('uses' => 'PageController@cooperationEng', 'as' => 'eng.page.cooperation'));
Route::get('/scholar_update', array('uses' => 'PageController@scholar_update', 'as' => 'page.scholar_update'));
Route::get('/chapter', array('uses' => 'ChapterController@index', 'as' => 'chapter.index'));
Route::get('/chapter/eng', array('uses' => 'ChapterController@indexEng', 'as' => 'eng.chapter.index'));
Route::get('/chapter/{id}', array('uses' => 'ChapterController@show', 'as' => 'chapter.details'))->where('id', '[1-9][0-9]*');


