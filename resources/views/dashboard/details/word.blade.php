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
            <div class="table-cell-div text-center"  style="width: 33.3333%">
                <a href="{{route('session_dashboard')}}" class="btn btn-primary">Dashboard</a>
            </div>
            <div class="table-cell-div"  style="width: 33.3333%">
                <div class="pull-right">
                    <label>Word Value</label>
                    <input id="totalHeader" type="text" readonly="" name="" value="{{ $datas['total'] }}" class="form-control col-total">
                </div>
            </div>
        </div>
    </header>
@stop

@section('content')
    <h1 class="text-center"><strong>Word Workshop</strong></h1>
    <form action="{{ route('word_detail') }}" method="post" style="max-width: 767px; margin: 0px auto;">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="id" value="{{ $datas['id'] }}">
        <div class="table-div">
            <label class="table-cell-div text-right" style="width: 25%">word</label>
            <div class="table-cell-div" style="width: 65%">
                @if (Auth::user()->isAdmin() || Auth::user()->isTeacher() || Auth::user()->canEditWord($datas['id']))
                    <input id="word" type="text" name="word" value="{{ $datas['content'] }}" class="form-control" />
                @else
                    <input id="word" type="text" name="word" value="{{ $datas['content'] }}" class="form-control" readonly/>
                @endif
            </div>
            <div class="table-cell-div" style="width: 10%">
                <input id="countWord" type="text" name="" readonly="readonly" value="{{ $datas['count_letter'] }}" class="form-control" />
            </div>
        </div>
        <br/>
        <div class="table-div">
            <label class="table-cell-div text-right" style="width: 25%">synonym</label>
            <div class="table-cell-div" style="width: 65%">
                @if (Auth::user()->isAdmin() || Auth::user()->isTeacher() || Auth::user()->canEditWord($datas['id']))
                    <input id="synonym" type="text" name="synonym" value="{{ $datas['synonym'] }}" class="form-control" />
                @else
                    <input id="synonym" type="text" name="synonym" value="{{ $datas['synonym'] }}" class="form-control" readonly/>
                @endif

            </div>
            <div class="table-cell-div" style="width: 10%">
                <input id="countSynonym" type="text" name="" readonly="readonly" value="{{ $datas['count_synonym'] }}" class="form-control" />
            </div>
        </div>
        <br/>
        <div class="table-div">
            <label class="table-cell-div text-right" style="width: 25%">antonym</label>
            <div class="table-cell-div" style="width: 65%">
                @if (Auth::user()->isAdmin() || Auth::user()->isTeacher() || Auth::user()->canEditWord($datas['id']))
                    <input id="antonym" type="text" name="antonym" value="{{ $datas['antonym'] }}" class="form-control" />
                @else
                    <input id="antonym" type="text" name="antonym" value="{{ $datas['antonym'] }}" class="form-control" readonly/>
                @endif
            </div>
            <div class="table-cell-div" style="width: 10%">
                <input id="countAntonym" type="text" name="" readonly="readonly" value="{{ $datas['count_antonym'] }}" class="form-control" />
            </div>
        </div>
        <br/>
        <div class="table-div">
            <label class="table-cell-div text-right" style="width: 25%">suffix</label>
            <div class="table-cell-div" style="width: 65%">
                @if (Auth::user()->isAdmin() || Auth::user()->isTeacher() || Auth::user()->canEditWord($datas['id']))
                    <input id="suffix" type="text" name="suffix" value="{{ $datas['suffix'] }}" class="form-control" />
                @else
                    <input id="suffix" type="text" name="suffix" value="{{ $datas['suffix'] }}" class="form-control" readonly/>
                @endif
            </div>
            <div class="table-cell-div" style="width: 10%">
                <input id="countSuffix" type="text" name="" readonly="readonly" value="{{ $datas['count_suffix'] }}" class="form-control" />
            </div>
        </div>
        <br/>
        <div class="table-div">
            <label class="table-cell-div text-right" style="width: 25%">prefix</label>
            <div class="table-cell-div" style="width: 65%">
                @if (Auth::user()->isAdmin() || Auth::user()->isTeacher() || Auth::user()->canEditWord($datas['id']))
                    <input id="prefix" type="text" name="prefix" value="{{ $datas['prefix'] }}" class="form-control" />
                @else
                    <input id="prefix" type="text" name="prefix" value="{{ $datas['prefix'] }}" class="form-control" readonly/>
                @endif
            </div>
            <div class="table-cell-div" style="width: 10%">
                <input id="countPrefix" type="text" name="" readonly="readonly" value="{{ $datas['count_prefix'] }}" class="form-control" />
            </div>
        </div>
        <br/>
        <div class="table-div">
            <label class="table-cell-div text-right" style="width: 25%">Word Type</label>
            <div class="table-cell-div" style="width: 65%">
                @if (Auth::user()->isAdmin() || Auth::user()->isTeacher() || Auth::user()->canEditWord($datas['id']))
                    <input id="wordtype" type="text" name="wordtype" value="{{ $datas['word_type'] }}" class="form-control" />
                @else
                    <input id="wordtype" type="text" name="wordtype" value="{{ $datas['word_type'] }}" class="form-control" readonly/>
                @endif
            </div>
            <div class="table-cell-div" style="width: 10%">
                <input id="countWordType" type="text" name="" readonly="readonly" value="{{ $datas['count_word_type'] }}" class="form-control" />
            </div>
        </div>
        <br/>
        <div class="table-div">
            <label class="table-cell-div text-right" style="width: 25%">Definition</label>
            <div class="table-cell-div" style="width: 65%">
                @if (Auth::user()->isAdmin() || Auth::user()->isTeacher() || Auth::user()->canEditWord($datas['id']))
                    <textarea id="def" name="def" class="form-control">{{ $datas['definition'] }}</textarea>
                @else
                    <textarea readonly id="def" name="def" class="form-control">{{ $datas['definition'] }}</textarea>
                @endif
            </div>
            <div class="table-cell-div" style="width: 10%">
                <input id="countDef" type="text" name="" readonly="readonly" value="{{ $datas['count_definition'] }}" class="form-control" />
            </div>
        </div>
        <br/>
        <div class="table-div">
            <label class="table-cell-div text-right" style="width: 90%">Total</label>
            <div class="table-cell-div" style="width: 10%">
                <input id="total" type="text" name="" readonly="readonly" value="{{ $datas['total'] }}" class="form-control" />
            </div>
        </div>
        <br/>
        <div class="text-center">
            <input type="submit" class="btn btn-primary" value="Update" />
        </div>
        <br/>
        <div class="text-center">
            <a href="{{route('session_detail') . "?type=session&id=" . $datas['session_id']}}" class="btn btn-primary">Back to Session</a>
        </div>
    </form>
