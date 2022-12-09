@extends('dashboard.index')

<style>
    input{
        text-align: center;
    }
</style>

@section('style')
    <style>
        .cross, .cross_row{
            color: #FF0000;
        }
        .cross:hover, .cross_row:hover{
            cursor: pointer;
        }
        td{
            text-align: center;
        }
    </style>
@endsection

@section('admin_page_content')
    <h3>Manage my menus and sub-menus</h3>
    <table border="1">
        <tr><th style="display: none">id</th> <th>Delete</th> <th>Menu</th> <th>Sub-menu</th> <th>Save</th> </tr>
        @foreach($menus as $menuItem)
            <tr>
                <td style="display: none">{{$menuItem->id}}</td>
                <td title="Alert !! Just a single click will delete the menu"><span class='cross_row'>x</span></td>
                <td>
                    <input type='text' class='menu' value="{{$menuItem->menu}}" style="height: 27px">
                </td>
                <td title="Don't forget to Save after deleting or creating new">
                    <?php $subMenus=explode("@@-@@", $menuItem->sub_menu); ?>
                    <div class="sub_menu_container">
                        @foreach($subMenus as $subMenu)
                            <input type='text' placeholder="Sub menu name here" class='sub_menu' value="{{$subMenu}}" style="height: 27px"> <span class='cross'>X</span>
                        @endforeach
                    </div>
                    <button type="button" class="add_more btn btn-primary">Create More</button>
                </td>
                <td>
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
            $(this).prev().append("<input type='text' class='sub_menu'> <span class='cross'>X</span>");
        });

        $(document).on('click', '.cross', function () {
            if(confirm("Sure Delete ?")){
                $(this).prev('input').remove();
                $(this).hide();
            }
        });

        $(".cross_row").click(function () {
            if(confirm("Sure Delete ? This cann't be undone")){
                var rowId=$(this).parent().parent().children().eq(0).text();
                $.ajax({
                    url:"/admin/ajax/"+rowId,
                    type:"DELETE",
                    dataType:"text",
                    data:{
                        _token:"<?php echo csrf_token(); ?>",
                        identity:"menu_items"
                    },
                    success:function (response) {
                        console.log(response);
                    }
                });
                $(this).parent().parent().css('background-color', '#a4a2a2');
                $(this).parent().parent().fadeToggle(1500);
            }
        });


        var subMenuItems=[];
        $(".save").click(function () {
            var THIS=$(this);
            var i=0;
            subMenuItems=[];
            var rowId=$(this).parent().parent().children().eq(0).text();
            var rowIndex=$(this).parent().parent().index();
            var menu=$(this).closest('tr').find('td:eq(2)').find('input').val();
            $(this).closest('tr').find('td:eq(3)').find('input').each(function () {
                subMenuItems[i++]=$(this).val();
            });
            console.log(rowId+"--"+rowIndex+"--"+menu);
            console.log(subMenuItems);
            $.ajax({
                url:"/admin/ajax/"+rowId,
                type:"PUT",
                dataType:"text",
                data:{
                    _token:"<?php echo csrf_token() ?>",
                    identity:"menuSubmenuUpdate",
                    menuData:menu,
                    subMenuData:JSON.stringify(subMenuItems)
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