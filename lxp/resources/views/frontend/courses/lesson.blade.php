@extends('frontend.layouts.app')

@push('after-styles')
    {{--<link rel="stylesheet" href="{{asset('plugins/YouTube-iFrame-API-Wrapper/css/main.css')}}">--}}
    <!-- <link rel="stylesheet" href="https://cdn.plyr.io/3.5.3/plyr.css"/> -->
    <link rel="stylesheet" href="{{asset('plugins/plyr.css')}}"/>
    <link href="{{asset('plugins/touchpdf-master/jquery.touchPDF.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}" />

    <style>
        .test-form {
            color: #333333;
        }

        .course-details-category ul li {
            width: 100%;
        }

        .sidebar.is_stuck {
            top: 15% !important;
        }

        .course-timeline-list {
            max-height: 300px;
            overflow: scroll;
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

        .touchPDF > .pdf-outerdiv {
            position: relative;
        }

        .touchPDF > .pdf-outerdiv > .pdf-toolbar {
            height: 100% !important;
            color: black;
            padding: 5px 0;
            text-align: right;
            position: absolute;            
            top: 0%;
            height: 30px;
            z-index: 9999999999999999999999999;
            width: 100% !important;
            left: initial !important;
        }

        .touchPDF > .pdf-outerdiv > .pdf-toolbar .pdf-button:nth-child(2){
            position: absolute;
            left: 0%;
            height: 100% !important;
        }

        .touchPDF > .pdf-outerdiv > .pdf-toolbar .pdf-button:nth-child(4){
            height: 100%;
        }

        .touchPDF > .pdf-outerdiv > .pdf-toolbar .pdf-button:nth-child(4) button:focus,
        .touchPDF > .pdf-outerdiv > .pdf-toolbar .pdf-button:nth-child(2) button:focus,{
            box-shadow: initial;
            color: #fff;
        }

        .touchPDF > .pdf-outerdiv > .pdf-toolbar .pdf-button:nth-child(2) button{
            height: 100%;
            width: 50px;
            border: 0;
            border-color: initial;
            background-color: initial;
            background-image: linear-gradient(to left, rgba(255,0,0,0), rgba(0,0,0,1));
        }

        .pdf-next:focus,
        .pdf-previous:focus{
            box-shadow: initial !important;
        }

        .pdf-zoomin,
        .pdf-zoomout{
            background: #cfcfcf !important;
            border: 2px solid !important;
            padding: 5px;
            width: 65px;
            color: #000;            
            font-weight: bold;
            transition: 300ms;
        }

        .pdf-zoomin:hover,
        .pdf-zoomout:hover{
            transition: 300ms;
            background: #2f2f2f;
            border: 2px solid  #6d6d6d;
            color: #6d6d6d; 
        }

        .touchPDF > .pdf-outerdiv > .pdf-toolbar .pdf-button:nth-child(4) button{
            height: 100%;
            width: 50px;
            border: 0;
            border-color: initial;
            background-color: initial;
            background-image: linear-gradient(to right, rgba(255,0,0,0), rgba(0,0,0,1));
        }

        .touchPDF > .pdf-outerdiv > .pdf-toolbar .pdf-button:nth-child(3){
            position: absolute;
            top: -3%;
            right: 50%;
            height: 100% !important;
        }

        .touchPDF > .pdf-outerdiv > .pdf-toolbar .pdf-button:nth-child(5){
            position: absolute;
            top: -3%;
            right: 10%;
        }

        .touchPDF > .pdf-outerdiv > .pdf-toolbar .pdf-button:nth-child(6){
            position: absolute;
            top: -3%;
            right: 0%;
        }

        .pdf-tabs {
            width: 100% !important;
        }

        .pdf-outerdiv {
            width: 100% !important;
            left: 0 !important;
            padding: 0px !important;
            transform: scale(1) !important;
        }

        .pdf-viewer {
            left: 0px;
            width: 100% !important;
            box-sizing: border-box;
            left: 0 !important;
            margin-top: 10px;
            position: relative;
            
        }

        .pdf-drag {
            width: 100% !important;
        }

        .pdf-outerdiv {
            left: 0px !important;
        }

        .pdf-outerdiv {
            padding-left: 0px !important;
            left: 0px;
        }

        .pdf-title {
            display: none !important;
        }

        #myPDF{
            padding-top: 30px;
        }

        @media screen  and  (max-width: 768px) {

        }

    </style>
@endpush

@section('content')
    <!-- Start of breadcrumb section
        ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">
                        <span>{{$lesson->course->title}}</span><br> {{$lesson->title}} </h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->


    <!-- Start of course details section
        ============================================= -->
    <section id="course-details" class="course-details-section">
        <div class="container ">
            <div class="row main-content">
                <div class="col-md-9">
                    @if(session()->has('success'))
                        <div class="alert alert-dismissable alert-success fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{session('success')}}
                        </div>
                    @endif
                    @include('includes.partials.messages')

                    <div class="course-details-item border-bottom-0 mb-0">
                        @if($lesson->lesson_image != "")
                            <div class="course-single-pic mb30">
                                <img src="{{asset('storage/uploads/'.$lesson->lesson_image)}}"
                                     alt="">
                            </div>
                        @endif


                        @if ($test_exists)
                            <div class="course-single-text">
                                <div class="course-title mt10 headline relative-position">
                                    <h3>
                                        <b>Test
                                            : {{$lesson->title}}</b>
                                    </h3>
                                </div>
                                <div class="course-details-content">
                                    <p> {!! $lesson->full_text !!} </p>
                                </div>
                            </div>
                            <hr/>
                            @if (!is_null($test_result))
                                
                                <div class="alert alert-info">Your Test Score
                                    : {{ $test_result->test_result }} out of {{ $lesson->overall_score }} <br>
                                    Passing Score : {{ $lesson->passing_score }}
                                </div>

                                @if(config('retest'))
                                    <form action="{{route('lessons.retest',[$test_result->test->slug])}}" method="post">
                                        @csrf
                                        <input type="hidden" name="result_id" value="{{$test_result->id}}">
                                        <button type="submit" class="btn gradient-bg font-weight-bold text-white" href="">
                                            Take the test again
                                        </button>
                                    </form>
                                @endif
                                @if(count($lesson->questions) > 0)
                                    @if($test_result->test_result < $lesson->passing_score)
                                        <h3 class="text-danger">Sorry.You have not met the passing score for this exam. Please take the exam again.</h3>
                                    @endif
                                        <hr>
                                        @foreach ($lesson->questions as $question)

                                            <h4 class="mb-0">{{ $loop->iteration }}
                                                . {!! $question->question !!}   @if(!$question->isAttempted($test_result->id))
                                                    <small class="badge badge-danger"> Not Attempted </small> @endif
                                            </h4>
                                            <br/>
                                            <ul class="options-list pl-4">
                                                @foreach ($question->options as $option)

                                                    @if($question->act_type == 1)
                                                        <li class="@if(($option->answered($test_result->id) != null && $option->answered($test_result->id) == 1) || ($option->correct == true)) correct @elseif($option->answered($test_result->id) != null && $option->answered($test_result->id) == 2) incorrect  @endif"> {{ $option->option_text }}
                                                             @if($option->correct == 1 && $option->explanation != null)
                                                                <p class="text-dark">
                                                                    <b>Explanation</b><br>
                                                                    {{$option->explanation}}
                                                                </p>
                                                            @endif
                                                        </li>
                                                    @else       
                                                        <p class="text-dark">
                                                            <b>Your Answer:</b><br>
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
                                    <h3>No data available</h3>

                                @endif
                            @else
                                <!-- dito ka nag error -->
                                <div class="alert alert-info">
                                     You are required to achieve a score of <span class="font-weight-bold"> {{ $lesson->passing_score }} </span>  to pass.
                                     <br>( Excluding Essays and Activity outputs )
                                </div>
                                <!-- dito ka nag error -->
                                <div class="test-form">
                                    @if(count($lesson->questions) > 0  )
                                        <form action="{{ route('lessons.test', [$lesson->slug]) }}" method="post">
                                            {{ csrf_field() }}
                                            @foreach ($lesson->questions as $question)
                                                <h4 class="mb-0">{{ $loop->iteration }}. {!! $question->question !!}  </h4>
                                                <br/>
                                                @if($question->act_type == 1)
                                                    @foreach ($question->options as $option)
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="questions[{{ $question->id }}]"
                                                                    value="{{ $option->id }}"/>
                                                                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                                {{ $option->option_text }}<br/>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <textarea class = "form-control" name="answer_text[{{ $question->id }}]" id="answer_text[{{ $question->id }}]" rows="5"> </textarea>
                                                @endif
                                                <br/>
                                            @endforeach
                                            <input class="btn gradient-bg text-white font-weight-bold" type="submit" value="Submit Results"/>
                                        </form>
                                    @else
                                        <h3>No data available</h3>

                                    @endif
                                </div>
                            @endif
                            <hr/>
                        @else
                            <div class="course-single-text">
                                <div class="course-title mt10 headline relative-position">
                                    <h3>
                                        <b>{{$lesson->title}}</b>
                                    </h3>
                                </div>
                                <div class="course-details-content">
                                    {!! $lesson->full_text !!}
                                </div>
                            </div>
                        @endif

                        @if($lesson->mediaPDF)
                            <div class="course-single-text mb-5">
                                <div id="myPDF"></div>
                            </div>
                        @endif


                        @if($lesson->mediaVideo && $lesson->mediavideo->count() > 0)
                            <div class="course-single-text">
                                @if($lesson->mediavideo != "")
                                    <div class="course-details-content mt-3">
                                        <div class="video-container mb-5" data-id="{{$lesson->mediavideo->id}}">
                                            @if($lesson->mediavideo->type == 'youtube')
                                                <div id="player" class="js-player" data-plyr-provider="youtube"
                                                     data-plyr-embed-id="{{$lesson->mediavideo->file_name}}"></div>
                                            @elseif($lesson->mediavideo->type == 'upload')
                                                <video poster="" id="player" class="js-player" playsinline controls>
                                                    <source src="{{$lesson->mediavideo->url}}" type="video/mp4"/>
                                                </video>
                                            @elseif($lesson->mediavideo->type == 'embed')
                                                {!! $lesson->mediavideo->url !!}
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($lesson->mediaAudio)
                            <div class="course-single-text mb-5">
                                <audio id="audioPlayer" controls>
                                    <source src="{{$lesson->mediaAudio->url}}" type="audio/mp3"/>
                                </audio>
                            </div>
                        @endif


                        @if(($lesson->downloadableMedia != "") && ($lesson->downloadableMedia->count() > 0))
                            <div class="course-single-text mt-4 px-3 py-1 gradient-bg text-white">
                                <div class="course-title mt10 headline relative-position">
                                    <h4 class="text-white">
                                        Download Files
                                    </h4>
                                </div>

                                @foreach($lesson->downloadableMedia as $media)
                                    <div class="course-details-content text-white">
                                        <p class="form-group">
                                            <a href="{{ route('download',['filename'=>$media->name,'lesson'=>$lesson->id]) }}"
                                               class="text-white font-weight-bold"><i
                                                        class="fa fa-download"></i> {{ $media->name }}
                                                ({{ number_format((float)$media->size / 1024 , 2, '.', '')}} MB
                                                )</a>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <!-- /course-details -->

                    <!-- /market guide -->

                    <!-- /review overview -->
                </div>

                <div class="col-md-3">
                    <div id="sidebar" class="sidebar">
                        <div class="course-details-category ul-li">
                            @if ($previous_lesson)
                                <p><a class="btn btn-block gradient-bg font-weight-bold text-white"
                                      href="{{ route('lessons.show', [$previous_lesson->course_id, $previous_lesson->model->slug]) }}"><i
                                                class="fa fa-angle-double-left"></i>
                                                PREV</a></p>
                            @endif

                            <p id="nextButton">
                                <!-- //update on time control 2 mins -->
                                @if(!empty($next_lesson))
                                    @if($lesson->isCompleted() )
                                        <a class="btn btn-block gradient-bg font-weight-bold text-white"
                                           href="{{ route('lessons.show', [$next_lesson->course_id, $next_lesson->model->slug]) }}">NEXT
                                            <i class='fa fa-angle-double-right'></i> </a>
                                    @else
                                        <a class='btn btn-block bg-danger font-weight-bold text-white' href='#'>Finish Course First</a>
                                    @endif
                                @endif
                                <!-- //update on time control 2 mins -->
                            </p>
                            <p id="counter" class="text-dark"> </p>
                            @if($lesson->course->progress() == 100)
                                @if(!$lesson->course->isUserCertified())
                                    <!-- <form method="post" action="{{route('admin.certificates.generate')}}">
                                        @csrf
                                        <input type="hidden" value="{{$lesson->course->id}}" name="course_id">
                                        <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                id="finish">Generate Certificate</button>
                                    </form> -->
                                    
                                    <button onclick="getSurveyQuestions('{{$course->id}}','{{$course->pes_id}}')" data-toggle='modal'
                                    data-target='#exampleModal' class='btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold'> Generate Certificate </button>
                                @else
                                    <div class="alert alert-success">
                                        You're Certified for this course
                                    </div>
                                @endif
                            @endif

                            <span class="float-none">Course timeline</span>
                            <ul class="course-timeline-list">
                                @foreach($lesson->course->courseTimeline()->orderBy('sequence')->get() as $key=>$item)
                                    @if($item->model && $item->model->published == 1)
                                        {{--@php $key++; @endphp--}}
                                        <li class="@if($lesson->id == $item->model->id) active @endif ">
                                            <a @if(in_array($item->model->id,$completed_lessons))href="{{route('lessons.show',['id' => $lesson->course->id,'slug'=>$item->model->slug])}}"@endif>
                                                {{$item->model->title}}
                                                @if($item->model_type == 'App\Models\Test')
                                                    <p class="mb-0 text-primary">
                                                        - Output</p>
                                                @endif
                                                @if(in_array($item->model->id,$completed_lessons)) <i
                                                        class="fa text-success float-right fa-check-square"></i> @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="couse-feature ul-li-block">
                            <ul>
                                <li>Chapters
                                    <span> {{$lesson->course->chapterCount()}} </span></li>
                                <li>Category <span><a
                                                href="{{route('courses.category',['category'=>$lesson->course->category->slug])}}"
                                                target="_blank">{{$lesson->course->category->name}}</a> </span></li>
                                <li>Author 
                                    <span>
                                        @foreach($lesson->course->teachers as $key=>$teacher)
                                            @php $key++ @endphp
                                            <a href="{{route('teachers.show',['id'=>$teacher->id])}}" target="_blank">
                                                {{$teacher->full_name}}@if($key < count($lesson->course->teachers )), @endif
                                            </a>
                                        @endforeach
                                    </span>
                                </li>
                                <li>Progress <span> <b> {{ $lesson->course->progress()  }}
                                            % Completed</b></span></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (auth()->user()))
    <div id="chat-fe-box">
        <div class=" message-box" style="display: none;" id="chat_panel">
            <div class="card ">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 id="teacher_name"> {{$course->teachers[0]->fullname}}
                                <span style="float: right;font-weight:bold" id="closeMessage"> X</span>
                            </h5>
                            <hr>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- <form method="post" action="{{route('admin.messages.send')}}">
                                <textarea name="messageText"></textarea>
                                <button class="btn btn-primary" id="sendMessage">Send</button>
                            </form> -->
                            <form method="post" id="sendMessage" action="{{route('admin.messages.send')}}">
                                @csrf
                                <input type="hidden" name="recipients[]" class="form-control" value="{{$course->teachers[0]->id}}">
                                <input type="hidden" name="return_type" class="form-control" value="json">
                                <div class="">
                                    <div class="msg_history">
                                        <!-- <p class="text-center">{{trans('labels.backend.messages.start_conversation')}}</p> -->
                                        <div class="inbox_chat">
                                            <div id="chatContentCustom">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="type_msg">
                                        <div class="input_msg_write">
                                            <textarea type="text" name="message" class="write_msg" placeholder="{{trans('labels.backend.messages.type_a_message')}}"></textarea>
                                            <button class="msg_send_btn" type="submit">
                                                <i class="fas fa-paper-plane " style="line-height: 2" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>


    <div class="msgButtonContainer">
        <button class="btn btn-primary" id="msgButton">
            <i class="fas fa-comments" aria-hidden="true"></i>
        </button>
    </div>
    @endif

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header backgroud-style">
                <div class="gradient-bg"></div>
                <div class="popup-logo">
                    <img src="{{asset("storage/logos/".config('logo_popup'))}}" alt="">
                </div>
                <div class="popup-text text-center">
                    <h2>Post Evaluation Survey</h2>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" action="{{ route('course.saveSurvey') }}">
                @csrf
                <div id="survey_body" class="modal-body">
                </div>
                <input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}' />
                <input type='hidden' value='{{$course->id}}' name='course_id'>
                <input type='hidden' value='{{$course->pes_id}}' name='pes_id'>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    <!-- End of course details section
    ============================================= -->

