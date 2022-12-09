@extends('dashboard.index')



@section('admin_page_content')
    <h3>Don't forget to save after editing</h3>

    <div id="editable_news">
        {!! Form::model($news, ['method'=>'PATCH', 'action'=>['dashboardController@update', $news->id], 'files'=>true]) !!}
        <p style="color: #ff0000"><a href="/news_id/{{$news->id}}" target="_blank">Preview before editing</a> </p>
        <hr> <div class="form-group">
            {!! Form::label('headline', 'News Headline :') !!}
            {!! Form::text('headline', null, ['class'=>'form-control', 'style="width:600px;"']) !!}
        </div><hr>

        <div class="form-group">
            {!! Form::label('headline_image', 'Headline image :') !!} <span style="color: #FF0000">[ Optional to update ]</span>
            {!! Form::file('headline_image', null, ['class'=>'form-control']) !!}
        </div><hr>

        <div class="form-group">
            {!! Form::label('category', 'Category :') !!}
            @include('partial.fetchNewscategories')
        </div><hr>

        <div class="form-group">
            {!! Form::label('body', 'News Body :') !!}
            {!! Form::textarea('body',null,['class'=>'form-control', 'style="width:800px;"','rows' => 10, 'cols' => 50]) !!}
        </div><hr>

        <div class="form-group">
            {!! Form::label('published_by', 'Published by :') !!}
            {!! Form::text('published_by', null, ['class'=>'form-control']) !!}
        </div><hr>

        <div class="form-group">
            {!! Form::label('published_at', 'Creation Time ( YYYY-MM-DD hh:mm:ss ) :') !!}
            {!! Form::text('published_at',null, ['class'=>'form-control', 'style'=>'display:none']) !!}
        </div>

        <div class="form-congrouptrol">
            {!! Form::submit('Save', ['class'=>'btn btn-primary form-control']) !!}
        </div>

        {!! Form::close() !!}


        @if($errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif
    </div>


    <script src="/dashboard/js/jquery.min.js"></script>
    <script src="/dashboard/js/nicEdit.js" type="text/javascript"></script>

    <script type="text/javascript">

        bkLib.onDomLoaded(function () {

            new nicEditor({fullPanel : true}).panelInstance('body');

        });
    </script>



@endsection


