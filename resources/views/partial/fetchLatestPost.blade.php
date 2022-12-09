<?php

$latest_news=\App\News::where('published_at', '>=', \Carbon\Carbon::now()->subDays(2))->take(6)->get();

//end php
?>

@foreach($latest_news as $news)
    <li>
        <div class="media"> <a href="/news_id/{{$news->id}}" class="media-left"> <img alt="" src="{{$news->headline_image}}"> </a>
            <div class="media-body"> <a href="/news_id/{{$news->id}}" class="catg_title"> {{$news->headline}} </a> </div>
        </div>
    </li>
@endforeach