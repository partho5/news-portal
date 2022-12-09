

<?php

$myLibrary=new \App\MyClasses\Library();
$newsCategories=$myLibrary->getNewsCategories();


$latestNews=array(); $i=-1;
$forbidenForFloatingNews=array('a', 'b');

foreach ($newsCategories as $newsCat){
    if( ! in_array($newsCat, $forbidenForFloatingNews) ){
        $single=\App\News::where('news_category', $newsCat)->orderBy('published_at', 'desc')->first();
        if( ! is_null( $single ) ){
            $latestNews[++$i]=$single;
        }
    }
}


//echo var_dump($latestNews[0]->headline);


?>



@foreach($latestNews as $news)
    <li><a href="/news_id/{{$news->id}}" target="_blank"><img src="{{$news->headline_image}}" alt="">{{$news->headline}}</a></li>
@endforeach



