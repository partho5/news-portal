<?php

namespace App\Http\Controllers;

use App\dashboardAjax;
use App\Http\Requests\adminAjaxRequest;
use App\menu_items;
use Illuminate\Http\Request;
use DB;
use League\Flysystem\Exception;

class dashboardAjaxController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return abort('404');
    }


    public function show(){

    }


    public function store(Request $request){
        $data=json_decode($request->all()['menuItems']);

        $data2=array();

        try{
            foreach ($data as $d){
                $data2['menu']=$d;
                DB::table('menu_items')->insert($data2);
            }
            echo "success";
        }catch (Exception $e){

        }
    }

    public function update($id, adminAjaxRequest $request){

        try{
            $identity=$request->all()['identity'];
            //echo $identity;
        }catch (\Exception $e){

        }

        if( isset($identity) ) {
            if($identity =="menuSubmenuUpdate" ){
                $menuData=$request->all()['menuData'];
                $subMenuData=$request->all()['subMenuData'];
                $subMenuData=json_decode($subMenuData);
                $sub_menus=implode("@@-@@", $subMenuData);

                DB::table('menu_items')
                    ->where('id', $id)
                    ->update(['sub_menu'=>$sub_menus, 'menu'=>$menuData]);

                echo "menu sub-menu updated";

            }
            elseif ($identity =="editNewsMarkImportant" ){
                //echo "this is a request from edit important news";

                $rowId=$request->all()['rowId'];
                $news_category=$request->all()['news_category'];

                DB::table('news')
                    ->where(['news_category'=>$news_category])
                    ->update(['most_important'=>0]);

                DB::table('news')
                    ->where('id', $rowId)
                    ->update(['most_important'=>1]);

                echo $rowId. ' marked as most important';
            }

            elseif ($identity=="editNewsHeadline"){
                $rowId=$request->all()['rowId'];

                DB::table('headline_today')
                    ->where(['id' => 1])
                    ->update(['news_id' => $rowId]);

                echo $rowId.' marked as headline of the day';
            }

            elseif ($identity=="updateSocialLinks"){
                $rowId=$request->all()['rowId'];
                $link=$request->all()['link'];
                if( !isset($link) ){
                    $link='';
                }

                DB::table('social_links')
                    ->where(['id' => $rowId])
                    ->update(['link' => $link]);
            }

            elseif ($identity=="updateFooter"){
                $column_name=$request->all()['column_name'] ; //column_name was passed as $id
                $title=$request->all()['title'];
                $details=$request->all()['details'];

                DB::table('footer_info')
                    ->where(['column_name' => $column_name])
                    ->update(['title' => $title, 'details' => $details]);
                echo "updated";
                //echo $column_name.'---'.$title.'----'.$details;
            }
        }
    }

    public function destroy($id, Request $request){
        $identity=$request->all()['identity'];

        if($identity=="menu_items"){
            DB::table('menu_items')->where('id', $id)->delete();
            echo "deleted";
        }
        elseif ($identity=="delete_news"){
            DB::table('news')->where('id', $id)->delete();
            echo "news deleted";
        }
    }
}
