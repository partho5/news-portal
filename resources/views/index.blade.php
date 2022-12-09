<!DOCTYPE html>
<html>
<head>
    <title>News of the day</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font.css">
    <link rel="stylesheet" type="text/css" href="assets/css/li-scroller.css">
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css">
    <link rel="stylesheet" type="text/css" href="assets/css/jquery.fancybox.css">
    <link rel="stylesheet" type="text/css" href="assets/css/theme.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.min.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="preloader">
    <div id="status">&nbsp;</div>
</div>
<a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
<div class="container">

    <section id="navArea">
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            </div>



            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav main_nav">
                    <li class="active"><a href=""><span class="fa fa-home desktop-home"></span><span class="mobile-show">Home</span></a></li>

                    @foreach($menus as $eachRow)
                        <?php $subMenu=explode("@@-@@", $eachRow->sub_menu); ?>
                        @if(sizeof($subMenu)>=1 && $subMenu[0])
                            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{$eachRow->menu or "" }}</a>
                                <ul class="dropdown-menu" role="menu">
                                    @foreach($subMenu as $sub)
                                        <li><a href="/pages/{{$sub or "" }}">{{$sub or "" }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            @foreach($subMenu as $sub)
                                <li><a href="/pages/{{$eachRow->menu or "" }}">{{$eachRow->menu or "" }}</a></li>
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            </div>


        </nav>
    </section>
    <?php

    ?>

    <section id="newsSection">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="latest_newsarea"> <span>Latest News</span>
                    <ul id="ticker01" class="news_sticker">
                        @include('partial.topbarFloatingNews')
                    </ul>
                    <div class="social_area">
                        <ul class="social_nav">
                            @include('partial.fetchSocialLilnks')
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="sliderSection">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="slick_slider">
                    @if( isset($headlineToday[0]) )
                        <div class="single_iteam"> <a href="/news_id/{{$headlineToday[0]->id or "" }}"> <img src="{{$headlineToday[0]->headline_image or "" }}" alt=""></a>
                            <div class="slider_article">
                                <h2><a class="slider_tittle" href="/news_id/{{$headlineToday[0]->id or "" }}">{{$headlineToday[0]->headline or "" }}</a></h2>
                                <p>
                                    <?php
                                    $body=$headlineToday[0]->body;
                                    ?>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="latest_post">
                    <h2><span>Latest post</span></h2>
                    <div class="latest_post_container">
                        <div id="prev-button"><i class="fa fa-chevron-up"></i></div>
                        <ul class="latest_postnav">
                            @include('partial.fetchLatestPost')
                        </ul>
                        <div id="next-button"><i class="fa  fa-chevron-down"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="contentSection">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="left_content">

                    <?php
                    $myLibrary=new \App\MyClasses\Library();
                    //$except=$myLibrary->getSubMenus();
                    $newsCategories=$myLibrary->getNewsCategories();
                    $len=sizeof($newsCategories);

                    ?>

                    @for($t=0; $t<$len; $t+=5)

                        <div class="single_post_content">
                            <h2><span>{{$newsCategories[$t] or "" }}</span></h2>
                            <?php $news=\App\News::where('news_category', $newsCategories[$t])->orderBy('published_at', 'desc')->get(); ?>
                            <div class="single_post_content_left">
                                <ul class="business_catgnav  wow fadeInDown">
                                    <li>
                                        @foreach($news as $eachNews)
                                            @if($eachNews->most_important == 1)
                                                <figure class="bsbig_fig"> <a href="/news_id/{{$eachNews->id or "" }}" class="featured_img"> <img alt="" src="{{$eachNews->headline_image or "" }}"> <span class="overlay"></span> </a>
                                                    <figcaption> <a href="/news_id/{{$eachNews->id or "" }}" class="catg_title">{{$eachNews->headline or "" }}</a> </figcaption>
                                                </figure>
                                            @endif
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                            <div class="single_post_content_right">
                                <ul class="spost_nav">
                                    @foreach($news as $eachNews)
                                        @if($eachNews->most_important == 0)
                                            <li>
                                                <div class="media wow fadeInDown"> <a href="/news_id/{{$eachNews->id or "" }}" class="media-left"> <img alt="" src="{{$eachNews->headline_image or "" }}"> </a>
                                                    <div class="media-body"> <a href="/news_id/{{$eachNews->id or "" }}" class="catg_title">{{$eachNews->headline or "" }}</a>  </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>


                        <div class="news_area">

                            @if( isset($newsCategories[$t+1]) )
                                <div class="left">
                                    <div class="single_post_content">
                                        <?php  $news=\App\News::where('news_category', $newsCategories[$t+1])->orderBy('published_at', 'desc')->get(); ?>
                                        <h2><span>{{$newsCategories[$t+1] or "" }}</span></h2>
                                        <ul class="business_catgnav wow fadeInDown">
                                            <li>
                                                @foreach($news as $eachNews)
                                                    @if($eachNews->most_important == 1)
                                                        <figure class="bsbig_fig"> <a href="/news_id/{{$eachNews->id or "" }}" class="featured_img"> <img alt="" src="{{$eachNews->headline_image or "" }}"> <span class="overlay"></span> </a>
                                                            <figcaption> <a href="/news_id/{{$eachNews->id or "" }}" class="catg_title">{{$eachNews->headline or "" }}</a> </figcaption>
                                                        </figure>
                                                    @endif
                                                @endforeach
                                            </li>
                                        </ul>
                                        <ul class="spost_nav">
                                            @foreach($news as $eachNews)
                                                @if($eachNews->most_important == 0)
                                                    <li>
                                                        <div class="media wow fadeInDown"> <a href="/news_id/{{$eachNews->id or "" }}" class="media-left"> <img alt="" src="{{$eachNews->headline_image or "" }}"> </a>
                                                            <div class="media-body"> <a href="/news_id/{{$eachNews->id or "" }}" class="catg_title">{{$eachNews->headline or "" }}</a>  </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif


                            @if( isset($newsCategories[$t+2]) )
                            <div class="right">
                                <div class="single_post_content">
                                    <h2><span>{{$newsCategories[$t+2] or "" }}</span></h2>
                                    <?php $news=\App\News::where('news_category', $newsCategories[$t+2])->orderBy('published_at', 'desc')->get(); ?>
                                    <ul class="business_catgnav">
                                        <li>
                                            @foreach($news as $eachNews)
                                                @if($eachNews->most_important == 1)
                                                    <figure class="bsbig_fig"> <a href="/news_id/{{$eachNews->id or "" }}" class="featured_img"> <img alt="" src="{{$eachNews->headline_image or "" }}"> <span class="overlay"></span> </a>
                                                        <figcaption> <a href="/news_id/{{$eachNews->id or "" }}" class="catg_title">{{$eachNews->headline or "" }}</a> </figcaption>
                                                    </figure>
                                                @endif
                                            @endforeach
                                        </li>
                                    </ul>
                                    <ul class="spost_nav">
                                        @foreach($news as $eachNews)
                                            @if($eachNews->most_important == 0)
                                                <li>
                                                    <div class="media wow fadeInDown"> <a href="/news_id/{{$eachNews->id or "" }}" class="media-left"> <img alt="" src="{{$eachNews->headline_image or "" }}"> </a>
                                                        <div class="media-body"> <a href="/news_id/{{$eachNews->id or "" }}" class="catg_title">{{$eachNews->headline or "" }}</a>  </div>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>
                        @endif



                        @if( isset($newsCategories[$t+3]) )
                            <div class="single_post_content">
                                <h2><span>{{$newsCategories[$t+3] or "" }}</span></h2>
                                <ul class="photograph_nav  wow fadeInDown">
                                    <?php $news=\App\News::where('news_category', $newsCategories[$t+3])->orderBy('published_at', 'desc')->get(); ?>
                                    @foreach($news as $eachNews)
                                        <li>
                                            <div class="media wow fadeInDown"> <a href="/news_id/{{$eachNews->id or "" }}" class="media-left"> <img alt="" src="{{$eachNews->headline_image or "" }}"> </a>
                                                <div class="media-body"> <a href="/news_id/{{$eachNews->id or "" }}" class="catg_title">{{$eachNews->headline or "" }}</a> </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            {{$newsCategories[$t+4] or ''}}
                        @endif



                        @if( isset($newsCategories[$t+4]) )
                            <div class="single_post_content">
                                <h2><span>{{$newsCategories[$t+4] or "" }}</span></h2>
                                <?php $news=\App\News::where('news_category', $newsCategories[$t+4])->orderBy('published_at', 'desc')->get(); ?>
                                <div class="single_post_content_left">
                                    <ul class="business_catgnav">
                                        <li>
                                            @foreach($news as $eachNews)
                                                @if($eachNews->most_important == 1)
                                                    <figure class="bsbig_fig"> <a href="/news_id/{{$eachNews->id or "" }}" class="featured_img"> <img alt="" src="{{$eachNews->headline_image or "" }}"> <span class="overlay"></span> </a>
                                                        <figcaption> <a href="/news_id/{{$eachNews->id or "" }}" class="catg_title">{{$eachNews->headline or "" }}</a> </figcaption>
                                                    </figure>
                                                @endif
                                            @endforeach
                                        </li>
                                    </ul>
                                </div>
                                <div class="single_post_content_right">
                                    <ul class="spost_nav">
                                        @foreach($news as $eachNews)
                                            @if($eachNews->most_important == 0)
                                                <li>
                                                    <div class="media wow fadeInDown"> <a href="/news_id/{{$eachNews->id or "" }}" class="media-left"> <img alt="" src="{{$eachNews->headline_image or "" }}"> </a>
                                                        <div class="media-body"> <a href="/news_id/{{$eachNews->id or "" }}" class="catg_title">{{$eachNews->headline or "" }}</a>  </div>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                    @endfor
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <aside class="right_content">
                    <div class="single_sidebar">
                        <h2><span>Popular Post</span></h2>
                        <ul class="spost_nav">
                            @include('partial.fetchMostPopular')
                        </ul>
                    </div>

                </aside>
            </div>
        </div>
    </section>

    @include('partial.footer')
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/jquery.li-scroller.1.0.js"></script>
<script src="assets/js/jquery.newsTicker.min.js"></script>
<script src="assets/js/jquery.fancybox.pack.js"></script>
<script src="assets/js/custom.js"></script>

<script>
    $(document).ready(function () {
        $(window).unload(function() {

        });
    });
</script>

</body>
</html>