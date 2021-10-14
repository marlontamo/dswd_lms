<style>
    .modal-dialog {
        margin: 1.75em auto;
        min-height: calc(100vh - 60px);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    #myModal .close {
        position: absolute;
        right: 0.3rem;
    }

    .g-recaptcha div {
        margin: auto;
    }

    .modal-body .contact_form input[type='radio'] {
        width: auto;
        height: auto;
    }

    .modal-body .contact_form textarea {
        background-color: #eeeeee;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 10px;
        width: 100%;
        border: none
    }

    @media (max-width: 768px) {
        .modal-dialog {
            min-height: calc(100vh - 20px);
        }

        #myModal .modal-body {
            padding: 15px;
        }
    }

    #privacyCheck {
        height: 20px;
        width: 20px;
        display: inline-block;
        vertical-align: -4px;
    }
</style>
@if(!auth()->check())

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <!-- Modal Header -->
            <div class="modal-header backgroud-style">

                <div class="gradient-bg"></div>
                <div class="popup-logo">
                    <img src="{{asset("storage/logos/".config('logo_popup'))}}" alt="">
                </div>
                <div class="popup-text text-center">
                     
                    <h2><a href="#" class="font-weight-bold go-login px-0">LOGIN</a> | <a href="#" class="font-weight-bold go-register px-0" id="">REGISTER</a></h2>
                    <!-- <p><a href="#" class="font-weight-bold go-login px-0">LOGIN</a> or <a href="#" class="font-weight-bold go-register px-0" id="">REGISTER</a></p> -->
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="tab-content">
                    <div class="tab-pane container active" id="login">

                        <span class="error-response text-danger"></span>
                        <span class="success-response text-success">{{(session()->get('flash_success'))}}</span>
                        <form class="contact_form" id="loginForm" action="{{route('frontend.auth.login.post')}}" method="POST" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <a href="#" class="go-register float-left text-info pl-0">
                                New User? Register Here
                            </a>
                            <!-- <div class="contact-info mb-2">
                                    {{ html()->email('email')
                                        ->class('form-control mb-0')
                                        ->placeholder(__('validation.attributes.frontend.email'))
                                        ->attribute('maxlength', 191)
                                        }}
                                    <span id="login-email-error" class="text-danger"></span>

                                </div> -->

                            <div class="contact-info mb-2">
                                {{ html()->text('username')
                                        ->class('form-control mb-0')
                                        ->placeholder('Username')
                                        ->attribute('maxlength', 191)
                                    }}
                                <span id="login-username-error" class="text-danger"></span>
                            </div>


                            <div class="contact-info mb-2">
                                {{ html()->password('password')
                                                     ->class('form-control mb-0')
                                                     ->placeholder(__('validation.attributes.frontend.password'))
                                                    }}
                                <span id="login-password-error" class="text-danger"></span>

                                <a class="text-info p-0 d-block text-right my-2" href="{{ route('frontend.auth.password.reset') }}">Forgot Your Password?</a>

                            </div>

                            @if(config('access.captcha.registration'))
                            <div class="contact-info mb-2 text-center">
                                {!! Captcha::display() !!}
                                {{ html()->hidden('captcha_status', 'true') }}
                                <span id="login-captcha-error" class="text-danger"></span>

                            </div>
                            <!--col-->
                            @endif

                            <div class="nws-button text-center white text-capitalize">
                                <button  id="login_button"  name="login_button" type="submit" value="Submit">
                                    LogIn Now
                                    <img class="loading-icon " style="display:none" src="{{asset('assets/img/loading.gif')}}" alt="">
                                </button>
                            </div>

                        </form>

                        <div id="socialLinks" class="text-center">
                        </div>

                    </div>
                    <div class="tab-pane container fade" id="register">
                        <span class="register-error text-danger"></span>
                        <form id="registerForm" class="contact_form" action="#" method="post">
                       
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="#" class="go-login float-right text-info pr-0">Already a user? Login Here</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="contact-info mb-2">
                                        {{ html()->text('first_name')->class('form-control mb-0')->placeholder('First Name')->attribute('maxlength', 191) }}
                                        <span id="first-name-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="contact-info mb-2">
                                        {{ html()->text('middle_name')->class('form-control mb-0')->placeholder('Middle Name')->attribute('maxlength', 191) }}
                                        <span id="middle-name-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="contact-info mb-2">
                                        {{ html()->text('last_name')->class('form-control mb-0')->placeholder('Last Name')->attribute('maxlength', 191) }}
                                        <span id="last-name-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="contact-info mb-2">
                                        {{ html()->email('email')->class('form-control mb-0')->placeholder('Email')->attribute('maxlength', 191) }}
                                        <span id="email-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="contact-info mb-2">
                                        {{ html()->text('username')->class('form-control mb-0')->placeholder('Username')->attribute('maxlength', 191) }}
                                        <span id="username-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="contact-info mb-2">
                                        {{ html()->password('password')->class('form-control mb-0')->placeholder('Password') }}
                                        <span id="password-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="contact-info mb-2">
                                        {{ html()->password('password_confirmation')->class('form-control mb-0')->placeholder('Password Confirmation') }}
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <label>Type of User: </label>
                                    <div>
                                        <select class="form-control" name="user_type" id="userType">
                                            <option value="">Select Type</option>
                                            <option value="internal">Internal (DSWD Personnel)</option>
                                            <option value="external">External (Intermediaries)</option>
                                        </select>
                                        <span id="user-type-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Position: </label>
                                    <div>
                                        <input type="text" class="form-control" name="position" id="position">
                                        <span id="position-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <label>Date of Birth: </label>
                                    <div class="contact-info mb-2">
                                        <input type="date" class="form-control mb-0" value="dob" name="dob" placeholder="dob">
                                        <span id="dob-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-5 ">
                                    <label>Phone: </label>
                                    <div>
                                        <input type="number" value="phone" name="phone" placeholder="Phone">
                                        <span id="phone-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-3 ">
                                    <label>Sex: </label>
                                    <div class="contact-info mb-2">
                                        <select class="form-control" name="gender" id="gender" placeholder="gender">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        <span id="gender-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Region: </label>
                                    <div>
                                        <select class="form-control" name="state" id="state">
                                            <option value="">Select Region</option>
                                        </select>
                                        <span id="state-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Province: </label>
                                    <div>
                                        <select class="form-control" name="province" id="province">
                                            <option value="">Select Province</option>
                                        </select>
                                        <span id="province-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Municipality: </label>
                                    <div>
                                        <select class="form-control" name="city" id="city">
                                            <option value="">Select Municipality/City</option>
                                        </select>
                                        <span id="city-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                        <label>Barangay: </label>
                                        <div> 
                                            <select class="form-control" name="barangay" id="barangay">
                                                <option value="">Select Barangay</option>
                                            </select>
                                            <span id="barangay-error" class="text-danger"></span>
                                        </div>
                                    </div> -->
                                <div class="col-md-12">
                                    <label>Address: </label>
                                    <div>
                                        <input type="text" class="form-control" name="address" id="address">
                                        <span id="address-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12 mt-2 border-top border-secondary">
                                    <label class="mt-2">Data Privacy Act (DPA) of 2012: </label>
                                    <div style="font-size: 13px;">
                                        <input type="checkbox" name="privacy" id="privacyCheck">
                                        <label for="privacyCheck" class="d-inline">
                                            In compliance with Republic Act No. 10173 or the Data Privacy Act (DPA) of 2012 and its Implementing Rules and Regulation (IRR), I hereby agree and give my consent to DSWD to collect, use, process, update, store, and disclose my personal information. Further, I authorized the DSWD for controlled disclosure or transfer of my personal data to its development partners, evaluation firms, academe and other stakeholders in accordance with the Data Sharing Protocols of the Program and the provisions of the DPA of 2012.
                                        </label>
                                    </div>
                                    <span id="privacy-check-error" class="text-danger"></span>
                                </div>
                            </div>

                            @if(config('access.captcha.registration'))
                            <div class="contact-info mt-3 text-center">
                                {!! Captcha::display() !!}
                                {{ html()->hidden('captcha_status', 'true')->id('captcha_status') }}
                                <span id="captcha-error" class="text-danger"></span>
                            </div>
                            <!--col-->
                            @endif

                            <div class="contact-info mb-2 mx-auto w-50 py-4">
                                <div class="nws-button text-center white text-capitalize">
                                    <button id="registerButton" type="submit" value="Submit">
                                        Register Now
                                        <img class="reg-loading-icon " style="display:none" src="{{asset('assets/img/loading.gif')}}" alt="">
                                    </button>
                                    <span class="register-error_1 text-danger"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@push('after-scripts')
@if (session('openModel'))
<script>
    $('#myModal').modal('show');
</script>
@endif


@if(config('access.captcha.registration'))
{!! Captcha::script() !!}
@endif

<script>
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $(document).on('click', '.go-login', function() {
                $('#register').removeClass('active').addClass('fade')
                $('#login').addClass('active').removeClass('fade')

            });
            $(document).on('click', '.go-register', function() {
                $('#login').removeClass('active').addClass('fade')
                $('#register').addClass('active').removeClass('fade')
            });

            $(document).on('click', '#openLoginModal', function(e) {
                $.ajax({
                    type: "GET",
                    url: "{{route('frontend.auth.login')}}",
                    success: function(response) {
                        $('#socialLinks').html(response.socialLinks)
                        $('#myModal').modal('show');
                    },
                });
            });

            let regions = "<option value=''>Select Region</option>";
            let provinces = "<option value=''>Select Province</option>";
            $.ajax({
                type: "GET",
                url: "{{route('get.car')}}",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $.each(response.region, function(i, v) {
                            if (v.region_code == "140000000") {
                                regions += "<option value='" + v.region_code + "' selected>" + v.region_name + "</option>";
                            } else {
                                regions += "<option value='" + v.region_code + "'>" + v.region_name + "</option>";
                            }
                        });

                        $.each(response.province, function(i, v) {
                            provinces += "<option value='" + v.province_code + "'>" + v.province_name + "</option>";
                        });

                        $("#state").html(regions);
                        $("#province").html(provinces);
                    }
                },
            });



            $(document).on("change", "#state", function() {
                let region_code = $(this).val();
                let state_data = {
                    'region_code': region_code
                };
                let province = "<option value=''>Select Province</option>";
                let municipalities = "<option value=''>Select Municipality</option>";
                // let barangay = "<option value=''>Select Barangay</option>";

                $.ajax({
                    type: "GET",
                    url: "{{route('get.province')}}",
                    data: state_data,
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $.each(response.data, function(i, v) {
                                province += "<option value='" + v.province_code + "''>" + v.province_name + "</option>";
                            });

                            $("#province").html(province);
                            $("#city").html(municipalities);
                            // $("#barangay").html(barangay);
                        }
                    },
                });
            });

            $(document).on("change", "#province", function() {
                let prov_code = $(this).val();
                let prov_data = {
                    'prov_code': prov_code
                };
                let municipalities = "<option value=''>Select Municipality</option>";
                // let barangay = "<option value=''>Select Barangay</option>";

                $.ajax({
                    type: "GET",
                    url: "{{route('get.municipalities')}}",
                    data: prov_data,
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $.each(response.data, function(i, v) {
                                municipalities += "<option value='" + v.city_code + "''>" + v.city_name + "</option>";
                            });

                            $("#city").html(municipalities);
                            // $("#barangay").html(barangay);
                        }
                    },
                });
            });

            // $(document).on("change","#city",function(){
            //     let city_code = $(this).val();
            //     let city_data = {'city_code':city_code};
            //     let barangay = "<option value=''>Select Barangay</option>";

            //     $.ajax({
            //         type: "POST",
            //         url: "{{route('get.barangays')}}",
            //         data: city_data,
            //         dataType: "json",
            //         success: function (response) {
            //             if(response.success)
            //             {
            //                 $.each(response.data,function(i,v){
            //                     barangay += "<option value='"+v.barangay_code+"''>"+v.barangay_name+"</option>";
            //                 });

            //                 $("#barangay").html(barangay);
            //             }
            //         },
            //     });
            // });


            var formsubmit = false;
            $('#loginForm').on('submit', function(e) {

                if (formsubmit)
                    return false;
                formsubmit = true;
                e.preventDefault();
                var $this = $(this);
                //$("#login_button").attr('disabled');
                document.getElementById("login_button").disabled = true;
                $('.loading-icon').css('display', 'inline');
                $('.success-response').empty();
                $('.error-response').empty();
                $('#login-captcha-error').html('');
                var c = $('.g-recaptcha').length;
                $.ajax({
                    type: $this.attr('method'),
                    url: $this.attr('action'),
                    data: $this.serializeArray(),
                    dataType: $this.data('type'),
                    success: function(response) {
                        // $('#login-email-error').empty();
                        $('#login-username-error').empty();
                        $('#login-password-error').empty();
                        $('#login-captcha-error').empty();

                        if (response.errors) {
                            
                            //Reset Captcha
                            for (var i = 0; i < c; i++) grecaptcha.reset(i);

                            console.log(response.errors[captcha])
                            if (response.errors.username) {
                                // $('#login-email-error').html(response.errors.email[0]);
                                $('#login-username-error').html(response.errors.username[0]);

                            }
                            if (response.errors.password) {
                                $('#login-password-error').html(response.errors.password[0]);


                            }

                            var captcha = "g-recaptcha-response";
                            if (response.errors[captcha]) {
                                $('#login-captcha-error').html(response.errors[captcha][0]);
                            }
                        }
                        if (response.success) {
                            $('#loginForm')[0].reset();
                            if (response.redirect == 'back') {
                                location.reload();
                            } else {
                                window.location.href = "{{route('admin.dashboard')}}"
                            }
                        }else{
                            if (response.message) {
                                $('#login').find('span.error-response').html(response.message)
                            }
                        }
                    },
                    error: function(jqXHR) {
                        //grecaptcha.reset();
                        
                        //Reset Captcha
                        for (var i = 0; i < c; i++) grecaptcha.reset(i);

                        var response = $.parseJSON(jqXHR.responseText);
                        console.log(jqXHR)
                        if (response.message) {
                            $('#login').find('span.error-response').html(response.message)
                        }
                    },
                    complete: function() {
                        setTimeout(() => {
                            formsubmit = false;
                            //$("#login_button").removeAttr('disabled');
                            document.getElementById("login_button").disabled = false;
                            $('.loading-icon').css('display', 'none');
                        }, 500);

                    }
                });
            });

            $(document).on('submit', '#registerForm', function(e) {
                e.preventDefault();
                var $this = $(this);
                
                //$("#registerButton").attr('disabled');
                document.getElementById("registerButton").disabled = true;
                $('.reg-loading-icon').css('display', 'inline');

                var c = $('.g-recaptcha').length;
                $.ajax({
                    type: $this.attr('method'),
                    url: "{{  route('frontend.auth.register.post')}}",
                    data: $this.serializeArray(),
                    dataType: $this.data('type'),
                    success: function(data) {
                        $('#first-name-error').empty()
                        $('#last-name-error').empty()
                        $('#dob-error').empty()
                        $('#phone-error').empty()
                        $('#gender-error').empty()
                        $('#address-error').empty()
                        $('#email-error').empty()
                        $('#username-error').empty()
                        $('#password-error').empty()
                        $('#state-error').empty()
                        $('#province-error').empty()
                        $('#city-error').empty()
                        //$('#barangay-error').empty()
                        $('#captcha-error').empty()
                        $('#user-type-error').empty()
                        $('#position-error').empty()
                        $('#privacy-check-error').empty()
                        $('.register-error').empty();
                        $('.register-error_1').empty();

                        if (data.errors) {
                            
                            if (data.errors.first_name) {
                                $('#first-name-error').html(data.errors.first_name[0]);
                            }
                            if (data.errors.last_name) {
                                $('#last-name-error').html(data.errors.last_name[0]);
                            }
                            if (data.errors.dob) {
                                $('#dob-error').html(data.errors.dob[0]);
                            }
                            if (data.errors.phone) {
                                $('#phone-error').html(data.errors.phone[0]);
                            }
                            if (data.errors.gender) {
                                $('#gender-error').html(data.errors.gender[0]);
                            }
                            if (data.errors.address) {
                                $('#address-error').html(data.errors.address[0]);
                            }
                            if (data.errors.email) {
                                $('#email-error').html(data.errors.email[0]);
                            }
                            if (data.errors.username) {
                                $('#username-error').html(data.errors.username[0]);
                            }
                            if (data.errors.password) {
                                $('#password-error').html(data.errors.password[0]);
                            }

                            if (data.errors.state) {
                                $('#state-error').html(data.errors.state[0]);
                            }

                            if (data.errors.province) {
                                $('#province-error').html(data.errors.province[0]);
                            }

                            if (data.errors.city) {
                                $('#city-error').html(data.errors.city[0]);
                            }

                            // if (data.errors.barangay) {
                            //     $('#barangay-error').html(data.errors.barangay[0]);
                            // }
                            if (data.errors.position) {
                                $('#position-error').html(data.errors.position[0]);
                            }

                            if (data.errors.privacy) {
                                $('#privacy-check-error').html(data.errors.privacy[0]);
                            }

                            if (data.errors.user_type) {
                                $('#user-type-error').html(data.errors.user_type[0]);
                            }

                            var captcha = "g-recaptcha-response";
                            if (data.errors[captcha]) {
                                $('#captcha-error').html(data.errors[captcha][0]);
                            }
                        }
                        if (data.success) {
                            $('#registerForm')[0].reset();
                            $('#register').removeClass('active').addClass('fade');
                            $('.error-response').empty();
                            $('.register-error').empty();
                            $('.register-error_1').empty();
                            $('#login').addClass('active').removeClass('fade');
                            $('.success-response').empty().html("User Registration Successfull. Please Wait for your confirmation email once your account is activated by admin.");
                        }else{
                            console.log(data);
                            //Reset Captcha
                            for (var i = 0; i < c; i++) grecaptcha.reset(i);
                            $('.register-error').empty().html(data.message);
                            $('.register-error_1').empty().html(data.message);
                        }
                    },
                    error: function(jqXHR) {
                        //Reset Captcha
                        for (var i = 0; i < c; i++) grecaptcha.reset(i);
                        $('.register-error').empty().html("Registration Failed");
                        $('.register-error_1').empty().html("Registration Failed");
                        
                    },
                    complete: function() {
                        setTimeout(() => {
                            formsubmit = false;
                            //$("#registerButton").removeAttr('disabled');
                            document.getElementById("registerButton").disabled = false;
                            $('.reg-loading-icon').css('display', 'none');
                        }, 500);

                    }
                });
            });
        });

    });
</script>
@endpush