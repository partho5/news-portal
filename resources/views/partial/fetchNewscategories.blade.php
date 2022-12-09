@foreach($menus as $menuItem)
<?php $subMenu=explode("@@-@@", $menuItem->sub_menu); ?>
@if(sizeof($subMenu)>1)
@foreach($subMenu as $sub)
<span style="padding-right: 20px; border: 1px solid #30aa19; background-color: #d6da7f" class="categories">
                            {!! Form::radio('news_category', $sub) !!} {{$sub}}
                        </span>
@endforeach
@else
<span style="padding-right: 20px; border: 1px solid #30aa19; background-color: #d6da7f" class="categories">
                        {!! Form::radio('news_category', $menuItem->menu) !!} {{$menuItem->menu}}
                    </span>
@endif
@endforeach