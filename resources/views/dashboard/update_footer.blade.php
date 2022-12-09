@extends('dashboard.index')

<?php
$footerInfo=\App\footer_info::all();
?>

<style>
    .bar{
        border: 2px solid;
        display: block;
        margin: 4px;
        float: left;
    }
    .bar textarea{
        width: 100%;
        height: 200px;
    }
    .bar input{
        margin-top: 10px;
        text-align: center;
    }
    .bar p{
        text-align: center;
    }
    .successMsg{
        color: #27a22c;
    }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@section('admin_page_content')
    <h3>Update footer informations</h3>


        <div class="bar col-md-3">
            <p>Left column</p>
            <input style="height: 30px;" class="form-control" value="{{$footerInfo[0]->title}}" type="text" placeholder="Title (should be short)">
            <textarea id="txtarea1">{!! $footerInfo[0]->details !!}</textarea>
            <button class="update_btn btn-primary" style="height: 30px; margin-bottom: 5px">Update</button>
            <span style="display: none" class="successMsg">Updated</span>
        </div>
        <div class="bar col-md-3">
            <p>Middle Column</p>
            <input style="height: 30px;" class="form-control" value="{{$footerInfo[1]->title}}" type="text" placeholder="Title (should be short)">
            <textarea id="txtarea2">{!! $footerInfo[1]->details !!}</textarea>
            <button class="update_btn btn-primary" style="height: 30px; margin-bottom: 5px">Update</button>
            <span style="display: none" class="successMsg">Updated</span>
        </div>
        <div class="bar col-md-3">
            <p>Right column</p>
            <input style="height: 30px;" class="form-control" value="{{$footerInfo[2]->title}}" type="text" placeholder="Title (should be short)">
            <textarea id="txtarea3">{!! $footerInfo[2]->details !!}</textarea>
            <button class="update_btn btn-primary" style="height: 30px; margin-bottom: 5px">Update</button>
            <span style="display: none" class="successMsg">Updated</span>
        </div>



    <script src="/dashboard/js/jquery.min.js"></script>
    <script src="/dashboard/js/nicEdit.js" type="text/javascript"></script>
    <script>
        bkLib.onDomLoaded(function () {
            new nicEditor({fullPanel:true}).panelInstance('txtarea1');
            new nicEditor({fullPanel:true}).panelInstance('txtarea2');
            new nicEditor({fullPanel:true}).panelInstance('txtarea3');
        });

        $(document).ready(function () {
            $(".update_btn").click(function () {
                var columnName=$(this).parent().children().eq(0).text() ;
                var title=$(this).parent().find('input').val() ;
                var details=$(this).parent().parentsUntil('textarea').val();

                var niceEdit1=new nicEditors.findEditor('txtarea1');
                var niceEdit2=new nicEditors.findEditor('txtarea2');
                var niceEdit3=new nicEditors.findEditor('txtarea3');

                if(columnName=="Left column"){
                    details=niceEdit1.getContent();
                }else if(columnName=="Middle Column"){
                    details=niceEdit2.getContent();
                }else if(columnName=="Right column"){
                    details=niceEdit3.getContent();
                }

                //console.log(columnName+"\n"+title+"\n"+details);
                var THIS=$(this);

                $.ajax({
                    url:"/admin/ajax/"+title,
                    type:"PUT",
                    dataType:"text",
                    data:{
                        _token:"<?php echo csrf_token(); ?>",
                        identity:"updateFooter",
                        column_name:columnName,
                        title:title,
                        details:details
                    },
                    success:function (response) {
                        console.log(response);
                        THIS.next().show();
                        setTimeout(function () {
                            THIS.next().fadeToggle(1000);
                        }, 500);
                    },
                    error:function (xhr, status) {
                        console.log(xhr+"\n"+status);
                    }
                });
            });
        });
    </script>

@endsection