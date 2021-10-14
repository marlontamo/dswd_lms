@extends('frontend.layouts.app')

@section('title', 'Contact | '.app_name())
@section('meta_description', '')
@section('meta_keywords','')

@push('after-styles')
<style>
    .my-alert {
        position: absolute;
        z-index: 10;
        left: 0;
        right: 0;
        top: 25%;
        width: 50%;
        margin: auto;
        display: inline-block;
    }
</style>
@endpush

@section('content')

@if(session()->has('alert'))
<div class="alert alert-light alert-dismissible fade my-alert show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>{{session('alert')}}</strong>
</div>
@endif

<!-- Start of breadcrumb section
        ============================================= -->
<section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
    <div class="blakish-overlay"></div>
    <div class="container">
        <div class="page-breadcrumb-content text-center">
            <div class="page-breadcrumb-title">
                <h2 class="breadcrumb-head black bold">{{env('APP_NAME')}} <span> @lang('labels.frontend.contact.title')</span></h2>
            </div>
        </div>
    </div>
</section>
<!-- End of breadcrumb section
        ============================================= -->

<!-- Start of contact area form
        ============================================= -->
<section id="contact-form" class="contact-form-area_3 contact-page-version">
    <div class="container">
        <div class="section-title mb45 headline text-center">
            <h2>@lang('labels.frontend.contact.send_us_a_message')</h2>
        </div>

        <div class="contact_third_form">
            <form class="contact_form" id="contact_form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="contact-info">
                            <input class="name" name="name" id="name" type="text" placeholder="@lang('labels.frontend.contact.your_name')">
                            <span class="help-block text-danger name-text">{{$errors->first('name')}}</span>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="contact-info">
                            <input class="email" name="email" id="email_val" type="email" placeholder="@lang('labels.frontend.contact.your_email')">
                            <span class="help-block text-danger email-text">{{$errors->first('email')}}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-info">
                            <input class="number" name="phone" id="phone" type="number" placeholder="@lang('labels.frontend.contact.phone_number')">
                            <span class="help-block text-danger phone-text">{{$errors->first('phone')}}</span>
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
                    <button class="text-uppercase" type="submit" value="Submit">@lang('labels.frontend.contact.send_email') <i class="fas fa-caret-right"></i></button>
                </div>
            </form>
        </div>
    </div>
</section>

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
                $('.name-text').html("");
                $('.email-text').html("");
                $('.phone-text').html("");
                $('.message-text').html("");
                $('.g-recaptcha-response-text').html("");

                e.preventDefault();
                var $this = $(this);
                var c = $('.g-recaptcha').length;
                $.ajax({
                    type: $this.attr('method'),
                    url: "{{route('contact.send')}}",
                    data: $this.serializeArray(),
                    dataType: $this.data('type'),
                    success: function(data) {
                        //grecaptcha.reset(2);
                        for (var i = 0; i < c; i++) grecaptcha.reset(i);

                        console.log(data);

                        document.getElementById("email_val").value = "";
                        document.getElementById("name").value = "";
                        document.getElementById("phone").value = "";
                        document.getElementById("message").value = "";

                        Swal.fire(data.message)
                        // alert(data.message);
                        // closeLoading();

                    },
                    error: function(jqXHR) {
                        
                        for (var i = 0; i < c; i++) grecaptcha.reset(i);

                        var response = $.parseJSON(jqXHR.responseText);
                        console.log(response)
                        $('.name-text').html(response.errors.name);
                        $('.email-text').html(response.errors.email);
                        $('.phone-text').html(response.errors.phone);
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
<!-- End of contact area form
        ============================================= -->


<!-- Start of contact area
        ============================================= -->
@include('frontend.layouts.partials.contact_area')
<!-- End of contact area
        ============================================= -->


@endsection