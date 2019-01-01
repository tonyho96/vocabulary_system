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

        .form-group {
            float: left;
            margin-bottom: 0px !important;
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
            .form-group {
                float: none;
                width: 100% !important;
            }

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
        <div class="row">
            <div class="col-md-4 " style="margin-top: 10px">
                <div class="form-group col-3" style="width: 10%">
                    <input type="text" readonly="readonly" name="" value="{{ Auth::user()->id }}" class="form-control "/>
                </div>
                <div class="form-group col-3" style="width: 70%">
                    <h4>{{ Auth::user()->name }}</h4>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <h2>Dashboard</h2>
            </div>
            <div class="col-md-1" style="margin-top: 20px">
                <a href="{{route('home')}}" class="btn btn-primary">Home</a>
            </div>
            <div class="col-md-1" style="margin-top: 20px">
               
            </div>
            <div class="col-md-3">
                <div class="pull-right">
                    <label>Total</label>&nbsp; <input id="totalSession" type="text" readonly="" name="" value="{{ $totalGlobalLetter }}" class="form-control col-total">
                </div>
            </div>
        </div>
    </header>
@stop

@section('content')
    <div class="row">
        <div class="col-md-2">
            <h5 class="text-center">Word ({{ count($words) }})</h5>
            <div class="static-height-400">
                <div class="inline-edit-group">
                    <?php
                    $totalWordLetter = 0;
                    $currentUser = Auth::user();
                    ?>
                    @foreach($words as $word)
                        <?php
                        $totalWordLetter += $word->total;
                        ?>
                        <div class="col stripped-row word-row {{ $currentUser->canEditWord($word->id) ? 'inline-row' : '' }}" data-value="{{ $word->content }}" data-id="{{ $word->id }}" data-session-id="{{ $word->session_id }}">
                            <div class="table-div">
                                <div class="table-cell-div" style="width: 10%">
                                    <div class="checkbox-special">
                                        <a href="{{route('session_detail')}}?type=word&id={{ $word->id }}"></a>
                                    </div>
                                </div>
                                <div class="table-cell-div hover inline-edit value1">
                                    {{ $word->content }}
                                </div>
                                <input type="hidden" class="countLetter" value="{{ $word->count_letter }}">
                                <div class="table-cell-div totalLetters total hover" style="width: 10%">
                                    {{ $word->total }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="pull-right">
                Total&nbsp;<input id="totalword" type="text" readonly name="" value="{{ $totalWordLetter }}" class="form-control col-total"/>
            </div>
        </div>

        <div class="col-md-5">
            <h5 class="text-center">Sentence Bank ({{ count($sentences) }})</h5>
            <div class="static-height-400">
                <div class="inline-edit-group">
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
                </div>
            </div>
            <div class="pull-right">
                Total&nbsp;<input id="totalsentence" type="text" readonly name="" value="{{ $totalSentenceLetter }}" class="form-control col-total"/>
            </div>
        </div>

        <div class="col-md-5">
            <h5 class="text-center">Paragraph Bank ({{ count($paragraphs) }})</h5>
            <div class="static-height-400">
                <div class="inline-edit-group">
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
                </div>
            </div>
            <div class="pull-right">
                Total&nbsp;<input id="totalparagraphs" type="text" readonly name="" value="{{ $totalParagraphLetter }}" class="form-control col-total"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-1 col-md-3">
            <h5 class="text-center">Session Bank ({{ count($sessions) }})</h5>
            <div class="static-height-300">
                @foreach($sessions as $session)
                    <div class="col stripped-row">
                        <div class="table-div">
                            <div class="table-cell-div" style="width: 1%">
                                <div class="checkbox-special">
                                    <a href="{{route('session_detail')}}?type=session&id={{ $session->id }}"></a>
                                </div>
                            </div>
                            <div class="table-cell-div hover" style="width: 8%">
                                {{ $session->id }}
                            </div>
                            <div class="table-cell-div cell-4 hover">
                                @if ( $session->assignment_id != null )
                                    {{ \App\Models\Assignment::where('id', $session->assignment_id)->first()->name }}
                                @else
                                    {{ $session->name}}
                                @endif
                            </div>
                            <div class="table-cell-div total hover" style="width: 5%">
                                {{ $session->count_letter }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pull-right">
                Total&nbsp;Session <input type="text" readonly name="" value="{{count($sessions)}}" class="form-control col-total"/>
            </div>
        </div>

        <div class="col-md-8">
            <h5 class="text-center">Essay Bank ({{ count($essays) }})</h5>
            <div class="static-height-300">
                <div class="inline-edit-group">
                    <?php
                    $totalEssayLetter = 0;
                    ?>
                    @foreach($essays as $essay)
                        <?php
                        $totalEssayLetter += $essay->count_letter;
                        ?>
                        <div class="col stripped-row essay-row {{ $currentUser->canEditEssay($essay->id) ? 'inline-row' : '' }}"   data-value="{{ $essay->title }}" data-value2="{{ $essay->content }}" data-id="{{ $essay->id }}" data-session-id="{{ $essay->session_id }}" >
                            <div class="table-div">
                                <div class="table-cell-div" style="width: 1%">
                                    <div class="checkbox-special">
                                        <a href="{{route('session_detail')}}?type=essay&id={{ $essay->id }}"></a>
                                    </div>
                                </div>
                                <div class="table-cell-div hover" style="width: 3%">
                                    {{ $essay->id }}
                                </div>
                                <div class="table-cell-div hover inline-edit value1">
                                    {{ $essay->title }}
                                </div>
                                <div class="table-cell-div hover total" style="width: 2%">
                                    {{ $essay->count_letter }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="pull-right">
                Total&nbsp;<input id="totalessays" type="text" readonly name="" value="{{ $totalEssayLetter }}" class="form-control col-total"/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-1 col-md-3 text-center">
            @if (!Auth::user()->isParent())
                <a href="{{route('create_session')}}" class="btn btn-primary">Create a Session</a>
            @else
                <a href="#" class="btn btn-primary" onclick="alert('Parent can not create a Session!')">Create a Session</a>
            @endif
        </div>
    </div>
@stop

@push('body_js')
    <script type="text/javascript" src="{{asset('js/vocabulary_functions.js')}}"></script>
    <script>
        var xcsrf = '{{ csrf_token() }}';
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

            $(this).closest('.inline-row').find('.total').html(totalLetter);
            $(this).closest('.inline-row').find('.countLetter').val(value1Length + value2Length);

            //console.log values
            console.log("Old Count: " + oldCount);
            console.log("Current Total: " + currentTotal);
            console.log("Value1 Length: " +value1.replace(/[^A-Z0-9]/gi, "").length);
            console.log("Value2 Length: " + value2.replace(/[^A-Z0-9]/gi, "").length);
        });

        $('body').on('blur', '.inline-row.word-row .inline-edit-value', function () {

            var inlineRow = $(this).closest('.inline-row');
            var value = $(this).val();
            var id = inlineRow.data('id');
            var session_id = inlineRow.data('session-id');
            var totalLetter =  parseInt($(this).closest('.inline-row').find('.total').html());
            console.log(totalLetter);
            updateWord(id, value, session_id, xcsrf, totalLetter);
            updateTotalWordLetter();
        });

        // update data to db
        $('body').on('blur', '.inline-row.sentence-row .inline-edit-value', function () {
            var inlineRow = $(this).closest('.inline-row');
            var value = $(this).val();
            var id = inlineRow.data('id');
            var session_id = inlineRow.data('session-id');

            updateSentence(id, value, session_id, xcsrf);
            updateTotalSentenceLetter();
        });

        $('body').on('blur', '.inline-row.paragraph-row .inline-edit-value', function () {
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
            var session_id = inlineRow.data('session-id');

            updateParagraph(id, title, content, session_id, xcsrf);
            updateTotalParagraphLetter();
        });

        $('body').on('blur', '.inline-row.essay-row .inline-edit-value', function () {
            var inlineRow = $(this).closest('.inline-row');
            var inlineEdit = $(this).closest('.inline-edit');
            var title = $(this).val();
            var content = inlineRow.data('value2');
            var session_id = inlineRow.data('session-id');

            updateEssay(title, content, session_id, xcsrf);
            updateTotalEssayLetter();
        });

        $('#totalword, #totalsentence, #totalparagraphs, #totalessays').change(function () {
            var totalWorld = parseInt($('#totalword').val()) || 0;
            var totalSentence = parseInt($('#totalsentence').val()) || 0;
            var totalParagraph = parseInt($('#totalparagraphs').val()) || 0;
            var totalEssay = parseInt($('#totalessays').val()) || 0;

            var total = totalWorld + totalSentence + totalParagraph + totalEssay;
            $('#totalSession').val(total);
        });

    </script>
    <script type="text/javascript" src="{{asset('js/inline_edit.js')}}"></script>
@endpush