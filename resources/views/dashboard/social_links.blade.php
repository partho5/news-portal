@extends('dashboard.index')

<style>
    table{
        width: 90%;
    }
    td,input{
        text-align: center;
    }
</style>

@section('admin_page_content')
    <h3>Update Social Media Links</h3>

    <table border="1">
        <tr> <th>id</th> <th>Social Media</th> <th>Link</th> <th>Save</th> </tr>
        @foreach($social_links as $link)
            <tr>
                <td>{{$link->id}}</td>
                <td>{{$link->media_name}}</td>
                <td title="Must save after editing"><input style="height: 100%; width: 100%" type="text" class="form-control" value="{{$link->link}}"> </td>
                <td>
                    <button type="button" class="save_btn btn-primary">Save</button>
                    <span style="display: none; color: #1c7d17" class="successMsg">Saved</span>
                </td>
            </tr>
        @endforeach
    </table>

@endsection


<script src="/dashboard/js/jquery.min.js"></script>
<script>
    $(document).ready(function () {

        var THIS;

        $(".save_btn").click(function () {
            THIS=$(this);
            var rowId=$(this).parent().parent().children().eq(0).text();
            var link=$(this).parent().parent().children().find('input').val();

            $.ajax({
                url:"/admin/ajax/"+rowId,
                type:"PUT",
                dataType:"text",
                data:{
                    _token: "<?php echo csrf_token(); ?>",
                    identity:"updateSocialLinks",
                    rowId:rowId,
                    link:link
                },
                success:function (response) {
                    console.log(response);
                    THIS.next().show();
                    setTimeout(function () {
                        THIS.next().fadeToggle(1000);
                    }, 500);
                },
                error:function (xhr, status) {
                    console.log(xhr+"|n"+status);
                    alert("Oops ! Error occured");
                }
            });
        });
    });
</script>