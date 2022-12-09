<?php

namespace App\Http\Controllers;

use App\headline_today;
use App\HeadlineToday;
use App\Http\Requests\NewsRequest;
use App\kryptonit3_counter_page_visitor;
use App\menu_items;
use App\MyClasses\Library;
use App\News;
use App\SocialLinks;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;


class dashboardController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('dashboard.admin_home');
    }

    public function show($page){

        switch ($page){
            case  'charts' :
                $myLibrary=new Library();
                $myLibrary->fetchHourlyChartData();
                $myLibrary->fetchMonthlyChartData();
                $myLibrary->fetchDailyChartData();
                return view('dashboard.charts');
                break;
            case 'activity_log':
                $news_info=News::all()->take(50);
                $menu_info=menu_items::all();
                return view('dashboard.activity_log', compact('news_info', 'menu_info'));
                break;
            case 'themes':
                return view('dashboard.themes');
                break;
            case 'users':
                return view('dashboard.users');
                break;
            case 'recent_news':
                return view('dashboard.recent_news');
                break;
            case 'gallery':
                return view('dashboard.gallery');
                break;
            case 'most_popular_news':
                $most_popular=News::where('hit', '>', 0)->orderBy('hit', 'desc')->take(30)->get();
                return view('dashboard.most_popular_news', compact('most_popular'));
                break;


                /* START left bar case */
            case 'update_footer':
                return view('dashboard.update_footer');
                break;
            case  'add_menu' :
                $menus=menu_items::all();
                return view('dashboard.add_menu', compact('menus'));
                break;
            case 'add_sub_menu':
                $menus=menu_items::all();
                return view('dashboard.add_sub_menu', compact('menus'));
                break;
            case 'edit_menu':
                $menus=menu_items::all();
                return view('dashboard.edit_menu', compact('menus'));
                break;
            case 'add_video':
                return view('dashboard.add_video');
                break;
            case 'edit_video':
                return view('dashboard.edit_video');
                break;
            case 'add_picture':
                return view('dashboard.add_picture');
                break;
            case 'edit_picture':
                return view('dashboard.edit_picture');
                break;
            case 'write_news':
                $menus=menu_items::all();
                return view('dashboard.write_news', compact('menus'));
                break;
            case 'edit_news':
                $news=News::all();
                $categoryWiseNews=News::all()->keyBy('news_category');
                $todays_news=News::where('created_at', '>=', Carbon::today())->get();

                $headlineId=headline_today::all()[0]->news_id;

                return view('dashboard.edit_news', compact('menus', 'news', 'categoryWiseNews', 'todays_news', 'headlineId'));
                break;

            case 'social_links':
                $social_links=SocialLinks::all();
                return view('dashboard.social_links', compact('social_links'));
                break;
            /* END left bar case */

        }
    }


    public function store(NewsRequest $request){

        $this->validate($request, [
            'headline_image'=>'required'
        ]);

        if( isset($request->all()['headline_image']) ){
            $image=$request->file('headline_image');
            $fileName=$image->getClientOriginalName();
            $fileSize=$image->getSize(); //in Bytes

            Storage::disk('uploads')->put($fileName, $image);
            //image can be accessed in this way:
            //echo "<a href='/uploads/$fileName/".$image->hashName()."' target='_blank'>$fileName</a>";

            $modifiedRequestArray = $request->all();
            $modifiedRequestArray['headline_image'] = '/uploads/'.$fileName.'/'.$image->hashName();
        }
        else{
            $modifiedRequestArray=$request->all();
        }

        News::create($modifiedRequestArray);

        $msg="Previous news has been saved";
        session(['msg'=>$msg]);

        //return 'saved';

        return redirect('/admin/write_news');
    }


    public function editSingleNews($id){

    }

    public function edit($id){
        $menus=menu_items::all();
        $news=News::findOrFail($id);
        return view('dashboard.edit_single_news', compact('menus', 'news'));
    }


    public function update($id, NewsRequest $request){

        if( isset($request->all()['headline_image']) ){
            $image=$request->file('headline_image');
            $fileName=$image->getClientOriginalName();
            $fileSize=$image->getSize(); //in Bytes

            Storage::disk('uploads')->put($fileName, $image);
            //image can be accessed in this way:
            //echo "<a href='/uploads/$fileName/".$image->hashName()."' target='_blank'>$fileName</a>";

            $modifiedRequestArray = $request->all();
            $modifiedRequestArray['headline_image'] = '/uploads/'.$fileName.'/'.$image->hashName();
        }
        else{
            $modifiedRequestArray=$request->all();
        }




        $news=News::findOrFail($id);
        $news->update($modifiedRequestArray);


        $news=News::all();
        $categoryWiseNews=News::all()->keyBy('news_category');
        $todays_news=News::where('published_at', Carbon::today())->get();

        $headlineId=headline_today::all()[0]->news_id;

        return view('dashboard.edit_news', compact('menus', 'news', 'categoryWiseNews', 'todays_news', 'headlineId'));
    }
}
