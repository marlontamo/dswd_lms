@extends('frontend'.(session()->get('display_type') == "rtl"?"-rtl":"").'.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.passwords.reset_password_box_title'))

@section('content')
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">{{__('labels.frontend.passwords.reset_password_box_title')}}</h2>
                </div>
            </div>
        </div>
    </section>
    <section id="about-page" class="about-page-section pb-0">
        <div class="row justify-content-center align-items-center">
            <div class="col col-md-4 align-self-center">
                <div class="card border-0">

                    <div class="card-body">

                        <!-- @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif -->

                        <span class="email-error-response text-danger"></span>
                        <span class="email-success-response text-success"></span>

                        <!-- {{ html()->form('POST', route('frontend.auth.password.email.post'))->open() }} -->
                        <form id="email_form" class="email_form"  action="{{route('frontend.auth.password.email.post')}}"  method="post">
                        
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->email('email')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.email'))
                                        ->attribute('maxlength', 191)
                                        ->required()
                                        ->autofocus() }}
                                        
                                    <span id="email-error" class="email-error text-danger"></span>
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col">
                                <div class="form-group mt-3 text-center">
                                    {!! Captcha::display() !!}
                                    {{ html()->hidden('captcha_status', 'true')->id('captcha_status') }}
                                    <span id="email-captcha-error" name = "email-captcha-error" class="text-danger email-captcha-error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-0 clearfix">
                                    <div class="text-center  text-capitalize">
                                        <button id="emailButton" type="submit" class="nws-button btn-info btn " value="Submit">
                                                {{__('labels.frontend.passwords.send_password_reset_link_button')}}
                                                
                                                <img class="loading-icon " style="display:none" src="{{asset('assets/img/loading.gif')}}" alt="">
                                        </button>
                                    </div>
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        </form>
                        <!-- {{ html()->form()->close() }} -->
                    </div><!-- card-body -->
                </div><!-- card -->
            </div><!-- col-6 -->
        </div><!-- row -->
    </section>
@endsection

@push('after-scripts')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {
        $(document).ready(function() {
            
            var formsubmit = false;
            $('#email_form').on('submit', function(e) {

                if (formsubmit)
                    return false;
                formsubmit = true;
                e.preventDefault();
                var $this = $(this);
                //$("#emailButton").attr('disabled');
                document.getElementById("emailButton").disabled = true;
                $('.loading-icon').css('display', 'inline');
                $('.email-success-response').empty();
                $('.email-error-response').empty();
                $('.email-captcha-error').empty();
                var c = $('.g-recaptcha').length;
                $.ajax({
                    type: $this.attr('method'),
                    url: $this.attr('action'),
                    data: $this.serializeArray(),
                    dataType: $this.data('type'),
                    success: function(response) {
                        $('.email-captcha-error').empty();
                        $('.email-error').empty();
                        //Reset Captcha
                        for (var i = 0; i < c; i++) grecaptcha.reset(i);

                        if (response.errors) {
                            if (response.errors.email) {
                                $('.email-error').html(response.errors.email[0]);
                            }
                            var captcha = "g-recaptcha-response";
                            if (response.errors[captcha]) {
                                $('.email-captcha-error').empty().html(response.errors[captcha][0]);
                            }
                        }
                        if (response.success) {
                            $('#email_form')[0].reset();
                            $('.email-success-response').empty().html("Please check your email for the reset password link.");
                        }else{
                            $('.email-error-response').empty().html(response.message)
                        }
                    },
                    error: function(jqXHR) {
                        //grecaptcha.reset();
                        
                        //Reset Captcha
                        for (var i = 0; i < c; i++) grecaptcha.reset(i);

                        var response = $.parseJSON(jqXHR.responseText);
                        console.log(jqXHR)
                        if (response.message) {
                            $('.error-response').empty().html(response.message)
                        }
                    },
                    complete: function() {
                        setTimeout(() => {
                            formsubmit = false;
                            //$("#emailbutton").removeAttr('disabled');
                            
                            document.getElementById("emailButton").disabled = false;
                            $('.loading-icon').css('display', 'none');
                        }, 500);

                    }
                });
            });

        })
    })
</script>

@endpush