@stop

@push('body_js')
    <script>
        $('#word').keyup(function () {
            var s = $('#word').val();
            document.getElementById("countWord").value = s.split(' ').join('').length;
        });

        $('#synonym').keyup(function () {
            var s = $('#synonym').val();
            document.getElementById("countSynonym").value = s.split(' ').join('').length;
        });

        $('#antonym').keyup(function () {
            var s = $('#antonym').val();
            document.getElementById("countAntonym").value = s.split(' ').join('').length;
        });

        $('#suffix').keyup(function () {
            var s = $('#suffix').val();
            document.getElementById("countSuffix").value = s.split(' ').join('').length;
        });

        $('#prefix').keyup(function () {
            var s = $('#prefix').val();
            document.getElementById("countPrefix").value = s.split(' ').join('').length;
        });

        $('#wordtype').keyup(function () {
            var s = $('#wordtype').val();
            document.getElementById("countWordType").value = s.split(' ').join('').length;
        });

        $('#def').keyup(function () {
            var s = $('#def').val();
            document.getElementById("countDef").value = s.split(' ').join('').length;
        });

        $(document).ready(function () {
            $('#word, #synonym, #antonym, #suffix, #prefix, #wordtype, #def').trigger('blur');
        });

        $('#word, #synonym, #antonym, #suffix, #prefix, #wordtype, #def').blur(function () {
            var word = document.getElementById("countWord").value;
            var synonym = document.getElementById("countSynonym").value;
            var antonym = document.getElementById("countAntonym").value;
            var suffix = document.getElementById("countSuffix").value;
            var prefix = document.getElementById("countPrefix").value;
            var wordtype = document.getElementById("countWordType").value;
            var def = document.getElementById("countDef").value;

            var countWord = parseInt(word || 0);
            var countSynonym = parseInt(synonym || 0);
            var countAntonym = parseInt(antonym || 0);
            var countSuffix = parseInt(suffix || 0);
            var countPrefix = parseInt(prefix || 0);
            var countWordType = parseInt(wordtype || 0);
            var countDef = parseInt(def || 0);

            var total = countWord + countSynonym + countAntonym + countSuffix + countPrefix + countWordType + countDef;
            $('#total').val(total);
            $('#totalHeader').val(total);
        });

    </script>
@endpush