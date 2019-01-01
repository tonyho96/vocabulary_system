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
            <div class="table-cell-div" style="width: 33.3333%">
                <input id="" type="text" readonly="readonly" name="" value="1/9/2018" class="form-control col-total" style="width:150px !important;">
                <input id="" type="text" readonly="readonly" name="" value="2" class="form-control col-total">
            </div>
            <div class="table-cell-div text-center"  style="width: 33.3333%">
                <a href="{{route('session_detail') . "?type=session&id=" . $datas['session_id']}}" class="btn btn-primary">Back to Session</a>
            </div>
            <div class="table-cell-div"  style="width: 33.3333%">
                <div class="pull-right">
                    <input id="" type="text" readonly="" name="" value="32" class="form-control col-total">
                </div>
            </div>
        </div>
    </header>
@stop

@section('content')
    <form action="" method="post" style="max-width: 1024px; margin: 0px auto;">
        <div class="table-div"">
            <div class="table-cell-div">
                <div class="table-div">
                    <label class="table-cell-div text-right" style="width: 15%">topic</label>
                    <div class="table-cell-div" style="width: 85%">
                        @if (Auth::user()->isAdmin() || Auth::user()->isTeacher())
                        <input type="text" name="" value="{{ $datas['title'] }}" class="form-control" />
                        @else
                        <input type="text" name="" value="{{ $datas['title'] }}" class="form-control" readonly/>
                        @endif
                    </div>
                </div>
            </div>
            <div class="table-cell-div">
                <div class="pull-right">
                    <label>id</label>&nbsp;<input type="text" name="" readonly="readonly" value="{{ $datas['id'] }}" class="form-control col-total" />
                </div>
            </div>
        </div>
        <br/>
        @if (Auth::user()->isAdmin() || Auth::user()->isTeacher())
            <textarea class="form-control" style="min-height: 300px;">{{ $datas['content'] }}</textarea>
        @else
            <textarea readonly class="form-control" style="min-height: 300px;">{{ $datas['content'] }}</textarea>
        @endif

    </form>
@stop

@push('body_js')
@endpush