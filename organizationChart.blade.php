@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{{URL::asset('public/assets/css/tree.css')}}">
<style>
    .tree li:last-child::before
    {
        border-radius: 0px;
    }
    .tree li:first-child::after
    {
        border-radius: 0px;
    }
    .tree li a
    {
        border-radius: 0px;
    }
    .tree .submenus a
    {
        display: block;
        max-width: 200px;
        font-size:14px; 
    }
    .tree .submenus a:nth-child(1)
    {
        background: #e63a3a;
        color: white;
        font-size: 16px;
    }
    .menu{
        display: block;
        max-width: 200px;
        font-size:14px;
    }
    span{
        max-width: 150px;
        font-size:12px;
    }

</style>
@stop
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-title">
                    <h3><i class="fa fa-bars"></i>Organization Chart</h3>
                </div>
                @if(Session::has('successalert'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{  Session::get('successalert') }}
                </div>
                @endif
                @if(Session::has('erroralert'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    {{  Session::get('erroralert') }}
                </div>
                @endif
                <div class="col-sm-12">
                    <div class="box box-bordered box-color">
                        <div class="box-title">
                            <h3>
                                <i class="fa fa-bars"></i>Company
                            </h3>
                        </div>
                        <div class="box-content nopadding">
                            <?php echo CommonFunction::SettingTab(Request::path()); ?>
                            <div class="tab-content padding tab-content-inline tab-content-bottom">
                                <div class="tab-pane active">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="box box-bordered box-color">
                                                <div class="box-title">
                                                    <h3>
                                                        <i class="fa fa-th-list"></i>Organization Chart
                                                    </h3>
                                                </div>
                                                <?php
                                                ?>

                                                <div class="col-md-12 tree">

                                                    <ul style="" class="row">
                                                        <li style="position: relative; left: 28%">
                                                            <a href="javascript:void(0)" style="background: #e63a3a;color: white;">
                                                                <h5>
                                                                    @if(!empty($level1))
                                                                    {{ $level1->employee_id.'-'.$level1->first_name }}
                                                                    @if($dep)
                                                                    <br>
                                                                    <span>{{ $dep->fkDivision_id?Common::NameDivision($dep->fkDivision_id):''}}</span><br>
                                                                    <span>{{ $dep->fkDepartment_id?Common::NameDepartment($dep->fkDepartment_id):''}}</span>
                                                                    @endif                                                                    @endif</h5>
                                                            </a>
                                                            <br>
                                                            <?php
                                                            $level2 = Common::getNextLevel($level1->id);
                                                            
                                                            ?>
                                                            @if(!empty($level2))
                                                            <ul>   @foreach($level2 as $l2)  
                                                                <li class="submenus">

                                                                    <a href="javascript:void(0)">{{ $l2->employee_id.'-'.$l2->first_name}}
                                                                        <br>
                                                                        <span>{{ Common::NameDivision($l2->fkDivision_id)}}</span><br>
                                                                        <span>{{ Common::NameDepartment($l2->fkDepartment_id)}}</span>
                                                                    </a>

                                                                    <?php
                                                                    $level3 = Common::getNextLevel($l2->id);
                                                                  // echo "<pre>";
                                                       //    print_r($level3);
                                                       //     echo "</pre>"; ?>
                                                                    @if(!empty($level3))
                                                                    <ul>
                                                                        @foreach($level3 as $l3) 
                                                                        <li class="submenus">
                                                                            <a href="javascript:void(0)">{{ $l3->employee_id.'-'.$l3->first_name}}

                                                                                <br>
                                                                                <span>{{ Common::NameDivision($l2->fkDivision_id)}}</span><br>
                                                                                <span>{{ Common::NameDepartment($l2->fkDepartment_id)}}</span>
                                                                            </a>

                                                                            <?php
                                                                            $level4 = Common::getNextLevel($l3->id);
                                                                    
  // die;     ?>  
                                                                            @if(!empty($level4))
                                                                            <ul>
                                                                                @foreach($level4 as $l4) 
                                                                                <li class="submenus">   
                                                                                    <?php
                                                                                    $level5 = Common::getallLevel($l4->id, 0);
                                                                                    ?> 
                                                                                    <a  class="{{$level5?'menu':''}}" title="{{$level5?'More':''}}" href="javascript:void(0)"> {{$l4->employee_id.'-'. $l4->first_name }}
                                                                                        <br>
                                                                                        <span>{{ Common::NameDivision($l2->fkDivision_id)}}</span><br>
                                                                                        <span>{{ Common::NameDepartment($l2->fkDepartment_id)}}</span>
                                                                                    </a>
                                                                                    @if($level5)
                                                                                    <span class="extra-icon"><i class="fa fa-caret-down"></i> </span>
                                                                                    @endif


                                                                                    @if(!empty($level5))
                                                                                    <div class="extra-branch" style="display: none">
                                                                                        <?php print_r($level5);   ?>
                                                                                    </div>
                                                                                    @endif


                                                                                </li>

                                                                                @endforeach  
                                                                            </ul>
                                                                            @endif

                                                                        </li>@endforeach

                                                                    </ul>
                                                                    @endif

                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                            @endif
                                                        </li>

                                                    </ul>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('script')
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script>
$(".menu").click(function() {
    $(".extra-branch").toggle("slow");
    $(".extra-icon").toggle("slow");
});
</script>
@stop
