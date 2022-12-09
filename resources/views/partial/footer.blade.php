<?php

$footerInfo=\App\footer_info::all();

?>

<footer id="footer">
    <div class="footer_top">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="footer_widget wow fadeInLeftBig">
                    <h2>{{$footerInfo[0]->title}}</h2>
                    <p>{!! $footerInfo[0]->details !!} </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="footer_widget wow fadeInDown">
                    <h2>{{$footerInfo[1]->title}}</h2>
                    <ul class="tag_nav">

                    </ul>
                    <p>{!! $footerInfo[1]->details !!} </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="footer_widget wow fadeInRightBig">
                    <h2>{{$footerInfo[2]->title}}</h2>
                    <p>{!! $footerInfo[2]->details !!} </p>
                    <address>

                    </address>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <p class="copyright">Copyright &copy; {{date('Y')}} </p>
        <p style="display: none">Total Visitors : {{ Counter::showAndCount('/') }}</p>
        <p class="developer"></p>
    </div>
</footer>