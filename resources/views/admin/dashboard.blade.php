@extends('layouts.app')
@section('content')
@include('layouts.include.body_header')

<div class="container-fluid">
    @if ( Session::has('flash_message') )
    <div class="c-alert c-alert--success alert fade show">
        <i class="c-alert__icon fa fa-times-circle"></i> {{ Session::get('flash_message') }}
        <button class="c-close" data-dismiss="alert" type="button">×</button>
    </div>
    @endif
    <form name="timesheet-add" id="addTimesheet" action="{{ route('admin-dashboard') }}" method="post">
        <div class="row">
            <input class="c-input" type="hidden" name="_token" id="_token" value="{{ csrf_token() }}"> 
            <div class="col-xl-4">
                <div class="c-graph-card" data-mh="graph-cards">
                    <div class="c-graph-card__content">
                        <h3 class="c-graph-card__title">Best Staff</h3>
                        <div class="row">
                            <div class="col-4">
                                <select class="c-select staffMonths" id="month" name="month">
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="col-4">

                                <select class="c-select filter staffYears" id="year" name="year">
                                    @for($i=date('Y'); $i<=2050; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>

                            </div>
                            <div class="col-4">
                                <button type="button" class="c-btn c-btn--info findBestStaff"><i class="fa fa-search" aria-hidden="true"></i></button>     
                            </div>
                        </div>
                        <h5 class="c-graph-card__number center staffName" >{{$arrBeststaff[0]->name}}</h5>
                        <h4 class="center" ><b>Staffnumber</b>:<label class="staffnumber">{{ $arrBeststaff[0]->staffnumber }}</label></h4>
                        <h4  class="center"><b class="totalHours">{{ $arrBeststaff[0]->total_houres }}</b>: hours</h4>    
                    </div>
                </div>
            </div>	
            <div class="col-xl-4">
                <div class="c-graph-card" data-mh="graph-cards">
                    <div class="c-graph-card__content">
                        <h3 class="c-graph-card__title">Rest workplace</h3>
                        <div class="row">
                            <div class="col-4">

                                <select class="c-select restMonths" id="month1" name="month1">
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <select class="c-select filter restYears" id="year1" name="year1">
                                    @for($i=date('Y'); $i<=2050; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-4">
                                <button type="button" class="c-btn c-btn--info findBestOfice"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>

                        </div>

                        <h5 class="c-graph-card__number center workplaces" ></h5>
                        <p class="c-graph-card__date center address"></p>
                        <h4 class="center"><b class="workplaceHours center">0</b>: hours</h4>

                    </div>
                    <div class="c-graph-card__chart">
    <!--                     <canvas id="js-chart-earnings" width="300" height="74"></canvas> -->
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="c-progress-card" data-mh="graph-cards">
                    <h3 class="c-progress-card__title">New Information</h3>
                    <div class="row">
                        <div class="col-4">  
                            <input class="c-input" type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <select class="c-select" id="month2" name="month2">
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="c-select filter year" id="year2" name="year2">
                                @for($i=date('Y'); $i<=2050; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="c-btn c-btn--info"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </div>

                    <div class="c-progress-card__item">
                        <div class="c-progress-card__labels">Information 1</div>
                        <button class="c-btn c-btn--success u-float-right">View</button>
                    </div><!-- // .c-progress-card__item -->

                    <div class="c-progress-card__item">
                        <div class="c-progress-card__labels">Information 2</div>
                        <button class="c-btn c-btn--success u-float-right">View</button>
                    </div><!-- // .c-progress-card__item -->

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4">
                <div class="c-graph-card" data-mh="graph-cards">
                    <div class="c-graph-card__content">
                        <h3 class="c-graph-card__title">Information</h3>
                        <div class="row">
                            <div class="col u-mb-medium">
                                <select class="c-select" name="informationWorkplace" id="informationWorkplace">
                                    <option>Select Information</option>
                                    @foreach($getWorkPlace as $val => $row)
                                    <option value="{{ $val }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col u-mb-medium">
                                <select class="c-select" id="month3" name="month3">
                                    <option value="">Select Month</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col u-mb-medium">
                                <select class="c-select filter year" id="year3" name="year3">
                                    <option value="">Select Year</option>
                                    @for($i=date('Y'); $i<=2050; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col u-mb-medium">
                                <div class="c-btn-group">
                                    <div class="col-4">
                                        <a class="c-btn c-btn--success" href="javascript:;">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a class="c-btn c-btn--success" href="javascript:;">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a class="c-btn c-btn--success" href="javascript:;">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="c-graph-card" data-mh="graph-cards">
                    <div class="c-graph-card__content">
                        <h3 class="c-graph-card__title">Workplaces</h3>
                        <div class="row">
                            <div class="col u-mb-medium">
                                <select class="c-select" name="workplaceName" id="workplaceName">
                                    @foreach($getWorkPlace as $val => $row)
                                    <option value="{{ $val }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col u-mb-medium">
                                <select class="c-select" id="workplaceMonth" name="workplaceMonth">
                                    <option value="">Select Month</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col u-mb-medium">
                                <select class="c-select filter workplaceYear" id="workplaceYear" name="workplaceYear">
                                    <option value="">Select Year</option>
                                    @for($i=date('Y'); $i<=2050; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col u-mb-medium">
                                <div class="c-btn-group">
                                    <div class="col-4">
                                        <a data-toggle="modal" data-target="#workPlaceList" class="c-btn c-btn--success getWorkPlaceData" href="javascript:;">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a class="c-btn c-btn--success printDiv" href="javascript:;">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a class="c-btn c-btn--success" href="javascript:;">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="c-graph-card" data-mh="graph-cards">
                    <div class="c-graph-card__content">
                        <h3 class="c-graph-card__title">Staff</h3>
                        <div class="row">
                            <div class="col u-mb-medium">
                                <!--<label class="c-field__label" for="select1">Workplaces Select</label>-->
                                <!-- Select2 jquery plugin is used -->
                                <select class="c-select" id="select5">
                                    <option>Select Staff</option>
                                    <option>Ahemdabad</option>
                                    <option>Gandhinagar</option>
                                    <option>Baroda</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col u-mb-medium">
                                <select class="c-select" id="month5" name="month5">
                                    <option value="">Select Month</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col u-mb-medium">
                                <select class="c-select filter year" id="year5" name="year5">
                                    <option value="">Select Year</option>
                                    @for($i=date('Y'); $i<=2050; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col u-mb-medium">
                                <div class="c-btn-group">
                                    <div class="col-4">
                                        <a class="c-btn c-btn--success" href="javascript:;">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a class="c-btn c-btn--success" href="javascript:;">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a class="c-btn c-btn--success" href="javascript:;">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
    <div class="c-modal c-modal--huge modal fade" id="workPlaceList" tabindex="-1" role="dialog" aria-labelledby="workPlaceList">
        <div class="c-modal__dialog modal-dialog" role="document">
            <div class="c-modal__content modal-content">
                <div class="c-modal__header">
                    <h3 class="c-modal__title">Workplaces List ( <b class="wpname"></b>)</h3>
                    <span class="c-modal__close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </span>
                </div>
                <div class="c-modal__body">
                </div>
                <!--                <footer class="c-modal__footer u-justify-center">
                                    <a class="c-btn c-btn--green" href="#">Start your free trial</a>
                                </footer>-->
            </div>
        </div>
    </div>
    <div id='DivIdToPrint' style="display: none;">
        <div class="c-modal__dialog modal-dialog" role="document">
            <div class="c-modal__content modal-content">
                <div class="c-modal__header">
                    <h3 class="c-modal__title">Workplaces List ( <b class="wpname"></b>)</h3>
                    <span class="c-modal__close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </span>
                </div>
                <div class="c-modal__body">
                </div>
            </div>
        </div>
    </div>

</div><!-- // .container -->
<style type="text/css">
    .success {
        opacity: 1;
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #ebccd1;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .closebtn {
        padding-left: 15px;
        color: #000;
        font-weight: bold;
        float: right;
        font-size: 20px;
        line-height: 18px;
        cursor: pointer;
        transition: 0.3s;
    }
    .c-graph-card__number {
        font-size: 1.6rem !important;
    }
    .center {
        text-align: center !important;
    }
</style>
<script>
    $(document).ready(function() {
        $(".closebtn").click(function() {
            $(".success").hide();
        });
    });
</script>
@endsection
