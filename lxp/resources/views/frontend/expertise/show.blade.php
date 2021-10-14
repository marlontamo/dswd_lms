@extends('frontend.layouts.app')
@push('after-styles')
    <style>
        .section-title-2 h2:after {
            background: #ffffff;
            bottom: 0px;
            position: relative;
        }
         .couse-pagination li.active {
             color: #333333!important;
             font-weight: 700;
         }
        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #c7c7c7;
            background-color: white;
            border: none;
        }
        .page-item.active .page-link {
            z-index: 1;
            color: #333333;
            background-color:white;
            border:none;

        }
        ul.pagination{
            display: inline;
            text-align: center;
        }

        .contact-info input,
        .contact_third_form textarea{
            margin-top:15px;
            border: 1px solid #dddd !important;
            border-radius: 5px !important;
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
                    @if($expertise->category->cat_slug != 'org')
                        <h2 class="breadcrumb-head black bold">{{env('APP_NAME')}} <span>{{$expertise->first_name}} {{$expertise->middle_name}} {{$expertise->last_name}}</span></h2>
                    @else
                        <h2 class="breadcrumb-head black bold">{{env('APP_NAME')}} <span>{{$expertise->office}}</span></h2>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->


    <!-- Start of teacher details area
        ============================================= -->
    <section id="teacher-details" class="teacher-details-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="teacher-details-content mb45">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="teacher-details-img">
                                    <img style="width: 100%; box-shadow: #959595 5px 5px 5px; border: 1px solid rgb(0 0 0 / 7%);" src="{{asset('storage/uploads/'. $expertise->image)}}" alt="">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="teacher-details-text">
                                    @if($expertise->category->cat_slug != 'org')
                                    <div class="section-title-2 mb-2  headline text-left">
                                        <h2><span> {{$expertise->first_name}} {{$expertise->middle_name}} {{$expertise->last_name}}</span></h2>
                                    </div>

                                    <div class="teacher-address">
                                        <div class="address-details ul-li-block">
                                            <ul class="d-inline-block w-100">
                                                @if($expertise->category->cat_type == 0)
                                                    <li class="d-inline-block w-100">
                                                        <div class="addrs-icon">
                                                            <i class="fas fa-network-wired"></i>
                                                        </div>
                                                        <div class="add-info">
                                                            <span>Current Designation: </span>{{$expertise->office}}
                                                        </div>
                                                    </li>
                                                @endif
                                                <li class="d-inline-block w-100">
                                                    <div class="addrs-icon">
                                                        <i class="fas fa-briefcase"></i>
                                                    </div>
                                                    <div class="add-info">
                                                        <span>Position: </span>{{$expertise->position}}
                                                    </div>
                                                </li>
                                                @if($expertise->category->cat_type == 1)
                                                    <li class="d-inline-block w-100">
                                                        <div class="addrs-icon">
                                                            <i class="fas fa-building"></i>
                                                        </div>
                                                        <div class="add-info">
                                                            <span>Office: </span>{{$expertise->office}}
                                                        </div>
                                                    </li>
                                                @endif
                                                <li class="d-inline-block w-100">
                                                    <div class="addrs-icon">
                                                        <i class="fas fa-envelope"></i>
                                                    </div>
                                                    <div class="add-info">
                                                        <span><a href = "mailto:{{$expertise->email}}">  {{$expertise->email}}</a></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @else
                                    <div class="section-title-2 mb-2  headline text-left">
                                        <h2><span> {{$expertise->office}}</span></h2>
                                    </div>

                                    <div class="teacher-address">
                                        <div class="address-details ul-li-block">
                                            <ul class="d-inline-block w-100">
                                                <li class="d-inline-block w-100">
                                                    <div class="addrs-icon">
                                                        <i class="fas fa-envelope"></i>
                                                    </div>
                                                    <div class="add-info">
                                                        <span>Get in Touch: </span><a href = "mailto:{{$expertise->email}}">  {{$expertise->email}}</a>
                                                    </div>
                                                </li>
                                                <li class="d-inline-block w-100">
                                                    <div class="addrs-icon">
                                                        <i class="fas fa-user-tag"></i>
                                                    </div>
                                                    <div class="add-info">
                                                        <span>SWDLNet Primary Representative: {{$expertise->first_name}} {{$expertise->middle_name}} {{$expertise->last_name}}</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="about-teacher mb45">
                        <!-- <div class="section-title-2  mb-0 headline text-left">
                            <h2>Details</h2>
                        </div> -->
                            <div class="row">
                                <div class="col-md-12">
                                    {!! $expertise->content !!}
                                </div>
                            </div>
                    </div>


                </div>

                <div class="col-md-4">
                    <div class="side-bar">
                    @if (auth()->user())
                    <div class="container border rounded" style="padding:30px;box-shadow: #959595 5px 5px 5px;border: 1px solid rgb(0 0 0 / 7%);">
                        <div class="section-title headline text-center">
                            <h5>Send A message to <strong>{{$expertise->first_name}} {{$expertise->middle_name}} {{$expertise->last_name}}</strong></h5>
                            <!-- <hr> -->
                        </div>
                        <div class="contact_third_form">
                            <form class="contact_form" id="contact_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input name="recipient_name" id="recipient_name" type="hidden" value= "{{$expertise->first_name}} {{$expertise->middle_name}} {{$expertise->last_name}}">
                                <input name="sender_name" id="sender_name" type="hidden" value= "{{auth()->user()->first_name}} {{auth()->user()->last_name}}">
                                <input name="recipient_email" id="recipient_email" type="hidden" value= "{{$expertise->email}}">
                                <input name="sender_email" id="sender_email" type="hidden" value= "{{auth()->user()->email}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="contact-info">
                                            <input name="subject" id="subject" type="text" placeholder="Enter Subject" value= "">
                                            <span class="help-block text-danger subject-text">{{$errors->first('subject')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea name="message" id="message" placeholder="@lang('labels.frontend.contact.message')"></textarea>
                                        <span class="help-block text-danger message-text">{{$errors->first('message')}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="contact-info mt-3 mb-12 text-center">
                                            {!! Captcha::display() !!}
                                            {{ html()->hidden('contact_captcha', 'true')->id('contact_captcha') }}
                                            <span id="login-captcha-error" class="g-recaptcha-response-text text-danger"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="nws-button text-center  gradient-bg text-uppercase">
                                            <button class="text-uppercase" type="submit" value="Submit"> Send Email <i class="fas fa-caret-right"></i></button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    @endif

                    <hr>
                    @if($recent_news->count() > 0)
                        <div class="side-bar-widget first-widget">
                            <h2 class="widget-title text-capitalize">@lang('labels.frontend.layouts.partials.recent_news')</h2>
                            <div class="latest-news-posts">
                                @foreach($recent_news as $item)
                                    <div class="latest-news-area">

                                        @if($item->image != "")
                                            <div class="latest-news-thumbnile relative-position"
                                                style="background-image: url({{asset('storage/uploads/'.$item->image)}})">
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
                                    <a href="{{route('blogs.index')}}">@lang('labels.frontend.layouts.partials.view_all_news') <i class="fas fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>

                    @endif

                    @if($global_featured_course != "")
                        <div class="side-bar-widget">
                            <h2 class="widget-title text-capitalize">@lang('labels.frontend.layouts.partials.featured_course')</h2>
                            <div class="featured-course">
                                <div class="best-course-pic-text relative-position pt-0">
                                    <div class="best-course-pic relative-position " style="background-image: url({{asset('storage/uploads/'.$global_featured_course->course_image)}})">
                                    </div>
                                    <div class="best-course-text" style="left: 0;right: 0;">
                                        <div class="course-title mb20 headline relative-position">
                                            <h3><a href="{{ route('courses.show', [$global_featured_course->slug]) }}">{{$global_featured_course->title}}</a></h3>
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
    </section>
    <!-- End  of teacher details area
        ============================================= -->

    <!-- Start of contact area form
        ============================================= -->
    <!-- @if (auth()->user())) -->
    <!-- <section id="contact-form" class="contact-form-area_3 contact-page-version">
        <div class="container">
            <div class="section-title mb45 headline text-center">
                <h3>Send A message to <strong>{{$expertise->first_name}} {{$expertise->middle_name}} {{$expertise->last_name}}</strong></h3>
            </div>

            <div class="contact_third_form">
                <form class="contact_form" id="contact_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="contact-info">
                                <input class="recipient_name" name="recipient_name" id="recipient_name" type="text" value= "{{$expertise->first_name}} {{$expertise->middle_name}} {{$expertise->last_name}}">
                                <input class="sender_name" name="sender_name" id="sender_name" type="text" value= "{{auth()->user()->first_name}} {{auth()->user()->last_name}}">
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="contact-info">
                                <input class="recipient_email" name="recipient_email" id="recipient_email" type="email" value= "{{$expertise->email}}">
                                <input class="sender_email" name="sender_email" id="sender_email" type="email" value= "{{auth()->user()->email}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="contact-info">
                                <input name="subject" id="subject" type="text" placeholder="Enter Subject" value= "">
                                <span class="help-block text-danger subject-text">{{$errors->first('subject')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <textarea name="message" id="message" placeholder="@lang('labels.frontend.contact.message')"></textarea>
                            <span class="help-block text-danger message-text">{{$errors->first('message')}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="contact-info mt-4 mb-12 text-center">
                                {!! Captcha::display() !!}
                                {{ html()->hidden('contact_captcha', 'true')->id('contact_captcha') }}
                                <span id="login-captcha-error" class="g-recaptcha-response-text text-danger"></span>
                            </div>
                        </div>

                    </div>

                    <div class="nws-button text-center  gradient-bg text-uppercase">
                        <button class="text-uppercase" type="submit" value="Submit"> Send Email <i class="fas fa-caret-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </section> -->
    <!-- @endif -->
<!-- End of contact area form
        ============================================= -->

@push('after-scripts')

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {
                $(document).on('submit', '#contact_form', function(e) {
                    showLoading();
                    $('.subject-text').html("");
                    $('.message-text').html("");
                    $('.g-recaptcha-response-text').html("");

                    e.preventDefault();
                    var $this = $(this);
                    var c = $('.g-recaptcha').length;
                    $.ajax({
                        type: $this.attr('method'),
                        url: "{{route('contact.sendToExpertise')}}",
                        data: $this.serializeArray(),
                        dataType: $this.data('type'),
                        success: function(data) {
                            for (var i = 0; i < c; i++) grecaptcha.reset(i);
                            if(data.success){
                                document.getElementById("subject").value = "";
                                document.getElementById("message").value = "";
                                Swal.fire(data.message)
                            }else{
                                $('.subject-text').html(data.errors['subject']);
                                $('.message-text').html(data.errors['message']);
                                $('.g-recaptcha-response-text').html(data.errors['g-recaptcha-response']);
                                closeLoading();
                            }
                        },
                        error: function(jqXHR) {
                            
                            for (var i = 0; i < c; i++) grecaptcha.reset(i);

                            var response = $.parseJSON(jqXHR.responseText);

                            $('.subject-text').html(response.errors.phone);
                            $('.message-text').html(response.errors.message);
                            $('.g-recaptcha-response-text').html(response.errors['g-recaptcha-response']);
                            closeLoading();
                        },
                    });
                });
            });
        });
    </script>

@endpush


@endsection