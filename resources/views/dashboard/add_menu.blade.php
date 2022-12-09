@extends('dashboard.index')



@section('admin_page_content')

    <div id="existing">
        @if(sizeof($menus)>0)
            <h3>Existing Menu item(s) :</h3>
        @endif
        <div>
            @foreach($menus as $menuItem)
                <span style="background-color: #7aad57; border: 1px solid #aa528b;padding: 2px;">{{$menuItem->menu}}</span>
            @endforeach
        </div>
    </div>

    <div id="heading">
        <h3 id="heading">Add new menu item</h3>
        <p>You can add/edit/delete menu any time you like</p>
    </div>

    <p id="wantTo">I wnat to add &nbsp; <input type="number" id="numOfMenu" max="20" min="1" value="1"> menu(s) this time (Enter a number between 1 and 20)</p>
    <div id="menuItemContainer"></div>
    <button type="button" id="nextBtn" class="btn btn-primary">Next</button>
    <button style="display: none" type="button" id="cancel" class="btn btn-primary">Cancel</button>
    <span style='color: #8c207d; font-size: 17px; display: none;' id="suggestion1">You can edit or add sub-menu from <a href='/admin/edit_menu'>Edit Menu</a></span>



    <script src="/dashboard/js/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var partial="";
            var numOfMenu;
            $("#nextBtn").on('click', function () {
                numOfMenu=$("#numOfMenu").val();
                var btnText=$("#nextBtn").text();
                if (btnText=="Next" && numOfMenu && numOfMenu>=1 && numOfMenu<=10){
                    //dynamically add input fields for creating menu items
                    for (var i=0 ; i<numOfMenu ; i++){
                        partial+="<span>Menu Item "+(i+1)+"</span> <input type='text' class='menuItem' required><br>";
                    }
                    $("#menuItemContainer").append(partial);
                    $("#wantTo").hide();
                    $("#nextBtn").text("Save");
                    $("#cancel").show();
                }
                else {
                    //if button text is Save
                    //do ajax call to save menu items
                    var allItems=[];
                    var i=0;
                    $(".menuItem").each(function () {
                        allItems[i++]=$(this).val();
                    });
                    var data=JSON.stringify(allItems);
                    //alert(data);
                    $.ajax({
                        url:"/admin/ajax",
                        type:"post",
                        dataType:"text",
                        data:{
                            _token:"<?php echo csrf_token(); ?>",
                            menuItems:data
                        },
                        success:function (response) {
                            //console.log(response);
                            if(response=="success"){
                                //restore view to default
                                $(this).hide();
                                $("#nextBtn").text("Next");
                                $("#suggestion1").show();
                                //$("#menuItemContainer").html("<div id='successMsg'>"+(numOfMenu)+" menu items saved</div>");
                                $("#menuItemContainer").html("");
                                $("#wantTo").show();
                                $("#cancel").hide();
                                partial="";

                                alert(numOfMenu+" menu item(s) saved");
                            }
                        },
                        error:function (xhr, textStatus) {
                            //console.log(xhr+'\n'+textStatus);
                            alert("Error occured. Try again or contact support");
                        }
                    });
                }
                
                $("#cancel").click(function () {
                    //restore view to default
                    if(confirm("Sure Cancel ?")){
                        $(this).hide();
                        $("#nextBtn").text("Next");
                        $("#menuItemContainer").text("");
                        $("#wantTo").show();
                        partial="";
                    }
                });
            });
        });
    </script>

@endsection