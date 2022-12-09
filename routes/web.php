<?php

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



Route::get('/', function () {
    $menus=\App\menu_items::all();
    //$news=\App\News::all();

    $headlineToday=\App\News::where(['id' => function($query){
        $query->select('news_id')
            ->from('headline_today');
    }])->get();

    $visitor =Tracker::onlineUsers();

    //return view('index', compact('menus', 'headlineToday'));
    return view('index', compact('menus', 'headlineToday', 'visitor'));
});



Route::resource('/admin/ajax', 'dashboardAjaxController');


Route::get('/admin/{$id}', function (){
    return view('dashboard.edit_news');
});
Route::get('/admin/edit_news/{id}/edit', 'dashboardController@edit');
Route::resource('admin', 'dashboardController');


Route::get('pages/{pageName}', 'PagesController@loadPage');

Route::get('/news_id/{id}', 'PagesController@showEachNews');


Auth::routes();
Route::get('/home', 'HomeController@index');


Route::resource('/hit_counter', 'HitControllerAjax');