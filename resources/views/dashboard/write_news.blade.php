@extends('dashboard.index')



@section('admin_page_content')
    <?php
        $msg=session('msg');
        session(['msg'=>null]);/*make null after getting value, so that it doesn't exist after page reload */
        if (!isset($msg)){
            $msg="";
        }
    ?>
    <p style="color: #ee6927; font-size: 20px">{{$msg}}</p>

    <h3>Write news :</h3>

    {!! Form::open(['route'=>'admin.store', 'files'=>'true']) !!}

    <hr> <div class="form-group">
        {!! Form::label('headline', 'News Headline :') !!}
        {!! Form::text('headline', null, ['class'=>'form-control', 'style="width:80%;"']) !!}
    </div><hr>

    <div class="form-group">
        {!! Form::label('headline_image', 'Headline image :') !!}
        {!! Form::file('headline_image', null, ['class'=>'form-control']) !!}
    </div><hr>

    <div class="form-group">
        {!! Form::label('category', 'Category :') !!}
        @include('partial.fetchNewscategories')
    </div><hr>

    <div class="form-group">
        {!! Form::label('body', 'News Body :') !!}
        {!! Form::textarea('body',null,['class'=>'form-control','style="width:90%;"', 'rows' => 10]) !!}
    </div><hr>

    <div class="form-group">
        {!! Form::label('published_by', 'Published by :') !!}
        {!! Form::text('published_by', null, ['class'=>'form-control']) !!}
    </div><hr>

    <div class="form-group">
        {!! Form::label('published_at', 'Publish Time ( YYYY-MM-DD hh:mm:ss ) :') !!}
        {!! Form::text('published_at', \Carbon\Carbon::today() , ['class'=>'form-control']) !!}
    </div>

    <div class="form-congrouptrol">
        {!! Form::submit('Save', ['class'=>'btn btn-primary form-control', 'id'=>'save_btn']) !!}
    </div>

    {!! Form::close() !!}


    @if($errors->any())
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif


    <script src="/dashboard/js/jquery.min.js"></script>
    <script src="/dashboard/js/nicEdit.js" type="text/javascript"></script>

    <script type="text/javascript">

        bkLib.onDomLoaded(function () {

            new nicEditor({fullPanel : true}).panelInstance('body');

            $(document).ready(function () {
                //var niceEdit=new nicEditors.findEditor('body');

                var newsBodyText;
                $("#save_btn").hover(function () {
                    newsBodyText=niceEdit.getContent();
                    $("#body").val(newsBodyText);
                    //console.log(newsBodyText);
                });
            });
        });
    </script>

@endsection