@endsection

@push('after-scripts')
    {{--<script src="//www.youtube.com/iframe_api"></script>--}}
    <script src="{{asset('plugins/sticky-kit/sticky-kit.js')}}"></script>
    <!-- <script src="https://cdn.plyr.io/3.5.3/plyr.polyfilled.js"></script> -->
    <script src="{{asset('plugins/plyr.polyfilled.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/pdf.compatibility.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/pdf.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/jquery.touchSwipe.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/jquery.touchPDF.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/jquery.panzoom.js')}}"></script>
    <script src="{{asset('plugins/touchpdf-master/jquery.mousewheel.js')}}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script> -->
    <script src="{{asset('plugins/js.cookie.min.js')}}"></script>


<script>

    var chatPanel = false;
    $(document).on('ready', function() {

        $(document).on('click', '#closeMessage', function(e) {
            $("#chat_panel").hide();
            $("#msgButton").show();
        })

        $(document).on('click', '#msgButton', function(e) {
            e.preventDefault()
            $("#chat_panel").show();
            $("#msgButton").hide();
            $("#chatContentCustom").html("");

            // $.ajax({
            //     type: "POST",
            //     url: "{{  route('admin.messages.getData')}}",
            //     data: {
            //         "recipients": "{{$course->teachers[0]->id}}",
            //         "thread":"" 
            //     },
            //     // dataType: $this.data('type'),
            //     success: function(response) {
            //         var message_list = response.threads.messages;
            //         var chat_content = "";

            //         message_list.forEach(e => {
            //             chat_content += "<li>";
            //             chat_content += `<p>${e.body}</p>`;
            //             chat_content += "</li>";

            //         });
            //         chat_content += "";
            //         $("#chatContentCustom").html(chat_content);
            //     },
            //     error: function(jqXHR) {

            //     },
            //     complete: function() {


            //     }
            // });
        })

        $(document).on('submit', '#sendMessage', function(e) {
            e.preventDefault();
            var $this = $(this);
            $.ajax({
                type: "POST",
                url: $this.attr('action'),
                data: $this.serializeArray(),
                dataType: $this.data('type'),
                success: function(response) {
                    $.ajax({
                        type: "POST",
                        url: "{{  route('admin.messages.getData')}}",
                        data: {
                            "thread": response.message.thread_id
                        },
                        // dataType: $this.data('type'),
                        success: function(response) {
                            var message_list = response.threads.messages;
                            var chat_content = "";

                            message_list.forEach(e => {
                                if (e.sender_id != response.ud) {
                                    chat_content += `  <div class="chat-from-container">`;
                                    chat_content += `    <div class="chat-from talk-bubble triangle left-top">`;
                                    chat_content += `        <img src="https://user.ptetutorials.com/images/user-profile.png" class="profile-pic">`;
                                    chat_content += `        <div class="talktext">`;
                                    chat_content += `            <p>Left flush at the top.</p>`;
                                    chat_content += `        </div>`;
                                    chat_content += `    </div>`;
                                    chat_content += `    <span class="chat-info">09/23/2021 Jerry Dangga Julian</span>`;
                                    chat_content += `</div>`;
                                } else {
                                    chat_content += `<div class="chat-to-container">`;
                                    chat_content += `    <div class="chat-to talk-bubble triangle right-top">`;
                                    chat_content += `        <img src="https://user.ptetutorials.com/images/user-profile.png" class="profile-pic">`;
                                    chat_content += `        <div class="talktext">`;
                                    chat_content += `            <p>${e.body}`;
                                    chat_content += `            </p>`;
                                    chat_content += `        </div>`;
                                    chat_content += `    </div>`;
                                    chat_content += `    <span class="chat-info">09/23/2021 Jerry Dangga Julian</span>`;
                                    chat_content += `</div>`;

                                }


                            });
                            chat_content += "";
                            $("#chatContentCustom").html(chat_content);
                            $(".inbox_chat").scrollTop($("#chatContentCustom").height());
                            // $("#chatContentCustom").stop().animate({ scrollTop: $("#chatContentCustom")[0].scrollHeight }, 500);
                        },
                        error: function(jqXHR) {

                        },
                        complete: function() {


                        }
                    });

                },
                error: function(jqXHR) {

                },
                complete: function() {


                }
            });
        })

    })

    //Display PDF Presentation
    @if($lesson->mediaPDF)
        $(function () {
            $("#myPDF").pdf({
                source: "{{asset('storage/uploads/'.$lesson->mediaPDF->name)}}",
                loadingHeight: 800,
                loadingWidth: 800,
                loadingHTML: "Loading Presentation"
            });

        });
    @endif

        // var storedDuration = 0;
        // var storedLesson;
        // storedDuration = Cookies.get("duration_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}");
        // storedLesson = Cookies.get("lesson" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}");
        //var user_lesson;

        // if (parseInt(storedLesson) != parseInt("{{$lesson->id}}")) {
        //     Cookies.set('lesson', parseInt('{{$lesson->id}}'));
        // }

        var interval;
        $("#sidebar").stick_in_parent();


        @if(!$lesson->isCompleted())
            @if($lesson->mediaVideo && $lesson->mediaVideo->type != 'embed')
                var current_progress = 0;

                @if($lesson->mediaVideo->getProgress(auth()->user()->id) != "")
                    current_progress = "{{$lesson->mediaVideo->getProgress(auth()->user()->id)->progress}}";
                @endif

                const player2 = new Plyr('#audioPlayer');

                const player = new Plyr('#player');
                duration = 10;
                var progress = 0;
                var video_id = $('#player').parents('.video-container').data('id');
                player.on('ready', event => {
                    player.currentTime = parseInt(current_progress);
                    duration = event.detail.plyr.duration;

                    // if (!storedDuration || (parseInt(storedDuration) === 0)) {
                    //     Cookies.set("duration_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}", duration);
                    // }

                });

                // {{--if (!storedDuration || (parseInt(storedDuration) === 0)) {--}}
                // {{--Cookies.set("duration_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}", player.duration);--}}
                // {{--}--}}


                //Save Video Progress every 3 seconds
                setInterval(function () {
                    player.on('timeupdate', event => {
                        if ((parseInt(current_progress) > 0) && (parseInt(current_progress) < parseInt(event.detail.plyr.currentTime))) {
                            progress = current_progress;
                        } else {
                            progress = parseInt(event.detail.plyr.currentTime);
                        }
                    });
                    if(duration !== 0 || parseInt(progress) !== 0 ) {
                        saveProgress(video_id, duration, parseInt(progress));
                    }
                }, 3000);


                function saveProgress(id, duration, progress) {
                    $.ajax({
                        url: "{{route('update.videos.progress')}}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'video': parseInt(id),
                            'duration': parseInt(duration),
                            'progress': parseInt(progress)
                        },
                        success: function (result) {
                            if (progress === duration) {
                                location.reload();
                            }
                        }
                    });
                }

                // $('#notice').on('hidden.bs.modal', function () {
                //     location.reload();
                // });

            @endif

            //@if((int)config('lesson_timer') != 0)
            //Next Button enables/disable according to time

            // var readTime, totalQuestions, testTime;
            // user_lesson = Cookies.get("user_lesson_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}");

            // @if ($test_exists )
            //     totalQuestions = '{{count($lesson->questions)}}'
            //     readTime = parseInt(totalQuestions) * 30;
            // @else
            //     readTime = parseInt("{{$lesson->readTime()}}") * 60;
            // @endif

            // storedDuration = Cookies.get("duration_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}");
            // storedLesson = Cookies.get("lesson" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}");


            //var totalLessonTime = readTime + (parseInt(storedDuration) ? parseInt(storedDuration) : 0);
            //var storedCounter = (Cookies.get("storedCounter_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}")) ? Cookies.get("storedCounter_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}") : 0;
            //var counter;
            // if (user_lesson) {
            //     if (user_lesson === 'true') {
            //         counter = 1;
            //     }
            // } else {
            //     if ((storedCounter != 0) && storedCounter < totalLessonTime) {
            //         counter = storedCounter;
            //     } else {
            //         counter = totalLessonTime;
            //     }
            // }

            
            let time_consumed = '{{$time_consumed}}';
            var i = time_consumed;      

            var isCompleted = false;
            interval = setInterval(function () {
                if(!isCompleted){
                @if($lesson->mediaVideo && $lesson->mediavideo->count() > 0 )
                    console.log("media interval");
                    $.ajax({
                        url: "{{route('get.video.competed')}}",
                        method: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'video': parseInt(video_id),
                            'model_id': parseInt("{{$lesson->id}}"),
                            'model_type':  "{{get_class($lesson)}}",
                        },
                        success: function (result) {
                            lesson_completed = result.complete;
                            if(lesson_completed){
                                isCompleted = true;
                                @if(!empty($next_lesson))
                                    $('#nextButton').html("<a class='btn btn-block gradient-bg font-weight-bold text-white'" +
                                        " href='{{ route('lessons.show', [$next_lesson->course_id, $next_lesson->model->slug]) }}'> NEXT <i class='fa fa-angle-double-right'></i> </a>");
                                @else
                                    // $('#nextButton').html("<form method='post' action='{{route("admin.certificates.generate")}}'>" +
                                    //     "<input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}' />" +
                                    //     "<input type='hidden' value='{{$lesson->course->id}}' name='course_id'> " +
                                    //     "<button class='btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold' id='finish'>Finish Course</button></form>");
                                    
                                    $('#nextButton').html("<button onclick=\"getSurveyQuestions('{{$course->id}}','{{$course->pes_id}}')\" data-toggle='modal'" +
                                        " data-target='#exampleModal' class='btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold'> Generate Certificate </button>");
                                @endif
                                
                                clearInterval(interval);
                            }else{
                                // Display a next button box
                                $('#nextButton').html("<a class='btn btn-block bg-danger font-weight-bold text-white' href='#'>Finish Course First</a>")
                            }
                        }
                    });
                @else
                //console.log("Something");
                    //counter--;
                    // Display 'counter' wherever you want to display it.
                    // if (counter >= 0) {
                    //     // Display a next button box
                    //     $('#nextButton').html("<a class='btn btn-block bg-danger font-weight-bold text-white' href='#'> NEXT (in " + counter + " seconds)</a>")
                    //     Cookies.set("duration_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}", counter);

                    // }
                    // if (counter === 0) {
                        // Cookies.set("user_lesson_" + "{{auth()->user()->id}}" + "_" + "{{$lesson->id}}" + "_" + "{{$lesson->course->id}}", 'true');
                        // Cookies.remove('duration');

                        @if ($test_exists)
                            @if(is_null($test_result))
                                $('#nextButton').html("<a class='btn btn-block bg-danger font-weight-bold text-white' href='#'>Please Complete Test</a>")
                            @elseif($test_result >= $lesson->passing_score)
                                $('#nextButton').html("<a class='btn btn-block bg-danger font-weight-bold text-white' href='#'>Please Pass the Test</a>")
                            @else
                            
                                isCompleted = true;
                                @if(!empty($next_lesson))
                                    $('#nextButton').html("<a class='btn btn-block gradient-bg font-weight-bold text-white'" +
                                        " href='{{ route('lessons.show', [$next_lesson->course_id, $next_lesson->model->slug]) }}'> NEXT <i class='fa fa-angle-double-right'></i> </a>");
                                @else
                                    // $('#nextButton').html("<form method='post' action='{{route("admin.certificates.generate")}}'>" +
                                    //     "<input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}' />" +
                                    //     "<input type='hidden' value='{{$lesson->course->id}}' name='course_id'> " +
                                    //     "<button class='btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold' id='finish'>Finish Course</button></form>");
                                    
                                    $('#nextButton').html("<button onclick=\"getSurveyQuestions('{{$course->id}}','{{$course->pes_id}}')\" data-toggle='modal'" +
                                        " data-target='#exampleModal' class='btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold'> Generate Certificate </button>");
                                @endif
                                
                                clearInterval(interval);
                            @endif
                        @else
                            if(parseInt(time_consumed) < 120 && parseInt(time_consumed) > -1){
                                i++;
                                var ctr = 120 - i;
                                if(ctr > 0){
                                    $('#counter').html("Finishing course in: " + ctr);
                                    if(i%60 == 0){
                                        updateTimeControl();
                                    }
                                }else{
                                    isCompleted = true;
                                    $('#counter').html("You can now proceed to the next lesson");
                                    @if(!$lesson->isCompleted())
                                        updateTimeControl();
                                        courseCompleted("{{$lesson->id}}", "{{get_class($lesson)}}");
                                        
                                        clearInterval(interval);
                                    @endif
                                    @if(!empty($next_lesson))
                                        $('#nextButton').html("<a class='btn btn-block gradient-bg font-weight-bold text-white'" +
                                        " href='{{ route('lessons.show', [$next_lesson->course_id, $next_lesson->model->slug]) }}'> NEXT <i class='fa fa-angle-double-right'></i> </a>");
                                    @else
                                        // $('#nextButton').html("<form method='post' action='{{route("admin.certificates.generate")}}'>" +
                                        //     "<input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}' />" +
                                        //     "<input type='hidden' value='{{$lesson->course->id}}' name='course_id'> " +
                                        //     "<button class='btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold' id='finish'>Finish Course</button></form>");
                                   
                                        $('#nextButton').html("<button onclick=\"getSurveyQuestions('{{$course->id}}','{{$course->pes_id}}')\" data-toggle='modal'" +
                                        " data-target='#exampleModal' class='btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold'> Generate Certificate </button>");
                                   @endif
                                }
                            }else{
                                isCompleted = true;
                                @if(!$lesson->isCompleted())
                                    updateTimeControl();
                                    courseCompleted("{{$lesson->id}}", "{{get_class($lesson)}}");
                                    
                                    clearInterval(interval);
                                @endif
                                @if(!empty($next_lesson))
                                    $('#nextButton').html("<a class='btn btn-block gradient-bg font-weight-bold text-white'" +
                                    " href='{{ route('lessons.show', [$next_lesson->course_id, $next_lesson->model->slug]) }}'> NEXT <i class='fa fa-angle-double-right'></i> </a>");
                                @else
                                    // $('#nextButton').html("<form method='post' action='{{route("admin.certificates.generate")}}'>" +
                                    //     "<input type='hidden' name='_token' id='csrf-token' value='{{ Session::token() }}' />" +
                                    //     "<input type='hidden' value='{{$lesson->course->id}}' name='course_id'> " +
                                    //     "<button class='btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold' id='finish'>Finish Course</button></form>");
                                
                                    $('#nextButton').html("<button onclick=\"getSurveyQuestions('{{$course->id}}','{{$course->pes_id}}')\" data-toggle='modal'" +
                                        " data-target='#exampleModal' class='btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold'> Generate Certificate </button>");
                                @endif
                            }
                        @endif
                        clearInterval(counter);
                    //}
                @endif
                }
            }, 1000);

        @endif
        //@endif

        function courseCompleted(id, type) {
            $.ajax({
                url: "{{route('update.course.progress')}}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'model_id': parseInt(id),
                    'model_type': type,
                },
            });
        }

        function updateTimeControl() {
            $.ajax({
                url: "{{route('update.time.control')}}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': '{{$time_id}}',
                    'unload':false,
                },
                success:function(result){
                }
            });
        }


        function getSurveyQuestions(course,pes_id)
        {
            // $("#survey_course").val(course);
            // $("#survey").val(pes_id);

            $.ajax({
                url: "{{route('course.surveyQuestions')}}",
                method: "POST",
                data: {
                    'pes_id': parseInt(pes_id),
                    'course': parseInt(course),
                },
                dataType: "json",
                success: function (result) {
                    if (result.success) {
                        let form_body = '';

                        if(result.data.length > 0)
                        {
                            $.each(result.data, function( index, value ) {
                                if(parseInt(value.sme) == 0)
                                {
                                    form_body += '<div class="form-group">';
                                    form_body += '    <label class="col-form-label">'+value.question+'</label>';

                                    if(value.answer_type == 1){
                                        form_body += '<div class="form-control"> <div class = "row">';
                                        form_body += ' <div class="col-md-2"> <input type="radio" name="question['+value.peq_id+']" value="5" required> Excellent </input> </div>';
                                        form_body += ' <div class="col-md-3"> <input type="radio" name="question['+value.peq_id+']" value="4" required> Very Satisfactory </input> </div>';
                                        form_body += ' <div class="col-md-3"> <input type="radio" name="question['+value.peq_id+']" value="3" required> Satisfactory </input> </div>';
                                        form_body += ' <div class="col-md-2"> <input type="radio" name="question['+value.peq_id+']" value="2" required> Fair </input> </div>';
                                        form_body += ' <div class="col-md-2"> <input type="radio" name="question['+value.peq_id+']" value="1" required> Poor </input> </div>';
                                        form_body += '</div></div>';
                                    }else{
                                        form_body += '<div class = "row"> <div class="col-md-12"> <textarea name="question['+value.peq_id+']" class="form-control" required> </textarea> </div></div>';
                                    }

                                    form_body += '</div>';
                                }
                            });


                            if(result.smes.length > 0)
                            {
                                $.each(result.smes, function( i, v ) {
                                    form_body += '<hr>';
                                    form_body += '<h4>SME:'+v+'</h4>';
                                    $.each(result.data, function( index, value ) {
                                        if(parseInt(value.sme) == 1)
                                        {
                                            form_body += '<div class="form-group">';
                                            form_body += '    <label class="col-form-label">'+value.question+'</label>';
                                            
                                            if(value.answer_type == 1){
                                                form_body += '<div class="form-control"> <div class = "row">';
                                                form_body += '<div class="col-md-2"> <input type="radio" name="question['+value.peq_id+'_'+v+']" value="5" required> Excellent </input></div>';
                                                form_body += '<div class="col-md-3"> <input type="radio" name="question['+value.peq_id+'_'+v+']" value="4" required> Very Satisfactory </input></div>';
                                                form_body += '<div class="col-md-3"> <input type="radio" name="question['+value.peq_id+'_'+v+']" value="3" required> Satisfactory </input></div>';
                                                form_body += '<div class="col-md-2"> <input type="radio" name="question['+value.peq_id+'_'+v+']" value="2" required> Fair </input></div>';
                                                form_body += '<div class="col-md-2"> <input type="radio" name="question['+value.peq_id+'_'+v+']" value="1" required> Poor </input></div>';
                                                form_body += '</div></div>';
                                            }else{
                                                form_body += '<div class = "row"> <textarea name="question['+value.peq_id+'_'+v+']" class="form-control" required> </textarea> </div>';
                                            }

                                            form_body += '</div>';
                                        }
                                    });
                                });
                            }


                            $("#survey_body").html(form_body);
                        }

                    }else{
                        alert(result.message);
                    }
                }
            });
        }
        
        // //update on time control 2 mins
        // let time_consumed = '{{$time_consumed}}';

        // @if(!($lesson->mediaVideo && $lesson->mediavideo->count() > 0) && !$lesson->isCompleted() && !$test_exists )
        //     if(parseInt(time_consumed) < 120 && parseInt(time_consumed) > -1)
        //     {
        //         let update_time_control = (120 - parseInt(time_consumed))*1000;
        //         setTimeout(function(){
        //             @if(!empty($next_lesson))
        //                 $('#nextButton').html('<a class="btn btn-block gradient-bg font-weight-bold text-white"href="{{ route("lessons.show", [$next_lesson->course_id, $next_lesson->model->slug]) }}"> NEXT <i class="fa fa-angle-double-right"></i> </a>')
        //             @endif
                    
        //             $.ajax({
        //                 url: "{{route('update.time.control')}}",
        //                 method: "POST",
        //                 data: {
        //                     "_token": "{{ csrf_token() }}",
        //                     'id': '{{$time_id}}',
        //                     'unload':false,
        //                 },
        //                 success:function(result){
        //                     // alert();
        //                     clearInterval(interval);
        //                 }
        //             });

        //         }, update_time_control);

        //         // window.onbeforeunload = function(){
        //         //     console.log('closing shared worker port...');
        //         //     alert("closing shared worker port...");
        //         //     return 'Take care now, bye-bye then.';
        //         // };

        //         $(window).on('beforeunload',function(){
        //             alert("Are you sure you want to close?");

        //             let check = false;

        //             $.ajax({
        //                 url: "{{route('update.time.control')}}",
        //                 method: "get",
        //                 data: {
        //                         "_token": "{{ csrf_token() }}",
        //                         'id': '{{$time_id}}',
        //                         'unload':true,
        //                     },
        //                 success:function(result){
        //                     check = true
        //                     $check_next_button = true;
        //                 }

        //             });

        //             if(check)
        //             return "Bye now!";
        //         });

        //     }
        // @endif

        //update on time control 2 mins


    </script>
@endpush