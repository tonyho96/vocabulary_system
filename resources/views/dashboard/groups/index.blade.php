@extends('layouts.management')
{{--@section('header')--}}
    {{--<header>--}}
        {{--<div class="row" style="text-align: center">--}}
            {{--<h2 style="margin-top: 10px">Management</h2>--}}
        {{--</div>--}}
    {{--</header>--}}
{{--@endsection--}}
@section('content')
    <div class="box  box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Groups
                @can('is_admin')
                    <a href="{{ route('groups.create') }}"><input value="{{ trans('forms.create') }}" type="button" class="btn btn-success"></a>
                @endcan
            </h3>
        </div>
        <div class="box-body">
            @include('layouts.notice_message')
            <table class="table">
                <thead>
                <tr>
                    <th>{{ trans('groups.name') }}</th>
                    <th>{{ trans('groups.description') }}</th>
                    <th>{{ trans('groups.author') }}</th>
                    <th>{{ trans('forms.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    @if (Auth::user()->role == config('user.role.admin') || Auth::user()->id == $group->author_user_id)
                    <tr>
                        <td>{{$group->name}}</td>
                        <td>{{$group->description}}</td>
                        <td>{{@$group->author->name}}</td>
                        <td>
                            @can('is_admin')
                                <a href="{{ action('GroupController@show', $group->id) }}"><input value="{{ trans('forms.view') }}" type="button" class="btn btn-default"></a>
                                @if(Auth::user()->isAdmin() || (Auth::user()->isTeacher() && $group->author_user_id == Auth::user()->id))
                                    <a href="{{route('groups.edit', $group->id)}}"><input value="Edit" type="button" class="btn btn-primary"></a>
                                    {!! Form::open(['action' => ['GroupController@destroy', $group->id],
                                                                 'style' => 'display: inline',
                                                                 'method' => 'DELETE',
                                                                 'data-confirm-message' => trans('labels.confirm_delete'),
                                                                 'class' => 'inline',
                                                                 ]) !!}
                                    {!! Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-danger', 'onClick' => 'return window.confirm("Are you sure?")']) !!}
                                    {!! Form::close() !!}
                                @endif
                            @endcan
                            @if(Auth::user()->isStudent())
                                @if ($inGroup = Auth::user()->isInGroup($group->id))
                                    @if ($inGroup->is_confirmed == 0)
                                        Pending
                                    @else
                                        Joined
                                    @endif
                                @else
                                    {!! Form::open(['action' => ['GroupController@askToJoinGroup', $group->id],
                                                             'style' => 'display: inline',
                                                             'method' => 'POST',
                                                             'onsubmit' => 'return confirmForm(this);',
                                                             'data-confirm-message' => trans('labels.confirm_delete'),
                                                             'class' => 'inline',
                                                             ]) !!}
                                    {!! Form::button(trans('groups.ask_to_join'), ['type' => 'submit', 'class' => 'btn btn-primary', 'onClick' => 'return window.confirm("Are you sure?")']) !!}
                                    {!! Form::close() !!}
                                @endif
                            @endif
                        </td>
                    </tr>
                    @endif
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@stop