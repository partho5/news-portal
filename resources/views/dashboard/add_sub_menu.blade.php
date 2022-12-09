@extends('dashboard.index')

<style>
    .cross{
        color: #FF0000;
    }
    .cross:hover{
        cursor: pointer;
    }
</style>
@section('admin_page_content')
    <h3>Add sub menu item</h3>
    <table border="1">
        <tr><th >id</th> <th>Menu</th> <th>Sub-menu</th> </tr>
        @foreach($menus as $menuItem)
            <tr>
                <td >{{$menuItem->id}}</td>
                <td>{{$menuItem->menu}}</td>
                <td title="Don't forget to Save after deleting or adding new">
                    <?php $subMenus=explode("@@-@@", $menuItem->sub_menu); ?>
                    <div class="sub_menu_container">
                        @foreach($subMenus as $subMenu)
                            <input type='text'  class='sub_menu' value="{{$subMenu}}"> <span class='cross'>X</span>
                        @endforeach
                    </div>
                    <button type="button" class="add_more btn btn-primary">Create More</button>
                    <button type="button" class="save btn btn-primary">Save</button>
                        <span class='successMsg' style='color: #2ca02c; display: none'>Saved</span>
                </td>
            </tr>
        @endforeach
    </table>
@endsection

<script src="/dashboard/js/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(".add_more").click(function () {
            $(this).prev().append("<input type='text'  class='sub_menu'> <span class='cross'>X</span>");
        });

        $(".cross").click(function () {
            $(this).prev('input').remove();
            $(this).hide();
        });
        //$(".cross").attr('title', 'custom text');


        var subMenuItems=[];
        $(".save").click(function () {
            var THIS=$(this);
            var i=0;
            subMenuItems=[];
            var rowId=$(this).parent().parent().children().eq(0).text();
            $(this).parent().find('input').each(function () {
                subMenuItems[i++]=$(this).val();
            });
            //console.log(rowId);
            //console.log(subMenuItems);
            $.ajax({
                url:"/admin/ajax/"+rowId,
                type:"PUT",
                dataType:"text",
                data:{
                    _token:"<?php echo csrf_token() ?>",
                    data:JSON.stringify(subMenuItems)
                },
                success:function (response) {
                    console.log(response);
                    THIS.next().show();
                    setTimeout(function () {
                        THIS.next().fadeToggle(1000);
                    }, 500);
                },
                error:function (xhr, text) {
                    console.log(xhr+"\n"+text);
                }
            });
        });
    });
</script>