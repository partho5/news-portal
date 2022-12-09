<?php

namespace App\Http\Controllers;

use App\MyClasses\Library;

use App\menu_items;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function loadPage($pageName){

        $menus=menu_items::all();

        $myLibrary=new Library();
        $availablePages=$myLibrary->getNewsCategories();
        if( ! in_array($pageName, $availablePages)){
            return abort('404');
        }

        $headlineToday=\App\News::where(['id' => function($query){
            $query->select('news_id')
                ->from('headline_today');
        }])->get();

        $newsOfThisCategory=$myLibrary->newsOfCategory($pageName);

        return view('news_pages.news_category', compact('menus', 'headlineToday', 'newsOfThisCategory'));
        //return dd($availablePages);
    }


    public function showEachNews($id){

        $myLibrary=new Library();

        $menus=menu_items::all();

        $singleNews=News::where('id', $id)->get();

        if( count($singleNews) ){

            $headlineToday=\App\News::where(['id' => function($query){
                $query->select('news_id')
                    ->from('headline_today');
            }])->get();

            $myLibrary->hitIncrment($id);

            return view('news_pages.single_news', compact('menus', 'singleNews', 'headlineToday'));
        }
        else{
            return view('errors.404');
        }
    }
}
