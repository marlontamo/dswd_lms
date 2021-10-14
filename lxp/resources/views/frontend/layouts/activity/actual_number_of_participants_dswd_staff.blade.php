<h1>Actual Numbers of Participants:DSWD Staff</h1>
   <form id="participant_form" action="" method="post">

    <input type="hidden" name="reporting_to" value="{{Session::get('after_detail')}}">
    <input type="hidden" id="hidden_activity_id" name="activity_id" value="{{$activity_id->id}}">
        <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
    

<div class="row" id="baguio_participant-in">
        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO male(Baguio) </label>
                    {!!Form::number('number_staff_FO_male_baguio','',['id'=>'staff_male_baguio-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>

       
        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO female(Baguio)</label>
                    {!!Form::number('number_staff_FO_female_baguio','',['id'=>'staff_female_baguio-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
        <div class="col-md-4" id><br/><div class=" btn btn-primary btn-block " id="add-baguio-internal">add participant in baguio</div></div>
</div>
<div class="row" id="benguet_participant-in">
        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO male(Benguet) </label>
                    {!!Form::number('number_staff_FO_male_benguet','',['id'=>'staff_male_benguet-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO female(Benguet)</label>
                    {!!Form::number('number_staff_FO_female_benguet','',['id'=>'staff_female_benguet-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"><br/><div class=" btn btn-primary btn-block " id="add-benguet-internal">add participants in Benguet</div></div>
</div>
<div class="row" id="abra_participant-in">
        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO male(Abra) </label>
                    {!!Form::number('number_staff_FO_male_abra','',['id'=>'staff_male_abra-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>

      
        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO female(Abra)</label>
                    {!!Form::number('number_staff_FO_female_abra','',['id'=>'staff_female_abra-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"><br/><div class=" btn btn-primary btn-block " id="add-abra-internal">add participants in Abra</div></div>
</div>
<div class="row" id="apayao_participant-in">
        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO male(Apayao) </label>
                    {!!Form::number('number_staff_FO_male_apayao','',['id'=>'staff_male_apayao-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO female(Apayao)</label>
                    {!!Form::number('number_staff_FO_female_apayao','',['id'=>'staff_female_apayao-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"></br><div class=" btn btn-primary btn-block " id="add-apayao-internal">add participants in Apayao</div></div>
</div>
<div class="row" id="ifugao_participant-in">
        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO male(Ifugao) </label>
                    {!!Form::number('number_staff_FO_male_ifugao','',['id'=>'staff_male_ifugao-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO female(Ifugao)</label>
                    {!!Form::number('number_staff_FO_female_ifugao','',['id'=>'staff_female_ifugao-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"></br><div class=" btn btn-primary btn-block " id="add-ifugao-internal">add participants in Ifugao</div></div>
</div>
<div class="row" id="kalinga_participant-in">
        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO male(kalinga) </label>
                    {!!Form::number('number_staff_FO_male_kalinga','',['id'=>'staff_male_kalinga-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO female(kalinga)</label>
                    {!!Form::number('number_staff_FO_female_kalinga','',['id'=>'staff_female_kalinga-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"></br><div class=" btn btn-primary btn-block " id="add-kalinga-internal">add participants in kalinga</div></div>
</div>
<div class="row" id="mtprovince_participant-in">
        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO male(mt. Province) </label>
                    {!!Form::number('number_staff_FO_male_mtprovince','',['id'=>'staff_male_mtprovince-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="">Number of Staff FO female(mt. Province)</label>
                    {!!Form::number('number_staff_FO_female_mtprovince','',['id'=>'staff_female_mtprovince-in','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"></br><div class=" btn btn-primary btn-block " id="add-mtprovince-internal">add participants in mt. Province</div>
</div>
</div>
<div class="row" id="central_office_participant-in">
        <div class="form-group col-md-4">
                    <label for="">Number of Central Office male </label>
                    {!!Form::number('number_staff_FO_male_CO','',['id'=>'staff_male_CO','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="">Number of Central Office female</label>
                    {!!Form::number('number_staff_FO_female_CO','',['id'=>'staff_female_CO','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"></br><div class=" btn btn-primary btn-block " id="add-CO-internal">add participants in Central Office</div></div>

</div>

<div class="row">
    <!-- <button type="submit" class="btn btn-primary btn-block">submit</button> -->
    </div>

</form>

@push('after-scripts')
<script>
let inbtnbaguio = document.getElementById('add-baguio-internal');
     inbtnbaguio.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"DSWD",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_baguio-in').val(),
                       staff_female:$('#staff_female_baguio-in').val(),
                       province: "Benguet",
                       _token: $('#token').val(),
                       city:"n/a"

                     }
                }).
                done(function(res){
                    alert(res.msg);
                    if(res.msg =="saved"){
                    $('#baguio_participant-in').slideToggle( "slow" );
                    }
                });
         
     });
     let inbtnbenguet = document.getElementById('add-benguet-internal');
     inbtnbenguet.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"DSWD",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_benguet-in').val(),
                       staff_female:$('#staff_female_benguet-in').val(),
                       province: "Benguet",
                       _token: $('#token').val(),
                       city:"n/a"
                     }
                }).
                done(function(res){
                    alert(res.msg);
                    if(res.msg == "saved"){
                    $('#benguet_participant-in').slideToggle( "slow" );
                    }
                });
       //alert("benguet");
     });
     let inbtnabra = document.getElementById('add-abra-internal');
     inbtnabra.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"DSWD",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_abra-in').val(),
                       staff_female:$('#staff_female_abra-in').val(),
                       province: "Abra",
                       _token: $('#token').val(),
                       city:"n/a"
                     }
                }).
                done(function(res){
                    alert(res.msg);
                    if(res.msg == "saved"){
                    $('#abra_participant-in').slideToggle( "slow" );
                    }
                });
    
     });
     let inbtnapayao = document.getElementById('add-apayao-internal');
     inbtnapayao.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"DSWD",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_apayao-in').val(),
                       staff_female:$('#staff_female_apayao-in').val(),
                       province: "Apayao",
                       _token: $('#token').val(),
                       city:"n/a"
                     }
                }).
                done(function(res){
                    alert(res.msg);
                    if(res.msg == "saved"){
                    $('#apayao_participant-in').slideToggle( "slow" );
                    }
                });
    
     });
     let inbtnifugao = document.getElementById('add-ifugao-internal');
     inbtnifugao.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"DSWD",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_ifugao-in').val(),
                       staff_female:$('#staff_female_ifugao-in').val(),
                       province: "Ifugao",
                       _token: $('#token').val(),
                       city:"n/a"
                     }
                }).
                done(function(res){
                    alert(res.msg);
                    if(res.msg == "saved"){
                    $('#ifugao_participant-in').slideToggle( "slow" );
                    }
                });
    
     });
     let inbtnkalinga = document.getElementById('add-kalinga-internal');
     inbtnkalinga.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"DSWD",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_kalinga-in').val(),
                       staff_female:$('#staff_female_kalinga-in').val(),
                       province: "Kalinga",
                       _token: $('#token').val(),
                       city:"n/a"
                     }
                }).
                done(function(res){
                    alert(res.msg);
                    if(res.msg == "saved"){
                    $('#kalinga_participant-in').slideToggle( "slow" );
                    }
                });
    
     });
     let inbtnmtprovince = document.getElementById('add-mtprovince-internal');
     inbtnmtprovince.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"DSWD",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_mtprovince-in').val(),
                       staff_female:$('#staff_female_mtprovince-in').val(),
                       province: "Mt. Province",
                       _token: $('#token').val(),
                       city:"n/a"
                     }
                }).
                done(function(res){
                    alert(res.msg);
                    if(res.msg == "saved"){
                    $('#mtprovince_participant-in').slideToggle( "slow" );
                    }
                });
    
     });
     let inbtnCO = document.getElementById('add-CO-internal');
     inbtnCO.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"DSWD",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_CO').val(),
                       staff_female:$('#staff_female_CO').val(),
                       province: "Central Office",
                       _token: $('#token').val(),
                       city:"n/a"
                     }
                }).
                done(function(res){
                    alert(res.msg);
                    if(res.msg == "saved"){
                    $('#central_office_participant-in').slideToggle( "slow" );
                    }
                    else{
                        alert("failed");
                    }
                });
    
     });


   
  
   
    
</script>    

@endpush