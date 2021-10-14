<h1>Actual Numbers of Participants:</h1>

{{ Form::open(array('url' => '/actual_number', 'method'=>'post')) }}

<div class="row" >
    <input type="hidden" name="reporting_to" value="{{Session::get('after_detail')}}">

<div class="form-group col-md-4">
<label for="">Participants:</label>
    <select class="form-control" id="participantOption" name="participant_group[]">
           @foreach($participants as $participantKey =>$value)
        <option value="{{$value}}">{{$value}}</option>
            @endforeach
    </select>
       </div>    
<div class="form-group col-md-4">
            <label for="province">Municipality represented:</label>
            <select class="form-control" id="chooseProvince" name="province[]">
           @foreach($provinces as $province)
            <option value= "{{$province}}">{{$province}}</option>
            @endforeach
            </select>
        </div>
        <!-- <div class="form-group col-md-4">
            <label for="">City represented:</label>
            <select class="form-control" id="selectcity" name="city">
           @foreach($city as $cities)
            <option value= "{{$cities->city_name}}">{{$cities->city_name}}</option>
            @endforeach
            </select>
        </div>  -->
        
</div>
<div class="row" id="Participant">
<div class="form-group col-md-5">
            <label for="">Number of Staff FO (male) </label>
            {!!Form::number('number_staff_FO_male[]','',['class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
        </div>

<input type="hidden" name="activity_id[]" value="{{$activity_id->id}}">
<div class="form-group col-md-5">
            <label for="">Number of Staff FO (female)</label>
            {!!Form::number('number_staff_FO_female[]','',['class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
        </div>
        <div class="col"></div>
</div>
<div id="holder"></div>
<div class="row">

    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-sm btn-secondary']) !!}
    </div>
</div>
{{ Form::close() }}
<button onclick="test()" class="btn btn-primary btn-md btn-block" id="addrow"><i class="fa fa-plus"></i></button>
<script>
    function test(){
         let form = document.getElementById('#holder');
        let html = "";
             html += '<div class="row" id="test"><div class="form-group col-md-4"><label for="">Participants:</label>';
            html +='<select class="form-control" id="participantOption" name="participant_group[]">';
            html +=' @foreach($participants as $participantKey =>$value)';
            html +=' <option value="{{$value}}">{{$value}}</option>';
            html += '@endforeach</select></div>@csrf;
            html += '<div class="form-group  col-md-6"><label for="province">Municipality represented:</label>';
            html += '<select class="form-control" id="chooseProvince" name="province[]">';
            html +=' @foreach($provinces as $province)';
            html += '<option value= "{{$province}}">{{$province}}</option>';
            html +='  @endforeach';
            html +='</select></div><input type="hidden" name="activity_id[]" value="{{$activity_id->id}}">';
            html += '    <div class="form-group col-md-5">';
            html += '<label for="">Number of Staff FO (male) </label>';
            html += ' {!!Form::number("number_staff_FO_male[]",'',["class"=>"form-control", "min"=>"0", "max"=>"100"])!!}</div>';
            html += '       <div class="form-group col-md-5">';
            html += '   <label for="">Number of Staff FO (female) </label>';
            html += ' {!!Form::number("number_staff_FO_female[]",'',["class"=>"form-control", "min"=>"0", "max"=>"100"])!!}</div>';
            html += '<div class="col-md-2"><button id="remove_extra" class="btn btn-block btn-danger decrease" type="button"><i class="fa fa-trash"></i></button></div></div>';
            
            form.append(html);
        alert('add form');
        
    }
    $(document).on('click','#remove_extra',function(e){
        e.preventDefault();
        console.log(this);
       
    });
    $('#participantOption').on('change',function(){
      $('#participant-grp').val($(this).val());
    });

    
</script>
