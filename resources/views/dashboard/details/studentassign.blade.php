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
                <label>User ID</label>&nbsp; <input id="totalSession" type="text" readonly="readonly" name="" value="{{ Auth::user()->id }}" class="form-control col-total">
            </div>
            <div class="table-cell-div"  style="width: 33.3333%">
            </div>
        </div>
    </header>
@stop

@section('content')
    <h1 class="text-center"><strong>Assignment detail</strong></h1>

    <div class="table-div">
        <label class="table-cell-div text-right" style="width: 25%">Assignment name</label>
        <div class="table-cell-div" style="width: 65%">
          <textarea rows="1" cols="100" style="border-radius: 4px;resize: none;" readonly="true">{{$assignment->name}}</textarea>
        </div>
        <div class="table-cell-div" style="width: 10%">
        </div>
      </div><br/>

    <div class="table-div">
        <label class="table-cell-div text-right" style="width: 25%">Instruction</label>
        <div class="table-cell-div" style="width: 65%">
          <textarea rows="4" cols="100" style="border-radius: 4px;resize: none;" readonly="true">{{$assignment->instructions}}</textarea>
        </div>

        <div class="table-cell-div" style="width: 10%">
        </div>
    </div><br/>

    <div class="text-center">
       <a href="{{route('home')}}" class="btn btn-primary" style="margin-bottom: 30%;">Back to home</a>
    </div>

@stop
