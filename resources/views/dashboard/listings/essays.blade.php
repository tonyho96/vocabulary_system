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

        header {
            padding: 5px 15px !important;
        }

        .table-cell-div {
            padding: 0px 15px;
        }

        @media screen and (max-width: 959px) {
            .test {
                width: 100%;
                float: left !important;
                clear: none !important;
            }
        }

        pre {
            background-color: inherit;
            border: none;
        }
    </style>
@endpush

@section('header')
    <header>
        <div class="row">
            <div class="col-md-4 " style="margin-top: 10px">
                <div class="form-group col-3" style="width: 70%">
                    <h4>{{ Auth::user()->name }}</h4>
                </div>
                <div class="form-group col-3" style="width: 10%">
                    <input type="text" readonly name="" value="{{ Auth::user()->id }}" class="form-control "/>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <h2>{{ Auth::user()->name }}'s Essays</h2>
            </div>
            <div class="col-md-1" style="margin-top: 20px">
                <a href="{{route('home')}}" class="btn btn-primary">Home</a>
            </div>
        </div>
    </header>
@stop

@section('content')
    <?php
        $totalEssayLetter = 0;
        $currentUser = Auth::user();
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="static-height-400">
                <div class="inline-edit-group">
                    <div class="table-div">
                        <div class="table-cell-div" style="width: 5%"></div>
                        <div class="table-cell-div hover" style="width: 5%">id</div>
                        <div class="table-cell-div hover" style="width: 80%">Essay Name</div>
                        <div class="table-cell-div hover" style="width: 10%">Total</div>
                    </div>
                    @foreach($essays as $essay)
                        <?php
                            $totalEssayLetter += $essay->count_letter;
                        ?>
                            <div class="col stripped-row essay-row {{ $currentUser->canEditEssay($essay->id) ? 'inline-row' : '' }}"   data-value="{{ $essay->title }}" data-value2="{{ $essay->content }}" data-id="{{ $essay->id }}" data-session-id="{{ $essay->session_id }}" >
                            <div class="table-div">
                                <div class="table-cell-div" style="width: 5%">
                                    <div class="checkbox-special">
                                        <a href="{{route('session_detail')}}?type=essay&id={{ $essay->id }}"></a>
                                    </div>
                                </div>
                                <div class="table-cell-div hover" style="width: 5%">
                                    {{ $essay->id }}
                                </div>
                                <div class="table-cell-div hover" style="width: 80%">
                                    {{ $essay->content }}
                                </div>
                                <div class="table-cell-div hover" style="width: 10%">
                                    {{ $essay->count_letter }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop