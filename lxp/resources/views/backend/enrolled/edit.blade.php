@extends('backend.layouts.app')
@section('title', __('labels.backend.lessons.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <style>
        .select2-container--default .select2-selection--single {
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
        }

        .bootstrap-tagsinput {
            width: 100% !important;
            display: inline-block;
        }

        .bootstrap-tagsinput .tag {
            line-height: 1;
            margin-right: 2px;
            background-color: #2f353a;
            color: white;
            padding: 3px;
            border-radius: 3px;
        }
        
        
        .options-list li {
            list-style-type: none;
        }

        .options-list li.correct {
            color: green;

        }

        .options-list li.incorrect {
            color: red;

        }

        .options-list li.correct:before {
            content: "\f058"; /* FontAwesome Unicode */
            font-family: 'Font Awesome\ 5 Free';
            display: inline-block;
            color: green;
            margin-left: -1.3em; /* same as padding-left set on li */
            width: 1.3em; /* same as padding-left set on li */
        }

        .options-list li.incorrect:before {
            content: "\f057"; /* FontAwesome Unicode */
            font-family: 'Font Awesome\ 5 Free';
            display: inline-block;
            color: red;
            margin-left: -1.3em; /* same as padding-left set on li */
            width: 1.3em; /* same as padding-left set on li */
        }

        .options-list li:before {
            content: "\f111"; /* FontAwesome Unicode */
            font-family: 'Font Awesome\ 5 Free';
            display: inline-block;
            color: black;
            margin-left: -1.3em; /* same as padding-left set on li */
            width: 1.3em; /* same as padding-left set on li */
        }

    </style>

@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Enrollee Test Result</h3>
        </div>
        <div class="card-body">
            <div class = "row">
                <div class = "col">
                    Content

                    <div class="course-single-text">
                        <div class="course-title mt10 headline relative-position">
                            <h3>
                                <b>@lang('labels.frontend.course.test') : {{$lesson->title}}</b>
                            </h3>
                        </div>
                        <div class="course-details-content">
                            <p> {!! $lesson->full_text !!} </p>
                        </div>
                    </div>
                    <hr/>
                    @if (!is_null($test_result))
                        
                        <div class="alert alert-info">Test Score
                            : {{ $test_result->test_result }} out of {{ $lesson->overall_score }} <br>
                            Passing Score : {{ $lesson->passing_score }}
                        </div>

                        @if(count($lesson->questions) > 0)
                            <hr>
                                @foreach ($lesson->questions as $question)

                                    <h4 class="mb-0">{{ $loop->iteration }}
                                        . {!! $question->question !!}   @if(!$question->isAttempted($test_result->id))
                                            <small class="badge badge-danger"> @lang('labels.frontend.course.not_attempted')</small> @endif
                                    </h4>
                                    <br/>
                                    <ul class="options-list pl-4">
                                    
                                        @foreach ($question->options as $option)
                                            @if($question->act_type == 1)

                                                <li class="@if(($option->answered($test_result->id) != null && $option->answered($test_result->id) == 1) || ($option->correct == true)) correct @elseif($option->answered($test_result->id) != null && $option->answered($test_result->id) == 2) incorrect  @endif"> {{ $option->option_text }}

                                                    @if($option->correct == 1 && $option->explanation != null)
                                                        <p class="text-dark">
                                                            <b>@lang('labels.frontend.course.explanation')</b><br>
                                                            {{$option->explanation}}
                                                        </p>
                                                    @endif

                                                </li>
                                            @else
                                                <p class="text-dark">
                                                    <b>Answer:</b><br>
                                                    {{$option->answerText($test_result->id)}}
                                                </p>
                                                <p class="text-dark">
                                                    <b>Explanation</b><br>
                                                    {{$option->explanation}}
                                                </p>

                                            @endif

                                        @endforeach

                                    </ul>
                                    <br/>
                                @endforeach
                        @else
                            <h3>@lang('labels.general.no_data_available')</h3>

                        @endif
                    @else
                        <p>The Learner haven't answer this activity yet</p>
                    @endif
                    <hr/>
                </div>
            </div>
        </div>
    </div>
@stop
