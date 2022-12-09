<?php

$social_links=\App\SocialLinks::all();

//end php
?>

@foreach($social_links as $link)
    @if( $link->media_name == "mail" )
        <li title="Click to send mail" class="{{$link->media_name or "" }}"><a href="mailto:{{$link->link or "" }}" target="_blank"></a></li>
    @elseif( $link->link )
        <li class="{{$link->media_name or "" }}"><a href="{{$link->link or "" }}" target="_blank"></a></li>
    @endif
@endforeach
