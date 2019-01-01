<meta name="viewport" content="width=device-width, initial-scale=1">

@extends('layouts.dashboard')

@push('css')
    <style>

        .hover {
            border: 2px transparent solid;
        }

        .hover:hover {
            border: 2px solid #94c6e1;
        }

        input.hover {
            padding-right: 0px;
        }

        .table-cell-div {
            padding-left: 0px;
            padding-right: 0px;
        }

        .checkbox-special {
            padding-right: 5px;
        }

        div.total {
            text-align: right;
        }

        header {
            padding: 5px 15px !important;
        }

        /*.form-group {
            float: left;
            margin-bottom: 0px !important;
        }*/
        .table-cell-div {
            padding: 0px 15px;
        }

        @media screen and (max-width: 959px) {
            .test {
                width: 100%;
                float: left !important;
                clear: none !important;
            }
            /*.form-group {
                float: none;
                width: 100% !important;
            }*/

        }

        pre {
            background-color: inherit;
            border: none;
        }

        .paragraph-content-row textarea {
            width: 100%;
        }
    </style>
@endpush

@section('header')
    <header>
        <div class="table-div">
            <div class="table-cell-div" style="width: 20%">
                <label>Student id</label>&nbsp;<input id="" type="text" readonly="readonly" name="" value="2" class="form-control col-total">
            </div>
            <div class="table-cell-div"  style="width: 60%">
                <h3 style="margin:0px; padding:0px;">Manuel Fajardo</h3>
            </div>
            <div class="table-cell-div"  style="width: 20%">
                <div class="pull-right">
                    <a href="{{route('session_detail') . "?type=session&id=" . $datas['session_id']}}" class="btn btn-primary">Back to Session</a>
                </div>
            </div>
        </div>
    </header>
@stop

@section('content')
    <form action="" method="post" style="max-width: 1024px; margin: 0px auto;">
        <div class="text-center">
            @if (Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <input type="text" name="" value="{{ $datas['title'] }}" class="form-control col-total" style="width: 250px !important; margin: 10px auto;" />
            @else
                <input type="text" name="" value="{{ $datas['title'] }}" class="form-control col-total" style="width: 250px !important; margin: 10px auto;" readonly/>
            @endif
            <input type="text" name="" value="{{ $datas['count_letter'] }}" class="form-control col-total pull-right" readonly="readonly" />
        </div>
        <br/>
        
        <div class="table-div">
            <div class="table-cell-div text-center"  style="width: 20%; vertical-align: top;">
                <br/><br/><br/><br/>
                <label>essay</label>
            </div>
            <div class="table-cell-div" style="width: 80%;">
                @if (Auth::user()->isAdmin() || Auth::user()->isTeacher())
                    <textarea class="form-control" style="min-height: 750px;">{{ $datas['content'] }}</textarea>
                @else
                    <textarea readonly class="form-control" style="min-height: 750px;">{{ $datas['content'] }}</textarea>
                @endif
            </div>
        </div>

    </form>
@stop

@push('body_js')
@endpush