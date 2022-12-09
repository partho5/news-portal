@extends('dashboard.index')


@section('admin_page_content')


    <?php
        $i=0;
    ?>

    <h3>News creation Log</h3>
    <div style="overflow: scroll; height: 300px;">
        <table border="1" style="width: 100%">
            <tr> <th>No.</th> <th>Headline</th> <th>Category</th> <th>Creation date</th> </tr>
            @foreach($news_info as $news)
                <tr>
                    <td>{{++$i}}</td>
                    <td> <a href="/news_id/{{$news->id}}" target="_blank" >{{$news->headline}}</a> </td>
                    <td>{{$news->news_category}}</td>
                    <td>{{$news->created_at}}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <hr>
   More Logs will be generated soon. keep using.

@endsection