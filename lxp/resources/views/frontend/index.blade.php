@extends('frontend.layouts.app')
@php $no_footer = true; @endphp

@section('title', trans('labels.frontend.home.title').' | '.app_name())
@section('meta_description', '')
@section('meta_keywords','')

@push("after-styles")
    <style>
        #search-course {
            padding-bottom: 125px;
        }
        .my-alert{
            position: absolute;
            z-index: 10;
            left: 0;
            right: 0;
            top: 25%;
            width: 50%;
            margin: auto;
            display: inline-block;
        }

        #search-course select{
            background-color: #4273e1!important;
            color: white!important;
        }
    </style>
@endpush
@php
    $footer_data = json_decode(config('footer_data'));
@endphp
@section('content')
    @if(session()->has('alert'))
        <div class="alert alert-light alert-dismissible fade my-alert show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>{{session('alert')}}</strong>
        </div>
    @endif

    <!-- Start of slider section
     ============================================= -->
    @include('frontend.layouts.partials.slider')

    <!-- End of slider section
            ============================================= -->


    @if($sections->featured_courses->status == 1)
        <!-- Start of best course
        ============================================= -->
        @include('frontend.layouts.partials.browse_courses')
        <!-- End of best course
            ============================================= -->
    @endif

    @if($sections->search_section->status == 1)
        <!-- Start of Search Courses
    ============================================= -->
        <section id="search-course" class="search-course-section home-secound-course-search backgroud-style">
            <div class="container">
                <div class="section-title mb20 headline text-center">
                    <span class="subtitle text-uppercase">@lang('labels.frontend.home.learn_new_skills')</span>
                    <h2>@lang('labels.frontend.home.search_courses')</h2>
                </div>
                <div class="search-course mb30 relative-position">
                    <form action="{{route('search')}}" method="get">
                        <div class="input-group search-group">
                            <input class="course" name="q" type="text" placeholder="@lang('labels.frontend.home.search_course_placeholder')">

                            <select name="category" class="select form-control">
                                @if(count($categories) > 0 )
                                    <option value="">@lang('labels.frontend.course.select_category')</option>
                                    @foreach($categories as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>

                                    @endforeach
                                @else
                                    <option>>@lang('labels.frontend.home.no_data_available')</option>
                                @endif

                            </select>
                            <div class="nws-button position-relative text-center  gradient-bg text-capitalize">
                                <button type="submit" value="Submit">@lang('labels.frontend.home.search_course')</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="search-counter-up">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="counter-icon-number ">
                                <div class="counter-icon">
                                    <i class="text-gradiant flaticon-book"></i>
                                </div>
                                <div class="counter-number">
                                    <span class=" bold-font">{{$total_courses}}</span>
                                    <p>@lang('labels.frontend.home.online_available_courses')</p>
                                </div>
                            </div>
                        </div>
                        <!-- /counter -->

                    </div>
                </div>
            </div>
        </section>
        <!-- End of Search Courses
            ============================================= -->
    @endif

    <footer>
        <section id="footer-area" class="footer_2 backgroud-style">
            <div class="container">
                <div class="footer-content pb10">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="footer-widget text-center">
                                <div class="back-top text-center mb45">
                                    <a class="scrollup" href="#"><img src={{asset("assets/img/banner/bt.png")}} alt=""></a>
                                </div>
                                <div class="footer-logo mb35">
                                    <img src="{{asset("storage/logos/".config('logo_b_image'))}}" alt="logo">
                                </div>
                                @if($footer_data->short_description->status == 1)
                                    <div class="footer-about-text">
                                        <p>{!! $footer_data->short_description->text !!} </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="copy-right-menu">
                    <div class="row">
                        @if($footer_data->copyright_text->status == 1)
                        <div class="col-md-6">
                            <div class="copy-right-text" style = "color: black !important;">
                                <p>Powered By <a href="https://car.dswd.gov.ph/" target="_blank" class="mr-4"> DSWD FOCAR ICTS | CBS</a>  {!!  $footer_data->copyright_text->text !!}</p>
                            </div>
                        </div>
                        @endif
                        @if(($footer_data->bottom_footer_links->status == 1) && (count($footer_data->bottom_footer_links->links) > 0))
                        <div class="col-md-6">
                            <div class="copy-right-menu-item float-right ul-li" >
                                <ul>
                                    @foreach($footer_data->bottom_footer_links->links as $item)
                                    <li  style = "color: black !important;"><a href="{{$item->link}}">{{$item->label}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </footer>

@endsection

@push('after-scripts')
    <script>
        $('ul.product-tab').find('li:first').addClass('active');
    </script>
@endpush