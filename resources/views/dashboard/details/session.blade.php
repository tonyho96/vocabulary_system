@extends('layouts.dashboard')

@section('header')
    <header>
        <div class="row">
            <div class="col-md-1">
                <div class="pull-right">
                    <label>ID</label>&nbsp;
                    <input type="text" id="session_id" readonly="" value="{{ $datas->id }}" class="form-control" style="width: 70%; display: inline">
                </div>
            </div>
            <div class="col-md-3">

            </div>
            <div class="form-group col-md-5">
                <h2 style="margin-top: 0px;">Session</h2>
            </div>
            <div class="form-group col-md-2">
                <input type="text" style="width: 100px;" readonly="" value="{{ date('m-d-Y') }}" class="form-control">
            </div>
            <div class="form-group col-md-1 text-right">
                Total&nbsp;<input type="text" id="totalSession" readonly="readonly" name="totalSession" value="{{ $datas->count_letter }}" class="form-control" style="width: 70%; display: inline;"/>
            </div>
        </div>
    </header>
@stop

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <style>
        .form-group {
            float: left;
            margin-bottom: 0px !important;
        }

        .word-row,
        .sentence-row {
            min-height: 41px;
        }

        .paragraph-row {
            min-height: 72px;
        }

        .sentence-row .table-div {
            height: 23px;
        }

        .paragraph-content-row.table-div {
            min-height: 95px;
        }

        .paragraph-row {
            min-height: 144px;
        }

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

        header {
            padding: 15px;
        }

        .checkbox-special {
            padding-right: 5px;
        }

        div.total {
            text-align: right;
        }
        .table-cell-div .checkbox-special,
        .table-cell-div.total {
            padding: 0px 15px;
        }
        .inline-edit-value,
        .inline-edit-value:focus,
        .inline-edit-value:hover {
            background-color: transparent !important;
            border: 0px !important;
            box-shadow: none !important;
            border-radius: 0px !important;
            padding: 3px 0px !important;
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

@php
    $currentUser = Auth::user();
    $words = $datas->words;
    $sentences = $datas->sentences;
    $paragraphs = $datas->paragraphs;
    $essay = $datas->essay;
@endphp

@section('content')
    <input type="hidden" id=id_session value="{{$datas->id}}">
    <div class="row" style="position: relative;">
        <div class="col-md-12">
            <div class="inline-edit-group">
                <div class="table-div">
                    <div class="table-cell-div" style="width: 10%"></div>
                    <div class="table-cell-div" style="width: 20%; font-weight: bold;">Session Name</div>
                    <div class="table-cell-div" style="width: 20%; font-weight: bold;">Assignment Name</div>
                    <div class="table-cell-div" style="width: 50%; font-weight: bold;"></div>
                    <!-- <div class="table-cell-div" style="width: 50%; font-weight: bold;">Instruction</div> -->
                </div>
                <div class="col word-row stripped-row inline-row">
                    <div class="table-div">
                        <div class="table-cell-div" style="width: 5%">
                            <div class="checkbox-special">
                                <div class="checkbox-special">
                                    @if ($assignment)
                                      @if(Auth::user()->role == config('user.role.admin') || Auth::user()->role == config('user.role.teacher'))

                                            <a href="{{ route('assignments.show', $assignment->id) }}"></a>
                                      @else
                                            <a href="{{ route('student-assign',$assignment->id) }}"></a>
                                      @endif
                                    @else
                                      <a href=""></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="hover table-cell-div inline-edit" style="width: 20%;">
                            @if(Auth::user()->role == config('user.role.admin') || Auth::user()->role == config('user.role.teacher'))
                                <input type="text" id="session-name" placeholder="Name/Task Instruction" value="{{ $datas->name }}">
                            @else
                                <input type="text" placeholder="Name/Task Instruction" readonly value="{{ $datas->name }}">
                            @endif
                        </div>
                        <div class="table-cell-div inline-edit" style="width: 20%;">
                            <input type="text" class="hover" placeholder="This session has not been belong to any assignment yet" value="{{ @$assignment->name }}" readonly="readonly" style="margin-left: 40px">
                        </div>
                        <!--values assignment and instruction name-->
                        <div style="width: 45%; background-color: white;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="position: relative;">
        <div class="col-md-2">
            <h5 class="text-center">Word Bank (<span id="total-word">{{ count($words) }}</span>)</h5>
            <div class="static-height-300">
                <div class="inline-edit-group">
                    <div class="template" style="display: none;">
                        <div class="inline-edit-template">
                            <div class="col word-row stripped-row inline-row">
                                <div class="table-div">
                                    <div class="table-cell-div" style="width: 10%">
                                        <div class="checkbox-special hidden-for-next">
                                            <input type="checkbox" name="" id="checkbox1">
                                            <label for="checkbox1"></label>
                                        </div>
                                    </div>
                                    <div class="hover table-cell-div inline-edit value1" style="width: 70%">
                                    </div>
                                    <div class="hover total table-cell-div" style="width: 20%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="new-row-template">
                            <div class="col word-row stripped-row inline-row"></div>
                        </div>
                    </div>
                    @php
                        $totalWordLetter = 0;
                    @endphp
                    @foreach($words as $word)
                        @php
                            $totalWordLetter += $word->total;
                        @endphp
                        <div class="col word-row stripped-row {{ $currentUser->canEditWord($word->id) ? 'inline-row' : '' }}" data-value="{{ $word->content }}" data-id="{{ $word->id }}" data-session-id="{{ $word->session_id }}" >
                            <div class="table-div">
                                <div class="table-cell-div" style="width: 10%">
                                    <div class="checkbox-special">
                                        <a href="{{route('session_detail')}}?type=word&id={{ $word->id }}"></a>
                                    </div>
                                </div>
                                <div class="hover table-cell-div inline-edit value1" style="width: 70%" data-additional-value="{{ $word->total - $word->count_letter }}">
                                    {{ $word->content }}
                                </div>
                                <input type="hidden" class="countLetter" value="{{ $word->total }}">
                                <div class="hover total table-cell-div" style="width: 20%">
                                    {{ $word->total }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col word-row stripped-row inline-row">
                        <div class="table-div">
                            <div class="table-cell-div" style="width: 10%">
                                <div class="checkbox-special hidden-for-next">
                                    <input type="checkbox" name="" id="checkbox1">
                                    <label for="checkbox1"></label>
                                </div>
                            </div>
                            <div class="hover table-cell-div inline-edit value1" style="width: 70%">
                            </div>
                            <div class="hover total table-cell-div" style="width: 20%">
                            </div>
                        </div>
                    </div>
                    @for($i = 0; $i < 6; $i++)
                        <div class="col word-row stripped-row inline-row"></div>
                    @endfor
                </div>
            </div>
            <div class="pull-right">
                Total&nbsp;<input type="text" id="totalword" readonly="readonly" name="totalword" value="{{ $totalWordLetter }}" class="form-control col-total"/>
            </div>
        </div>

        <div class="col-md-5">
            <h5 class="text-center">Sentence Bank (<span id="total-sentence">{{ count($sentences) }}</span>)</h5>
            <div class="static-height-300">
                <div class="inline-edit-group">
                    <div class="template" style="display: none;">
                        <div class="inline-edit-template">
                            <div class="col sentence-row stripped-row inline-row" data-value="">
                                <div class="table-div">
                                    <div class="hover table-cell-div inline-edit value1" style="width: 94%">
                                    </div>
                                    <div class="hover total table-cell-div" style="width: 6%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="new-row-template">
                            <div class="col sentence-row stripped-row inline-row"></div>
                        </div>
                    </div>
	                <?php
	                $totalSentenceLetter = 0;
	                ?>
                    @foreach($sentences as $sentence)
		                <?php
		                $totalSentenceLetter += $sentence->count_letter;
		                ?>
                        <div class="col stripped-row sentence-row {{ $currentUser->canEditSentence($sentence->id) ? 'inline-row' : '' }}"  data-value="{{ $sentence->content }}" data-id="{{ $sentence->id }}" data-session-id="{{ $sentence->session_id }}" >
                            <div class="table-div">
                                <div class="table-cell-div cell-9 hover inline-edit value1">
                                    {{ $sentence->content }}
                                </div>
                                <div class="table-cell-div cell-1 hover total">
                                    {{ $sentence->count_letter }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col sentence-row stripped-row inline-row" data-value="">
                        <div class="table-div">
                            <div class="hover table-cell-div inline-edit value1" style="width: 94%">
                            </div>
                            <div class="hover total table-cell-div" style="width: 6%">
                            </div>
                        </div>
                    </div>
                    @for($i = 0; $i < 6; $i++)
                        <div class="col sentence-row stripped-row inline-row"></div>
                    @endfor
                </div>
            </div>
            <div class="pull-right">
                Total&nbsp;<input type="text" id="totalsentence" readonly="readonly" name="totalsentence" value="{{ $totalSentenceLetter }}" class="form-control col-total"/>
            </div>
        </div>

        <div class="col-md-5">
            <h5 class="text-center">Paragraph Bank (<span id="total-paragraph">{{ count($paragraphs) }}</span>)</h5>
            <div class="static-height-300">
                <div class="inline-edit-group">
                    <div class="template" style="display: none;">
                        <div class="inline-edit-template">
                            <div class="col paragraph-row stripped-row inline-row">
                                <div class="table-div">
                                    <div class="table-cell-div" style="width: 5%">
                                        <div class="checkbox-special hidden-for-next">
                                            <input type="checkbox" name="" id="checkbox1">
                                            <label for="checkbox1"></label>
                                        </div>
                                    </div>
                                    <div class="hover table-cell-div inline-edit value1 text-center" style="width: 90%">
                                    </div>
                                    <div class="hover total table-cell-div" style="width: 5%">
                                    </div>
                                </div>
                                <div class="paragraph-content-row table-div">
                                    <div class="hover table-cell-div inline-edit value2 text-area" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="new-row-template">
                            <div class="col paragraph-row stripped-row inline-row"></div>
                        </div>
                    </div>
	                <?php
	                $totalParagraphLetter = 0;
	                ?>
                    @foreach($paragraphs as $paragraph)
		                <?php
		                $totalParagraphLetter += $paragraph->count_letter;
		                ?>
                        <div class="col stripped-row paragraph-row {{ $currentUser->canEditParagraph($paragraph->id) ? 'inline-row' : '' }}"  data-value="{{ $paragraph->title }}" data-value2="{{ $paragraph->content }}" data-id="{{ $paragraph->id }}" data-session-id="{{ $paragraph->session_id }}" >
                            <div class="table-div">
                                <div class="checkbox-special">
                                    <a href="{{route('session_detail')}}?type=paragraph&id={{ $paragraph->id }}"></a>
                                </div>
                                <div class="table-cell-div cell-9 hover inline-edit value1">
                                    {{ $paragraph->title }}
                                </div>
                                <div class="table-cell-div cell-1 total hover">
                                    {{ $paragraph->count_letter }}
                                </div>
                            </div>
                            <div class="hover inline-edit value2 text-area paragraph-content-row">
                                <pre>{{ $paragraph->content }}</pre>
                            </div>
                        </div>
                    @endforeach
                    <div class="col paragraph-row stripped-row inline-row">
                        <div class="table-div">
                            <div class="table-cell-div" style="width: 5%">
                                <div class="checkbox-special hidden-for-next">
                                    <input type="checkbox" name="" id="checkbox1">
                                    <label for="checkbox1"></label>
                                </div>
                            </div>
                            <div class="hover table-cell-div inline-edit value1 text-center" style="width: 90%">
                            </div>
                            <div class="hover total table-cell-div" style="width: 5%">
                            </div>
                        </div>
                        <div class="paragraph-content-row table-div">
                            <div class="hover table-cell-div inline-edit value2 text-area" style="width: 100%"></div>
                        </div>
                    </div>
                    @for($i = 0; $i < 6; $i++)
                        <div class="col paragraph-row stripped-row inline-row"></div>
                    @endfor
                </div>
            </div>
            <div class="pull-right">
                Total&nbsp;<input type="text" id="totalparagraphs" readonly="readonly" name="totalparagraphs" value="{{ $totalParagraphLetter }}" class="form-control col-total"/>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="form-group col-md-12">
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher()|| empty($essay) || Auth::user()->canEditEssay(@$essay->id))
                <input id="essay-title" type="text" name="essays" class="form-control" style="display: inline;" value="{{ @$essay->title }}" />
                <a href="{{ route('session_dashboard') }}" id="back" class="btn btn-primary">Back to Dashboard</a>
            @else
                <input id="essay-title" type="text" name="essays" class="form-control" style="display: inline;" value="{{ @$essay->title }}" readonly/>
                <a href="{{ route('listings_sessions') }}" id="back" class="btn btn-primary">Back</a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <br/>
            <div class="static-height-300">
                @if(Auth::user()->isAdmin() || Auth::user()->isTeacher() || empty($essay) || Auth::user()->canEditEssay(@$essay->id))
                    <textarea id="essay-content" class="full-textarea" data-id='' name='essays-content'>{{ @$essay->content }}</textarea>
                @else
                    <textarea id="essay-content" class="full-textarea" data-id='' name='essays-content' readonly>{{ @$essay->content }}</textarea>
                @endif
            </div>
            <div class="pull-right">
                Total&nbsp;<input type="text" id="totalessays" readonly="readonly" name="totalessays" value="{{ @$essay->count_letter }}" class="form-control col-total"/>
            </div>
        </div>
    </div>
@stop

@push('body_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script type="text/javascript" src="{{asset('js/vocabulary_functions.js')}}"></script>
    <script>
        var session_id = '{{$datas->id}}';
        var xcsrf = '{{ csrf_token() }}';

        function updateTotalEssayLetterForOneObject() {
            var title = $('#essay-title').val();
            var content = $('#essay-content').val();
            var countLetter = title.replace(/[^A-Z0-9]/gi, "").length;
            countLetter += content.replace(/[^A-Z0-9]/gi, "").length;

            $('#totalessays').val(countLetter);
            $('#totalessays').trigger('change');
        }

        // update number count
        $('body').on('blur', '.inline-edit-value', function () {
//            var value1 = $(this).closest('.inline-row').data('value') || '';
//            var value2 = $(this).closest('.inline-row').data('value2') || '';
//
//            if ($(this).closest('.inline-edit').hasClass('value1')) {
//                value1 = $(this).val();
//            }
//            else if ($(this).closest('.inline-edit').hasClass('value2')) {
//                value2 = $(this).val();
//            }
//
//            var countLetter = value1.replace(/[^A-Z0-9]/gi, "").length;
//            countLetter += value2.replace(/[^A-Z0-9]/gi, "").length;
//
//            $(this).closest('.inline-row').find('.total').html(countLetter);

            var value1 = $(this).closest('.inline-row').data('value') || '';
            var value2 = $(this).closest('.inline-row').data('value2') || '';

            if ($(this).closest('.inline-edit').hasClass('value1')) {
                value1 = $(this).val();
            }
            else if ($(this).closest('.inline-edit').hasClass('value2')) {
                value2 = $(this).val();
            }

            var currentTotal = $(this).closest('.inline-row').find('.total').text();
            var oldCount = 0;
            var totalLetter = 0;
            if ($(this).closest('.inline-row').find('.countLetter').val()) {
                oldCount = $(this).closest('.inline-row').find('.countLetter').val();
                totalLetter = parseInt(currentTotal) - oldCount
            }

            var value1Length = value1.replace(/[^A-Z0-9]/gi, "").length;
            var value2Length = value2.replace(/[^A-Z0-9]/gi, "").length;

            totalLetter += value1Length + value2Length;

            var additionalValue = $(this).closest('.inline-edit').data('additional-value');
	        if (additionalValue) {
		        totalLetter += additionalValue;
            }

            $(this).closest('.inline-row').find('.total').html(totalLetter);
            $(this).closest('.inline-row').find('.countLetter').val(value1Length + value2Length);
        })

        // update data to db
        $('body').on('blur', '.word-row .inline-edit-value', function () {
            var inlineRow = $(this).closest('.inline-row');
            var value = $(this).val();
            var id = inlineRow.data('id');

            if (id) {
                updateWord(id, value, session_id, xcsrf);
            }
            else {
                createWord(value, session_id, xcsrf, function (response) {
                    inlineRow.data('id', response.data.id);
                    updateTotalWord();
                });
            }
            updateTotalWordLetter();
        });

        // update data to db
        $('body').on('blur', '.sentence-row .inline-edit-value', function () {
            var inlineRow = $(this).closest('.inline-row');
            var value = $(this).val();
            var id = inlineRow.data('id');

            if (id) {
                updateSentence(id, value, session_id, xcsrf);
            }
            else {
                createSentence(value, session_id, xcsrf, function (response) {
                    inlineRow.data('id', response.data.id);
                    updateTotalSentence();
                });
            }
            updateTotalSentenceLetter();
        });

        $('#assign').select2();

        $('body').on('change', '#assign', function () {
	        var assignment_id = $(this).val();
	        var url = '{{ action('SessionController@updateAssign', $datas->id) }}';

	        $.post(url, {assignment_id: assignment_id, _token: xcsrf}, function() {

	        }, 'json');
        });

        // update data to db
        $('body').on('blur', '.paragraph-row .inline-edit-value', function () {
            var inlineRow = $(this).closest('.inline-row');
            var inlineEdit = $(this).closest('.inline-edit');
            var title = content = $(this).val();

            if (inlineEdit.hasClass('value1')) {
                content = inlineRow.data('value2');
            }
            else {
                title = inlineRow.data('value');
            }

            var id = inlineRow.data('id');

            if (id) {
                updateParagraph(id, title, content, session_id, xcsrf);
            }
            else {
                createParagraph(title, content, session_id, xcsrf, function (response) {
                    inlineRow.data('id', response.data.id);
                    updateTotalParagraph();
                });
            }
            updateTotalParagraphLetter();
        });

        // update data to db
        $('body').on('blur', '#essay-title, #essay-content', function () {
            var title = $('#essay-title').val();
            var content = $('#essay-content').val();
            // because 1 session has only one essay, so we don't need to determine it
            updateEssay(title, content, session_id, xcsrf);
            updateTotalEssayLetterForOneObject();
        });

        $('#totalword, #totalsentence, #totalparagraphs, #totalessays').change(function () {
            var totalWorld = parseInt($('#totalword').val()) || 0;
            var totalSentence = parseInt($('#totalsentence').val()) || 0;
            var totalParagraph = parseInt($('#totalparagraphs').val()) || 0;
            var totalEssay = parseInt($('#totalessays').val()) || 0;

            var total = totalWorld + totalSentence + totalParagraph + totalEssay;
            $('#totalSession').val(total);
        });

        // TIMER
        var interval = 1000 * 60 * 1; // where X is your every X minutes
        setInterval(function () {
            $.ajax({
                url: "/timer/create-session",
                type: "GET",
                data: {session_id: session_id},
                success: function (data) {
                }
            });
        }, interval);

        $('#session-name').on('change', function() {
            var name = $(this).val();
            var url = '{{ action('SessionController@ajaxUpdate', $datas->id) }}';
            $.post(
            	url,
                {
                	name: name,
	                _token: xcsrf
                },
                function() {

                }
            )
        });

    </script>
    <script type="text/javascript" src="{{asset('js/inline_edit.js')}}"></script>
@endpush
