@extends('dashboard.index')


@section('admin_page_content')

    <div id="hourly_div" style="border: 2px solid #a8ad25; border-bottom: 1px solid #e25ac9"></div>
    <p style="text-align: center; color: #4dad30; font-size: 20px; border: 2px solid #a8ad25">Visitors at 24 hours</p>

    @columnchart('Population_hour', 'hourly_div')



    <div id="daily_div" style="border: 2px solid #45d5d5; border-bottom: 1px solid #ee6927"></div>
    <p style="text-align: center; color: #ee6927; font-size: 20px; border: 2px solid #228c0f">Visitors at this Month</p>

    @columnchart('Population_daily', 'daily_div')



    <div id="monthly_div" style="border: 2px solid #45d5d5; border-bottom: 1px solid #ee6927"></div>
    <p style="text-align: center; color: #e25ac9; font-size: 20px; border: 2px solid #228c0f">Visitors at this year</p>

    @columnchart('Population_month', 'monthly_div')


    <?php
        //var_dump($data);
    ?>



@endsection