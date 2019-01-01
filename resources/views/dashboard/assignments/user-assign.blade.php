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
                <h2>{{ Auth::user()->name }}'s Assignments</h2>
            </div>
            <div class="col-md-1" style="margin-top: 20px">
                <a href="{{route('home')}}" class="btn btn-primary">Home</a>
            </div>
        </div>
    </header>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="static-height-400">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Assignment Name</th>
                        <th>Group</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $groups = Auth::user()->allGroups;
                    @endphp
                    @if (!empty($groups))
                        @foreach($groups as $group)
                            @if ($group->pivot->is_confirmed == 1)
                                @php
                                    $assignments = $group->allAssignments;
                                @endphp
                                @if (!empty($assignments))
                                    @foreach($assignments as $assignment)
                                        <tr>
                                            <td>{{$assignment->name}}</td>
                                            <td>{{$group->name}}</td>
                                            <td>
                                                <a href="{{ action('SessionController@showSessions') . "?assignment-id=$assignment->id" }}" class="btn btn-success">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop