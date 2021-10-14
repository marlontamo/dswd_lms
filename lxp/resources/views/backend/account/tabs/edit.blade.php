{{ html()->modelForm($logged_in_user, 'PATCH', route('admin.profile.update'))->class('form-horizontal')->attribute('enctype', 'multipart/form-data')->open() }}
<div class="row">
    <div class="col">
        <div class="form-group">
            {{ html()->label(__('validation.attributes.frontend.avatar'))->for('avatar') }}

            <div>
                <input type="radio" name="avatar_type"
                       value="gravatar" {{ $logged_in_user->avatar_type == 'gravatar' ? 'checked' : '' }} /> {{__('validation.attributes.frontend.gravatar')}}
                &nbsp;&nbsp;
                <input type="radio" name="avatar_type"
                       value="storage" {{ $logged_in_user->avatar_type == 'storage' ? 'checked' : '' }} /> {{__('validation.attributes.frontend.upload')}}
            </div>
        </div><!--form-group-->

        <div class="form-group hidden" id="avatar_location">
            {{ html()->file('avatar_location')->class('form-control') }}
        </div><!--form-group-->

    </div><!--col-->
</div><!--row-->

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {{ html()->label('First Name')->for('first_name') }}
            {{ html()->text('first_name')->class('form-control')->placeholder('First Name')->attribute('maxlength', 191)->required()->autofocus() }}
        </div><!--form-group-->
    </div><!--col-->
    <div class="col-md-4">
        <div class="form-group">
            {{ html()->label('Middle Name')->for('middle_name') }}
            {{ html()->text('middle_name')->class('form-control')->placeholder('Middle Name')->attribute('maxlength', 191)->autofocus() }}
        </div><!--form-group-->
    </div><!--col-->
    <div class="col-md-4">
        <div class="form-group">
            {{ html()->label('Last Name')->for('last_name') }}
            {{ html()->text('last_name')->class('form-control')->placeholder('Last Name')->attribute('maxlength', 191)->required() }}
        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->


<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <div>
                {{ html()->label('Sex: ')->for('gender') }} <br>
                <label class="radio-inline mr-3 mb-0">
                    <input type="radio" name="gender" value="male" {{ $logged_in_user->gender == 'male'?'checked':'' }}> {{__('validation.attributes.frontend.male')}}
                </label>
                <label class="radio-inline mr-3 mb-0">
                    <input type="radio" name="gender" value="female" {{ $logged_in_user->gender == 'female'?'checked':'' }}> {{__('validation.attributes.frontend.female')}}
                </label>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            {{ html()->label('Mobile Number')->for('phone') }} 
            <input type="number" class="form-control" value="{{ $logged_in_user->phone }}" name="phone" placeholder="Mobile Number">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ html()->label('Date of Birth')->for('dob') }} 
            <input type="date" class="form-control" value="{{ $logged_in_user->dob }}" name="dob" placeholder="DOB">
        </div>
    </div>
</div>

<div class = "row">
    <div class="col-md-6 ">
        <label>Type of User: </label>
        <div> 
            <select class="form-control" name="user_type" id="userType">
                <option value="">Select Type</option>
                <option value="internal" "@if($logged_in_user->user_type == 'internal') selected @endif">Internal (DSWD Personnel)</option>
                <option value="external" "@if($logged_in_user->user_type == 'external') selected @endif">External (Intermediaries)</option>
            </select>
            <span id="user-type-error" class="text-danger"></span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ html()->label('Position:')->for('position') }} 
            <input type="text" class="form-control" value="{{ $logged_in_user->position }}" name="position" placeholder="Position">
        </div>
    </div>
</div>

<div class = "row">
    <div class="col-md-4">
        <input type="hidden" value="{{ $logged_in_user->state }}" name="reg_code"  id="reg_code" placeholder="reg_code">
        <label>Region: </label>
        <div> 
            <select class="form-control" name="state" id="state">
                <option value="">Select Region</option>
            </select>
            <span id="state-error" class="text-danger"></span>
        </div>
    </div>
    <div class="col-md-4">
        <input type="hidden" value="{{ $logged_in_user->province }}" name="prov_code" id="prov_code" placeholder="prov_code">
        <label>Province: </label>
        <div> 
            <select class="form-control" name="province" id="province">
                <option value="">Select Province</option>
            </select>
            <span id="province-error" class="text-danger"></span>
        </div>
    </div>
    <div class="col-md-4">
        <input type="hidden" value="{{ $logged_in_user->city }}" name="mun_code" id="mun_code" placeholder="mun_code">
        <label>Municipality: </label>
        <div> 
            <select class="form-control" name="city" id="city">
                <option value="">Select Municipality/City</option>
            </select>
            <span id="city-error" class="text-danger"></span>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {{ html()->label('Address')->for('address') }} 
            <textarea name="address" placeholder="Address"  class="form-control mb-0">{{ $logged_in_user->address }}</textarea>
        </div>
    </div>
</div>

@if ($logged_in_user->canChangeEmail())
    <div class="row">
        <div class="col">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> @lang('strings.frontend.user.change_email_notice')
            </div>

            <div class="form-group">
                {{ html()->label(__('validation.attributes.frontend.email'))->for('email') }}

                {{ html()->email('email')
                    ->class('form-control')
                    ->placeholder(__('validation.attributes.frontend.email'))
                    ->attribute('maxlength', 191)
                    ->required() }}
            </div><!--form-group-->
        </div><!--col-->
    </div><!--row-->
@endif

<div class="row">
    <div class="col">
        <div class="form-group mb-0 clearfix">
            {{ form_submit(__('labels.general.buttons.update')) }}
        </div><!--form-group-->
    </div><!--col-->
</div><!--row-->
{{ html()->closeModelForm() }}

@push('after-scripts')
    <script>
        $(function () {
            var avatar_location = $("#avatar_location");

            if ($('input[name=avatar_type]:checked').val() === 'storage') {
                avatar_location.show();
            } else {
                avatar_location.hide();
            }

            $('input[name=avatar_type]').change(function () {
                if ($(this).val() === 'storage') {
                    avatar_location.show();
                } else {
                    avatar_location.hide();
                }
            });

            
            $(document).ready(function () {
                let regions = "<option value=''>Select Region</option>";
                let provinces = "<option value=''>Select Province</option>";
                let municipality = "<option value=''>Select Municipality</option>";

                let reg_code = $("#reg_code").val();
                let prov_code = $("#prov_code").val();
                let mun_code = $("#mun_code").val();
                let old_data = {'reg_code':reg_code, 'prov_code':prov_code, 'mun_code':mun_code};

                console.log(reg_code + " - " + prov_code + " - " + mun_code);
                $.ajax({
                    type: "GET",
                    url: "{{route('get.profloc')}}",
                    data: old_data,
                    dataType: "json",
                    success: function (response) {
                        if(response.success)
                        {
                            $.each(response.region,function(i,v){
                                if(v.region_code == $("#reg_code").val()){
                                    regions += "<option value='"+v.region_code+"' selected>"+v.region_name+"</option>";
                                }else{
                                    regions += "<option value='"+v.region_code+"'>"+v.region_name+"</option>";
                                }
                            });

                            $.each(response.province,function(i,v){                                
                                if(v.province_code == $("#prov_code").val()){
                                    provinces += "<option value='"+v.province_code+"' selected>"+v.province_name+"</option>";
                                }else{
                                    provinces += "<option value='"+v.province_code+"'>"+v.province_name+"</option>";
                                }
                            });

                            $.each(response.municipality,function(i,v){                                
                                if(v.city_code == $("#mun_code").val()){
                                    municipality += "<option value='"+v.city_code+"' selected>"+v.city_name+"</option>";
                                }else{
                                    municipality += "<option value='"+v.city_code+"'>"+v.city_name+"</option>";
                                }
                            });

                            $("#state").html(regions);
                            $("#province").html(provinces);
                            $("#city").html(municipality);
                        }
                    },
                });

                $(document).on("change","#state",function(){
                    let region_code = $(this).val();
                    let state_data = {'region_code':region_code};
                    let province = "<option value=''>Select Province</option>";
                    let municipalities = "<option value=''>Select Municipality</option>";
                    // let barangay = "<option value=''>Select Barangay</option>";

                    $.ajax({
                        type: "GET",
                        url: "{{route('get.province')}}",
                        data: state_data,
                        dataType: "json",
                        success: function (response) {
                            if(response.success)
                            {
                                $.each(response.data,function(i,v){
                                    province += "<option value='"+v.province_code+"''>"+v.province_name+"</option>";
                                });

                                $("#province").html(province);
                                $("#city").html(municipalities);
                                // $("#barangay").html(barangay);
                            }
                        },
                    });
                });

                $(document).on("change","#province",function(){
                    let prov_code = $(this).val();
                    let prov_data = {'prov_code':prov_code};
                    let municipalities = "<option value=''>Select Municipality</option>";
                    // let barangay = "<option value=''>Select Barangay</option>";

                    $.ajax({
                        type: "GET",
                        url: "{{route('get.municipalities')}}",
                        data: prov_data,
                        dataType: "json",
                        success: function (response) {
                            if(response.success)
                            {
                                $.each(response.data,function(i,v){
                                    municipalities += "<option value='"+v.city_code+"''>"+v.city_name+"</option>";
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
            });
        });
    </script>
@endpush
