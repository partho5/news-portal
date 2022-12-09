@extends('dashboard.index')

<style type="text/css">
    .cross{
        color: #FF0000;
    }
    .cross:hover{
        cursor: pointer;
        color: #ff5c87;
    }
    tr, td{
        text-align: center;
    }
</style>

@section('admin_page_content')

    <h2 style="text-align: center">Which news is headline of the day?</h2>
    <table border="1" style="width: 100%">
        <tr><th style="display: none;">id</th> <th>News Title</th> <th>Category</th> <th>Mark</th> </tr>
        @foreach($todays_news as $news)
            <?php $checkedStatus= ($news->id == $headlineId) ? "checked" : "" ?>
            <tr>
                <td style="display: none;">{{$news->id}}</td>
                <td><a href="/admin/{{$news->id}}/edit" target="_blank">{{$news->headline}}</a></td>
                <td>{{$news->news_category}}</td>
                <td>  <input type="radio" class="radioHeadline" name="headline" value="{{$news->id}}" {{$checkedStatus}}>  </td>
            </tr>
        @endforeach
    </table>
<hr><hr>

    <?php
        $myLibrary=new \App\MyClasses\Library();
        $newsCategories=$myLibrary->getNewsCategories();
    ?>

    @foreach($newsCategories as $item)
        <table border="1" style="width: 100%">
            <h3 style="text-align: center">{{$categoryWiseNews[$item]->news_category or ""}}</h3>
            <tr><th style="display: none;">id</th> <th>Most important</th> <th>News Title</th> <th>Created at</th> <th>Delete</th> </tr>
            <?php
                $news=\App\News::where('news_category', $item)->orderBy('published_at', 'desc')->take(6)->get();
            ?>
                @foreach($news as $singleRow)
                <tr>
                    <td style="display: none;">{{$singleRow->id}}</td>
                    <?php $checkedStatus= ($singleRow->most_important)==1 ? "checked" : "" ?>
                    <td><input type="radio" class="radioImportant" name="{{$singleRow->news_category}}" value="{{$singleRow->id}}" {{$checkedStatus}}> </td>
                    <td><a href="/admin/{{$singleRow->id}}/edit" target="_blank">{{$singleRow->headline}}</a> </td>
                    <td>{{$singleRow->created_at}}</td>
                    <td> <span class="cross">X</span> </td>
                </tr>
                @endforeach
        </table> <hr>
    @endforeach


    <script src="/dashboard/js/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".radioImportant").click(function () {
                var rowId=$(this).parent().parent().children().eq(0).text();
                var news_category=$(this).attr('name');

                //ajax call
                $.ajax({
                    url:"/admin/ajax/"+rowId,
                    type:"PUT",
                    dataType:"text",
                    data:{
                        _token: "<?php echo csrf_token() ?>",
                        identity: "editNewsMarkImportant",
                        rowId:rowId,
                        news_category:news_category
                    },
                    success:function (response) {
                        console.log(response);
                    },
                    error:function (xhr, textStatus) {
                        console.log(xhr+"\n"+textStatus);
                        alert("Unable to update data. Try again or Contact support");
                    }
                });
            }); /* .radioImportant */

            $(".radioHeadline").click(function () {
                var rowId=$(this).parent().parent().children().eq(0).text();

                $.ajax({
                    url:"/admin/ajax/"+rowId,
                    type:"PUT",
                    dataType:"text",
                    data:{
                        _token: "<?php echo csrf_token() ?>",
                        identity: "editNewsHeadline",
                        rowId:rowId
                    },
                    success:function (response) {
                        console.log(response);
                    },
                    error:function (xhr, textStatus) {
                        console.log(xhr+"\n"+textStatus);
                        alert("Unable to update data. Try again or Contact support");
                    }
                });
            }); //radioHeadline

            $(".cross").click(function () {
                if(confirm("Sure Delete ? This cann't be undone")){
                    var rowId=$(this).parent().parent().children().eq(0).text();
                    console.log(rowId);
                    $.ajax({
                        url:"/admin/ajax/"+rowId,
                        type:"DELETE",
                        dataType:"text",
                        data:{
                            _token:"<?php echo csrf_token(); ?>",
                            identity:"delete_news"
                        },
                        success:function (response) {
                            console.log(response);
                        }
                    });
                    $(this).parent().parent().css('background-color', '#a4a2a2');
                    $(this).parent().parent().fadeToggle(1500);
                }
            });
        });
    </script>

@endsection
