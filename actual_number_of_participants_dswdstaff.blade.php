<h1>Actual Numbers of Participants:</h1>
   <form id="participant_form" action="/add_participant" method="post">
     {{@csrf_field()}}
      <div class="row" id="academe_participant">
        <div class="form-group col-md-4">
                    <label for="" id="baguio_label_male">Add Participant in: </label>
                   <button class="btn-primary btn-sm btn-block" id="add-form-btn">Add</button>
        </div>
        <div class="form-group col-md-4">
                    <label for="" id="baguio_label_male">Select participant group:</label>
                    <select class="form-control" name="participant_group_option" id="participant-group-option" onchange="get_group(this)">
                       
                        @foreach($participants as $participant)
                        <option value="{{$participant->id}}">{{$participant->title}}</option>
                        @endforeach
                    </select>
        </div>
 </div>
 <div class="row participant_form_clone" id="participant_custom_form" >  
        <!-- <div class="row" id=""> -->
        <input type="hidden" name="activity_id[]" value="{{$activity_id->id}}">
        <input type="hidden" name="user_id[]" value="{{Auth::user()->id}}">
        <input type="hidden" class="participant_group" name="participant_group[]">
        
            <div class="col-md-2" class="participant-row">
                <label>Province: </label>
                <div>
                    <select class="form-control province-cbs" name="province_code[]" id="province-cbs" onchange="getProvince(this)">
                        <option value="">Select Province</option>
                    </select>
                    <span id="province-error" class="text-danger"></span>
                </div>
            </div>
            <div class="col-md-2">
                <label>Municipality: </label>
                <div>
                    <select class="form-control city-cbs" name="city_code[]" id="city-cbs" >
                        <option value="">Select Municipality/City</option>
                    </select>
                    <span id="city-error" class="text-danger"></span>
                </div>
            </div>

                      
                               
    <div class="form-group col-md-2">
        <label for=""id="">Male</label>
        {!!Form::number('xmale[]','',['id'=>'male-cbs','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
    </div>
    <div class="form-group col-md-2">
        <label for=""id="" >Female</label>
        {!!Form::number('xfemale[]','',['id'=>'female-cbs','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
    </div>
    <div class="col-md-2"> 
        <label for="remove-cbs"></label>    
        <button id="remove-cbs" class="btn btn-block btn-secondary remove-cbs" type="button" onclick="removeform(this)"><i class="fa fa-trash"></i></button>
    </div>
        
</div>

<div class="row">
        <div id="new-field" class="col-md-12"></div>
</div>
    
</div>
<div class="row">
    <div class="col-md-4"></div>
    <button  class="btn btn-warning col-md-4 " type="submit">Save</button>
</div>
</form>


@push('after-scripts')
<script>
    $(document).ready(function(){
        
        let add_new_set_form = document.getElementById('add-form-btn');

        add_new_set_form.addEventListener('click',function(e){
            
            e.preventDefault();
              
           
            $('#participant_custom_form_0').clone()
            .appendTo('#new-field');

            var count = $('.province-cbs').length;
            
            for (let index = 0; index < count; index++) {
                $('.province-cbs')[index].setAttribute('id','province-cbs_'+index);
                $('.city-cbs')[index].setAttribute('id','city-cbs_'+index);
                $('.remove-cbs')[index].setAttribute('id','remove-cbs_'+index);
                $('.participant_form_clone')[index].setAttribute('id','participant_custom_form_'+index);
               
            }
            
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

                        $(".state-cbs").html(regions);
                        $(".province-cbs").html(provinces);
                    }
                },
            });



            //$(document).on("change", ".state-cbs", function() {
            function getState(){
                //let region_code = $(this).val();
                let region_code = 140000000;
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

                            $(".province-cbs").html(province);
                            $(".city-cbs").html(municipalities);
                            
                        }
                    },
                });
            }

            //$(document).on("change", ".province-cbs", function() {
                function getProvince(e){
                   
                    var old_id = e.id;
                    var newid = old_id.split("_");
                 $('#provinceval').val(e.value);   
                let prov_code = e.value;
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
                       //console.log(newid[1]);
                       if(newid[1] == 'undefined'||newid[1] == null)
                    $('#city-cbs').html(municipalities); 
                         else{
                            $('#city-cbs_'+newid[1]).html(municipalities);
                         }   // $("#barangay").html(barangay);
                        }
                    },
                });
            }
            function getCity(){
                
                let prov_code = $('#provinceval').val();
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

                            //$(e[0]).html('<p>testing<p>');
                            // $("#barangay").html(barangay);
                        }
                    },
                });
            }
        
        function removeform(e){
                let old_id = e.id;
                let newid = old_id.split("_");
            
                 if(newid[1] == null || newid[1] == 'undefined'|| newid[1] == 0){
                   
                    console.log('no id');
                 }else{
                    let index = $(this).parent().parent('#participant_custom_form_'+newid[1]).index();
                   $('#participant_custom_form_'+newid[1]).remove();
                 }
            
            
                
            
        }
        function get_group(){
         let val = $('#participant-group-option :selected').val();
         $('.participant_group').val(val);
              
        }
      
</script>  

@endpush