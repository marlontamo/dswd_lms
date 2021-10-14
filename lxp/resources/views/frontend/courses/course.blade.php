@extends('frontend.layouts.app')

@section('title', ($course->title) ? $course->meta_title : app_name() )
@section('meta_description', $course->meta_description)
@section('meta_keywords', $course->meta_keywords)

@push('after-styles')
<style>
    .leanth-course.go {
        right: 0;
    }
</style>
<!-- <link rel="stylesheet" href="https://cdn.plyr.io/3.5.3/plyr.css"/> -->
<link rel="stylesheet" href="{{asset('plugins/plyr.css')}}" />
<link rel="stylesheet" href="{{asset('css/custom.css')}}" />

@endpush

@section('content')

<!-- Start of breadcrumb section
        ============================================= -->
<section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
    <div class="blakish-overlay"></div>
    <div class="container">
        <div class="page-breadcrumb-content text-center">
            <div class="page-breadcrumb-title">
                <h2 class="breadcrumb-head black bold"><span>{{$course->title}}</span></h2>
            </div>
        </div>
    </div>
</section>
<!-- End of breadcrumb section
        ============================================= -->

<!-- Start of course details section
        ============================================= -->

<section id="course-details" class="course-details-section">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                @if(session()->has('success'))
                <div class="alert alert-dismissable alert-success fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{session('success')}}
                </div>
                @endif
                <div class="course-details-item border-bottom-0 mb-0">
                    <div class="course-single-pic mb30">
                        @if($course->course_image != "")
                        <img src="{{asset('storage/uploads/'.$course->course_image)}}" alt="">
                        @endif
                    </div>
                    <div class="course-single-text">
                        <div class="course-title mt10 headline relative-position">
                            <h3><a href="{{ route('courses.show', [$course->slug]) }}"><b>{{$course->title}}</b></a>
                            </h3>
                        </div>
                        <div class="course-details-content">
                            <p>
                                {!! $course->description !!}
                            </p>
                        </div>

                        @if($course->mediaVideo && $course->mediavideo->count() > 0)
                        <div class="course-single-text">
                            @if($course->mediavideo != "")
                            <div class="course-details-content mt-3">
                                <div class="video-container mb-5" data-id="{{$course->mediavideo->id}}">
                                    @if($course->mediavideo->type == 'youtube')


                                    <div id="player" class="js-player" data-plyr-provider="youtube" data-plyr-embed-id="{{$course->mediavideo->file_name}}"></div>
                                    @elseif($course->mediavideo->type == 'vimeo')
                                    <div id="player" class="js-player" data-plyr-provider="vimeo" data-plyr-embed-id="{{$course->mediavideo->file_name}}"></div>
                                    @elseif($course->mediavideo->type == 'upload')
                                    <video poster="" id="player" class="js-player" playsinline controls>
                                        <source src="{{$course->mediavideo->url}}" type="video/mp4" />
                                    </video>
                                    @elseif($course->mediavideo->type == 'embed')
                                    {!! $course->mediavideo->url !!}
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif


                        @if(count($lessons) > 0)

                        <div class="course-details-category ul-li">
                            <span class="float-none">@lang('labels.frontend.course.course_timeline')</span>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- /course-details -->

                <div class="affiliate-market-guide mb65">

                    <div class="affiliate-market-accordion">
                        <div id="accordion" class="panel-group">
                            @if(count($lessons) > 0)
                            @php $count = 0; @endphp
                            @foreach($lessons as $key=> $lesson)
                            @if($lesson->model && $lesson->model->published == 1)
                            @php $count++ @endphp

                            <div class="panel position-relative">
                                @if(auth()->check())
                                @if(in_array($lesson->model->id,$completed_lessons))
                                <div class="position-absolute" style="right: 0;top:0px">
                                    <span class="gradient-bg p-1 text-white font-weight-bold completed">@lang('labels.frontend.course.completed')</span>
                                </div>
                                @endif
                                @endif
                                <div class="panel-title" id="headingOne">
                                    <div class="ac-head">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$count}}" aria-expanded="false" aria-controls="collapse{{$count}}">
                                            <span>{{ sprintf("%02d", $count)}}</span>
                                            {{$lesson->model->title}}
                                        </button>
                                        @if($lesson->model_type == 'App\Models\Test')
                                        <div class="leanth-course">
                                            <span>@lang('labels.frontend.course.test')</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div id="collapse{{$count}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="panel-body">
                                        @if($lesson->model_type == 'App\Models\Test')
                                        {{ mb_substr($lesson->model->description,0,20).'...'}}
                                        @else
                                        {{$lesson->model->short_text}}

                                        @endif
                                        @if(auth()->check())

                                        @if(in_array($lesson->model->id,$completed_lessons))
                                        <div>
                                            <a class="btn btn-warning mt-3" href="{{route('lessons.show',['id' => $lesson->course->id,'slug'=>$lesson->model->slug])}}">
                                                <span class=" text-white font-weight-bold ">@lang('labels.frontend.course.go')
                                                    ></span>
                                            </a>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /market guide -->

                <div class="course-review">
                    <div class="section-title-2 mb20 headline text-left">
                        <h2>@lang('labels.frontend.course.course_reviews')</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="ratting-preview">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="avrg-rating ul-li">
                                            <b>@lang('labels.frontend.course.average_rating')</b>
                                            <span class="avrg-rate">{{$course_rating}}</span>
                                            <ul>
                                                @for($r=1; $r<=$course_rating; $r++) <li><i class="fas fa-star"></i></li>
                                                    @endfor
                                            </ul>
                                            <b>{{$total_ratings}} @lang('labels.frontend.course.ratings')</b>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="avrg-rating ul-li">
                                            <span><b>@lang('labels.frontend.course.details')</b></span>
                                            @for($r=5; $r>=1; $r--)
                                            <div class="rating-overview">
                                                <span class="start-item">{{$r}} @lang('labels.frontend.course.stars')</span>
                                                <span class="start-bar"></span>
                                                <span class="start-count">{{$course->reviews()->where('rating','=',$r)->get()->count()}}</span>
                                            </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /review overview -->

                <div class="couse-comment">
                    <div class="blog-comment-area ul-li about-teacher-2">
                        @if(count($course->reviews) > 0)
                        <ul class="comment-list">
                            @foreach($course->reviews as $item)
                            <li class="d-block">
                                <div class="comment-avater">
                                    <img src="{{$item->user->picture}}" alt="">
                                </div>

                                <div class="author-name-rate">
                                    <div class="author-name float-left">
                                        @lang('labels.frontend.course.by'):
                                        <span>{{$item->user->full_name}}</span>
                                    </div>
                                    <div class="comment-ratting float-right ul-li">
                                        <ul>
                                            @for($i=1; $i<=(int)$item->rating; $i++)
                                                <li><i class="fas fa-star"></i></li>
                                                @endfor
                                        </ul>
                                        @if(auth()->check() && ($item->user_id == auth()->user()->id))
                                        <div>
                                            <a href="{{route('courses.review.edit',['id'=>$item->id])}}" class="mr-2">@lang('labels.general.edit')</a>
                                            <a href="{{route('courses.review.delete',['id'=>$item->id])}}" class="text-danger">@lang('labels.general.delete')</a>
                                        </div>

                                        @endif
                                    </div>
                                    <div class="time-comment float-right">{{$item->created_at->diffforhumans()}}</div>
                                </div>
                                <div class="author-designation-comment">
                                    <p>{{$item->content}}</p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <h4> @lang('labels.frontend.course.no_reviews_yet')</h4>
                        @endif

                        @if ($purchased_course)
                        @if(isset($review) || ($is_reviewed == false))
                        <div class="reply-comment-box">
                            <div class="review-option">
                                <div class="section-title-2  headline text-left float-left">
                                    <h2>@lang('labels.frontend.course.add_reviews')</h2>
                                </div>
                                <div class="review-stars-item float-right mt15">
                                    <span>@lang('labels.frontend.course.your_rating'): </span>
                                    <div class="rating">
                                        <label>
                                            <input type="radio" name="stars" value="1" />
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="stars" value="2" />
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="stars" value="3" />
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="stars" value="4" />
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                        </label>
                                        <label>
                                            <input type="radio" name="stars" value="5" />
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                            <span class="icon"><i class="fas fa-star"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="teacher-faq-form">
                                @php
                                if(isset($review)){
                                $route = route('courses.review.update',['id'=>$review->id]);
                                }else{
                                $route = route('courses.review',['course'=>$course->id]);
                                }
                                @endphp
                                <form method="POST" action="{{$route}}" data-lead="Residential">
                                    @csrf
                                    <input type="hidden" name="rating" id="rating">
                                    <label for="review">@lang('labels.frontend.course.message')</label>
                                    <textarea name="review" class="mb-2" id="review" rows="2" cols="20">@if(isset($review)){{$review->content}} @endif</textarea>
                                    <span class="help-block text-danger">{{ $errors->first('review', ':message') }}</span>
                                    <div class="nws-button text-center  gradient-bg text-uppercase">
                                        <button type="submit" value="Submit">@lang('labels.frontend.course.add_review_now')
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                        @endif


                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="side-bar">
                    <div class="course-side-bar-widget">
                        @if (!$purchased_course)
                            @if(!auth()->check())
                                <a id="openLoginModal"
                                    class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                    data-target="#myModal" href="#">@lang('labels.frontend.course.get_now') <i class="fas fa-caret-right"></i></a>

                            @elseif(auth()->check() && (auth()->user()->hasRole('student')))
                                @if($can_enroll && $valid_user_type)
                                    <h4 class="text-danger">{{$print_enroll}}</h4>
                                    <form action="{{ route('course.getnow') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}"/>
                                        <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                                href="#">@lang('labels.frontend.course.get_now') <i class="fas fa-caret-right"></i></button>
                                    </form>
                                    @if($errors->any())
                                        <h4 class="text-danger">{{$errors->first()}}</h4>
                                    @endif
                                @else
                                    <h4 class="alert alert-danger">{{$print_enroll}}</h4>
                                @endif
                            @else
                                <h6 class="alert alert-danger"> @lang('labels.frontend.course.buy_note')</h6>
                            @endif
                        @else
                            @if($continue_course)
                                <a href="{{route('lessons.show',['id' => $course->id,'slug'=>$continue_course->model->slug])}}" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font">

                                @lang('labels.frontend.course.continue_course')

                                <i class="fa fa-arow-right"></i></a>
                            @endif

                        @endif
                    </div>
                    <div class="enrolled-student">
                        <div class="comment-ratting float-left ul-li">
                            <ul>
                                @for($i=1; $i<=(int)$course->rating; $i++)
                                    <li><i class="fas fa-star"></i></li>
                                    @endfor
                            </ul>
                        </div>
                        <div class="couse-feature ul-li-block">
                            <ul>
                                <li class="d-inline-block w-100"> @lang('labels.frontend.course.chapters')
                                    <span class="text-right">  {{$course->chapterCount()}} </span></li>
                                        <li class="d-inline-block w-100">@lang('labels.frontend.course.category')<span class="text-right"><a
                                                        href="{{route('courses.category',['category'=>$course->category->slug])}}"
                                                        target="_blank">{{$course->category->name}}</a> </span></li>

                                        <li class="d-inline-block w-100"> @lang('labels.frontend.course.prerequisite') <span class="text-right">
                                            @if(!empty($get_all_prereq_lessons))
                                            @foreach($get_all_prereq_lessons as $key => $value)
                                            <a href="{{route('courses.show', [$value['slug']])}}" target="_blank">
                                                {{$value['title']}}
                                            </a><br>
                                            @endforeach
                                            @endif

                                    </span>
                                </li>

                                <li class="d-inline-block w-100"> @lang('labels.frontend.course.author') <span class="text-right">

                                        @foreach($course->teachers as $key=>$teacher)
                                        @php $key++ @endphp
                                        <a href="{{route('teachers.show',['id'=>$teacher->id])}}" target="_blank">
                                            {{$teacher->full_name}}@if($key < count($course->teachers )), @endif
                                        </a>
                                        @endforeach

                                    </span>
                                </li>
                            </ul>
                        </div>

                    @if($recent_news->count() > 0)
                    <div class="side-bar-widget">
                        <h2 class="widget-title text-capitalize">@lang('labels.frontend.course.recent_news')</h2>
                        <div class="latest-news-posts">
                            @foreach($recent_news as $item)
                            <div class="latest-news-area">
                                @if($item->image != "")
                                <div class="latest-news-thumbnile relative-position" style="background-image: url({{asset('storage/uploads/'.$item->image)}})">
                                    <div class="blakish-overlay"></div>
                                </div>
                                @endif

                                <div class="date-meta">
                                    <i class="fas fa-calendar-alt"></i> {{$item->created_at->format('d M Y')}}
                                </div>
                                <h3 class="latest-title bold-font"><a href="{{route('blogs.index',['slug'=>$item->slug.'-'.$item->id])}}">{{$item->title}}</a></h3>
                            </div>
                            <!-- /post -->
                            @endforeach

                            <div class="view-all-btn bold-font">
                                <a href="{{route('blogs.index')}}">@lang('labels.frontend.course.view_all_news')
                                    <i class="fas fa-chevron-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($global_featured_course != "")
                    <div class="side-bar-widget">
                        <h2 class="widget-title text-capitalize">@lang('labels.frontend.course.featured_course')</h2>
                        <div class="featured-course">
                            <div class="best-course-pic-text relative-position pt-0">
                                <div class="best-course-pic relative-position " @if($global_featured_course->course_image != "") style="background-image: url({{asset('storage/uploads/'.$global_featured_course->course_image)}})" @endif>
                                </div>
                                <div class="best-course-text" style="left: 0;right: 0;">
                                    <div class="course-title mb20 headline relative-position">
                                        <h3>
                                            <a href="{{ route('courses.show', [$global_featured_course->slug]) }}">{{$global_featured_course->title}}</a>
                                        </h3>
                                    </div>
                                    <div class="course-meta">
                                        <span class="course-category"><a href="{{route('courses.category',['category'=>$global_featured_course->category->slug])}}">{{$global_featured_course->category->name}}</a></span>
                                        <span class="course-author">{{ $global_featured_course->students()->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@if (auth()->user())
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

</section>
<!-- End of course details section
        ============================================= -->

@endsection

@push('after-scripts')
<!-- <script src="https://cdn.plyr.io/3.5.3/plyr.polyfilled.js"></script> -->
<script src="{{asset('plugins/plyr.polyfilled.js')}}"></script>

<script>
    const player = new Plyr('#player');

    $(document).on('change', 'input[name="stars"]', function() {
        $('#rating').val($(this).val());

    })
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

    @if(isset($review))
    var rating = "{{$review->rating}}";
    $('input[value="' + rating + '"]').prop("checked", true);
    $('#rating').val(rating);
    @endif
</script>
@endpush