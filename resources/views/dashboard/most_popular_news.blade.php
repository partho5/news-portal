@extends('dashboard.index')


@section('admin_page_content')
    <h3>!! Most Hit newses !!</h3>

    <?php
        $i=0;
    ?>

    <div style="height: 400px; overflow: scroll;">
        <table border="1" style="width: 100%">
            <tr> <th>No</th> <th>Headline</th> <th>Total Hit</th> </tr>
            @foreach($most_popular as $news)
                <tr>
                    <td>{{++$i}}</td>
                    <td><a href="/news_id/{{$news->id}}" target="_blank">{{$news->headline}}</a></td>
                    <td>{{$news->hit}}</td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection