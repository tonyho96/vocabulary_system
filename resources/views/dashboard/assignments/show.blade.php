@extends('layouts.management')
@section('header')
    <header>
        <div class="row" style="text-align: center">
            <h2 style="margin-top: 10px">Management</h2>
        </div>
    </header>
@endsection
@section('content')
    <div class="box  box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Assignment detail</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            {!! Form::open(['method' => 'GET', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group required">
                    {!! Form::label('name', 'Name', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('name', $assignment->name, ['class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>

                <div class="form-group required">
                    {!! Form::label('Instructions', 'Instructions', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::textarea('instructions', $assignment->instructions, ['class' => 'form-control', 'readonly','size' => '1x5']) !!}
                    </div>
                </div>

                @if (Auth::user()->role == config('user.role.admin') || Auth::user()->role == config('user.role.teacher'))
                    <div class="form-group required">
                        {!! Form::label('update_status', 'Status', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('update_status', $assignment->update_status, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>
                @endif

                {{--@if($assignment->update_status == config("string.status.open"))--}}
                {{--<div class="form-group required">--}}
                    {{--{!! Form::label('groups', 'Groups', ['class' => 'col-sm-2 control-label']) !!}--}}
                    {{--<div class="col-sm-8">--}}
                        {{--@if (Auth::user()->isAdmin())--}}
                            {{--<div class=" row col-sm-11">--}}
                                {{--<select id="group-id-list" class="form-control">--}}
                                    {{--@foreach(\App\Models\Group::all() as $group)--}}
                                        {{--<option data-group-id="{{ $group->id }}" value="{{ $group->id }}">{{ $group->name }}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            {{--<button type="button" id="add-group-btn" class="btn btn-success"><i class="fa fa-plus"></i></button>--}}
                        {{--@elseif (Auth::user()->isTeacher())--}}
                            {{--<div class=" row col-sm-11">--}}
                                {{--<select id="group-id-list" class="form-control">--}}
                                    {{--@foreach(\App\Models\Group::all()->where('author_user_id', Auth::user()->id) as $group)--}}
                                        {{--<option data-group-id="{{ $group->id }}" value="{{ $group->id }}">{{ $group->name }}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            {{--<button type="button" id="add-group-btn" class="btn btn-success"><i class="fa fa-plus"></i></button>--}}
                        {{--@endif--}}
                        {{--<table class="table">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th>Name</th>--}}
                                {{--<th>Description</th>--}}
                                {{--<th>Author User ID</th>--}}
                                {{--<th>Enroll Code</th>--}}
                                {{--<th>Action</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody id="group-list">--}}
                            {{--@foreach($assignment->allGroups as $group)--}}
                                {{--<tr data-group-id="{{ $group->id }}">--}}
                                    {{--<td>{{ $group->name }}</td>--}}
                                    {{--<td>{{ $group->description }}</td>--}}
                                    {{--<td>{{ $group->author_user_id }}</td>--}}
                                    {{--<td>{{ $group->enroll_code }}</td>--}}
                                    {{--<td>--}}
                                        {{--<a class="btn btn-info" href="{{ action('GroupController@show', $group->id) }}"><i class="fa fa-eye"></i></a>--}}
                                        {{--<button type="button" class="remove-group-btn btn btn-danger"><i class="fa fa-remove"></i></button>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--@endif--}}
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="{{action('AssignmentController@index')}}" class="btn btn-default">Back</a>
            </div>
            <!-- /.box-footer -->
            {!! Form::close() !!}
        </div>
    </div>
@stop

{{--@push('body_js')--}}
    {{--<script>--}}
        {{--var xcrfs = '{{ csrf_token() }}';--}}

        {{--function getGroupIds() {--}}
            {{--var res = [];--}}
            {{--$('#group-list tr').each(function () {--}}
                {{--res.push($(this).data('group-id'));--}}
            {{--});--}}

            {{--return res;--}}
        {{--}--}}

        {{--function updateGroupSelectList() {--}}
            {{--var groupIds = getGroupIds();--}}

            {{--$('#group-id-list option').each(function () {--}}
                {{--var groupId = $(this).data('group-id');--}}
                {{--if (groupIds.includes(groupId)) {--}}
                    {{--$(this).attr('disabled', 'disabled');--}}
                {{--}--}}
                {{--else {--}}
                    {{--$(this).removeAttr('disabled');--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}

        {{--function renderGroupRow(groupObj) {--}}
            {{--var html = '<tr data-group-id="'+ groupObj.id +'">' +--}}
                {{--'<td>'+ groupObj.name +'</td>' +--}}
                {{--'<td>'+ groupObj.description +'</td>' +--}}
                {{--'<td>'+ groupObj.author_user_id +'</td>' +--}}
                {{--'<td>'+ groupObj.enroll_code +'</td>' +--}}
                {{--'<td>' +--}}
                {{--'   <a class="btn btn-info" href="/groups/'+ groupObj.id +'"><i class="fa fa-eye"></i></a>' +--}}
                {{--'   <button type="button" class="remove-group-btn btn btn-danger"><i class="fa fa-remove"></i></button>' +--}}
                {{--'</td>' +--}}
                {{--'</tr>';--}}
            {{--return html;--}}
        {{--}--}}

        {{--$('#add-group-btn').click(function() {--}}
            {{--var url = '{{ action('AssignmentController@ajaxAddGroup', $assignment->id) }}';--}}
            {{--var groupId = $('#group-id-list').val();--}}

            {{--var groupIds = getGroupIds();--}}
            {{--if (!groupId || groupIds.includes(groupId)) {--}}
                {{--return;--}}
            {{--}--}}

            {{--$.post(url, {group_id: groupId, _token: xcrfs}, function(response) {--}}
                {{--var html = renderGroupRow(response.group);--}}
                {{--$('#group-list').append(html);--}}
                {{--updateGroupSelectList();--}}
            {{--}, 'json');--}}
        {{--});--}}

        {{--$('body').on('click', '.remove-group-btn', function() {--}}
            {{--var thisObj = $(this);--}}

            {{--thisObj.attr('disabled', 'disabled');--}}
            {{--var groupId = thisObj.closest('tr').data('group-id');--}}

            {{--var url = '{{ action('AssignmentController@ajaxRemoveGroup', $assignment->id) }}';--}}

            {{--$.post(url, {group_id: groupId, _token: xcrfs}, function() {--}}
                {{--thisObj.fadeOut(function() {--}}
                    {{--thisObj.closest('tr').remove();--}}
                    {{--updateGroupSelectList();--}}
                {{--});--}}
            {{--});--}}
        {{--});--}}

        {{--$(document).ready(function() {--}}
            {{--updateGroupSelectList();--}}
        {{--})--}}
    {{--</script>--}}
{{--@endpush--}}