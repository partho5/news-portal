<?php

/**
 * Created by PhpStorm.
 * User: partho
 * Date: 3/8/17
 * Time: 11:10 PM
 */

namespace App\MyClasses;

use App\menu_items;
use App\News;
use Carbon\Carbon;
use DB;

use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;

class Library
{
    public function getNewsCategories(){
        $availableItem=array(); $i=-1;
        $menus=menu_items::all();
        foreach ($menus as $eachRow){
            $submenus=explode("@@-@@", $eachRow->sub_menu);
            if (sizeof($submenus)>=1 && $submenus[0]){ /* has sub menu*/
                foreach ($submenus as $sub){
                    $availableItem[++$i]=$sub;
                }
            }else{
                $availableItem[++$i]=$eachRow->menu;
            }
        }
        return array_unique($availableItem);
    }

    public function getNewsCategoriesExcept($except){
        $except=( is_null($except) ) ? array() : $except;

        $availableItem=array(); $i=-1;
        $menus=menu_items::all();
        foreach ($menus as $eachRow){
            $submenus=explode("@@-@@", $eachRow->sub_menu);
            if (sizeof($submenus)>=1){ /* has sub menu*/
                foreach ($submenus as $sub){
                    if( ! in_array($sub, $except) ){
                        $availableItem[++$i]=$sub;
                    }
                }
            }else{
                if( ! in_array($eachRow->menu, $except) ){
                    $availableItem[++$i]=$eachRow->menu;
                }
            }
        }
        return array_unique($availableItem);
    }

    public function getSubMenus(){
        $availableItem=array(); $i=-1;
        $menus=menu_items::all();
        foreach ($menus as $eachRow){
            $submenus=explode("@@-@@", $eachRow->sub_menu);
            if (sizeof($submenus)>=1){ /* has sub menu*/
                foreach ($submenus as $sub){
                    $availableItem[++$i]=$sub;
                }
            }else{
                //do nothing
            }
        }
        return array_unique($availableItem);
    }

    public function newsOfCategory($categoryName){
        return
            News::where('news_category', $categoryName)
            ->where('published_at', '>=', Carbon::yesterday())
            ->take(12)
            ->get();
    }

    public function hitIncrment($id){
        $raw=DB::table('news')
            ->where(['id' => $id])
            ->pluck('hit');

        $existingHit=$raw[0];

        DB::table('news')
            ->where(['id' => $id])
            ->update(['hit' => ++$existingHit]);

        //return $existingHit;
    }



    public function fetchHourlyChartData(){
        $ttl=0;
        for($i=1; $i<=23; $i++){
            $data2=DB::table('kryptonit3_counter_page_visitor')
                ->select(DB::raw('count(*) as total'))
                ->where(DB::raw('hour(created_at)'),  $i )->get();
            $data2=$data2->toArray();

            //adding 6 hours
            $h=$i+6;
            $h=($h>23)? $h-24 : $h;

            //to 12 hours format
            $h=($h>11)? ($h-12).' PM' : $h.' AM';

            $data[$i]=[ $h , $data2[0]->total ];
            $ttl+=$data2[0]->total;
        }

        $population = Lava::DataTable();
        $population->addStringcolumn('Hour')
            ->addNumberColumn('Number of visitors: ['.$ttl.']')
            ->addRows($data);

        Lava::ColumnChart('Population_hour', $population, [
            'title' => 'Visitors per hour',
            'legend' => [
                'position' => 'top'
            ]
        ]);
    }

    public function fetchDailyChartData(){
        $ttl=0;
        for($i=1; $i<=31; $i++){
            $data2=DB::table('kryptonit3_counter_page_visitor')
                ->select(DB::raw('count(*) as total'))
                ->where(DB::raw('day(created_at)'),  $i )->get();
            $data2=$data2->toArray();

            $data[$i]=[ $i , $data2[0]->total ];
            $ttl+=$data2[0]->total;
        }

        $population = Lava::DataTable();
        $population->addStringcolumn('Day')
            ->addNumberColumn('Number of visitors: ['.$ttl.']')
            ->addRows($data);

        Lava::ColumnChart('Population_daily', $population, [
            'title' => 'Daily Visitors',
            'legend' => [
                'position' => 'top'
            ]
        ]);
    }

    public function fetchMonthlyChartData(){
        $ttl=0;
        for($i=1; $i<=12; $i++){
            $data2=DB::table('kryptonit3_counter_page_visitor')
                ->select(DB::raw('count(*) as total'))
                ->where(DB::raw('month(created_at)'),  $i )->get();
            $data2=$data2->toArray();

            $months=['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            $data[$i]=[ $months[$i-1] , $data2[0]->total ];
            $ttl+=$data2[0]->total;
        }

        $population = Lava::DataTable();
        $population->addStringcolumn('Month')
            ->addNumberColumn('Number of visitors: ['.$ttl.']')
            ->addRows($data);

        Lava::ColumnChart('Population_month', $population, [
            'title' => 'Visitors per month',
            'legend' => [
                'position' => 'top'
            ]
        ]);
    }
}