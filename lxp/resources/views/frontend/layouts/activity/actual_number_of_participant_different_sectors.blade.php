<h1>Actual Numbers of Participants:for Different Sectors </h1>
   <form id="participant_form" action="" method="post">
<div class="row" >
    <input type="hidden" name="reporting_to" value="{{Session::get('after_detail')}}">
    <input type="hidden" id="hidden_activity_id" name="activity_id" value="{{$activity_id->id}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
</div>
<div class="row" id="academe_participant">
        <div class="form-group col-md-4">
                    <label for="" id="baguio_label_male">Number of Academe male </label>
                    {!!Form::number('number_Academe_male_baguio','',['id'=>'academe_male','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>

       
        <div class="form-group col-md-4">
                    <label for=""id="baguio_label_female" >Number of Academe female</label>
                    {!!Form::number('academe_female','',['id'=>'academe_female','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
        <div class="col-md-4"><br/><div class=" btn btn-primary btn-block " id="add-academe">add Academe participant</div></div>
</div>
<div class="row" id="religious_sector_participant">
        <div class="form-group col-md-4">
                    <label for="" id="benguet_label_male" >Number of Religious sector male </label>
                    {!!Form::number('number_religious_sector_male','',['id'=>'religious_sector_male','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="" id="benguet_label_female">Number of Religious sector female</label>
                    {!!Form::number('religious_sector_female','',['id'=>'religious_sector_female','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"><br/><div class=" btn btn-primary btn-block " id="add-religious_sector">add religious sector participants</div></div>
</div>
<div class="row" id="business_sector_participant">
        <div class="form-group col-md-4">
                    <label for="" id="abra_label_male">Number of Business sector male </label>
                    {!!Form::number('business_sector_male','',['id'=>'business_sector_male','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>

      
        <div class="form-group col-md-4">
                    <label for="" id="abra_label_female" >Number of Business sector female</label>
                    {!!Form::number('business_sector_female','',['id'=>'business_sector_female','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"><br/><div class=" btn btn-primary btn-block " id="add-business_sector">add business sectors participants</div></div>
</div>
<div class="row" id="media_participant">
        <div class="form-group col-md-4">
                    <label for="" id="apayao_label_male" >Number Media male </label>
                    {!!Form::number('media_male','',['id'=>'media_male','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="" id="apayao_label_female" >Number Media female</label>
                    {!!Form::number('media_female','',['id'=>'media_female','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"></br><div class=" btn btn-primary btn-block " id="add-media">add Media in participants</div></div>
</div>
<div class="row" id="beneficiaries_participant">
        <div class="form-group col-md-4">
                    <label for="" id="ifugao_label_male" >Number of Beneficiaries male</label>
                    {!!Form::number('beneficiaries_male','',['id'=>'beneficiaries_male','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="" id="ifugao_label_female">Number of Beneficiaries female</label>
                    {!!Form::number('beneficiaries_female','',['id'=>'beneficiaries_female','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"></br><div class=" btn btn-primary btn-block " id="add-beneficiaries">add beneficiaries participants </div></div>
</div>
 <!-- <div class="row" id="kalinga_participant">
        <div class="form-group col-md-4">
                    <label for="" id="kalinga_label_male">Number of Staff FO male(kalinga) </label>
                    {!!Form::number('number_staff_FO_male_kalinga','',['id'=>'staff_male_kalinga','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="" id="kalinga_label_female">Number of Staff FO female(kalinga)</label>
                    {!!Form::number('number_staff_FO_female_kalinga','',['id'=>'staff_female_kalinga','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"></br><div class=" btn btn-primary btn-block " id="add-kalinga">add participants in kalinga</div></div>
</div>
<div class="row" id="mtprovince_participant">
        <div class="form-group col-md-4">
                    <label for="" id="mtprovince_label_male">Number of Staff FO male(mt. Province) </label>
                    {!!Form::number('number_staff_FO_male_mtprovince','',['id'=>'staff_male_mtprovince','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="" id="mtprovince_label_female">Number of Staff FO female(mt. Province)</label>
                    {!!Form::number('number_staff_FO_female_mtprovince','',['id'=>'staff_female_mtprovince','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"></br><div class=" btn btn-primary btn-block " id="add-mtprovince">add participants in mt. Province</div></div>
</div> -->
<div class="row">
    <!-- <button type="submit" class="btn btn-primary btn-block">submit</button> -->
    </div>

</form>

@push('after-scripts')
<script>
let btnacademe = document.getElementById('add-academe');
     btnacademe.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"Different Sectors",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#academe_male').val(),
                       staff_female:$('#academe_female').val(),
                       province:"Academe",
                       city: "n/a"

                     }
                }).
                done(function(res){
                    alert("datasaved "+res.msg);
                    $('#academe_participant').slideToggle( "slow" );
                });
    
     });
     let btnreligious = document.getElementById('add-religious_sector');
     btnreligious.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"Different Sectors",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#religious_sector_male').val(),
                       staff_female:$('#religious_sector_female').val(),
                       province: "Religious Sector",
                       city:"n/a"
                     }
                }).
                done(function(res){
                    alert("data saved"+res.msg);
                    $('#religious_sector_participant').slideToggle( "slow" );
                });
       
     });
     let btnbusiness = document.getElementById('add-business_sector');
     btnbusiness.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"Different Sectors",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#business_sector_male').val(),
                       staff_female:$('#business_sector_female').val(),
                       province:"Business sector",
                       city:"n/a"
                     }
                }).
                done(function(res){
                    alert("datasaved"+res.msg);
                    $('#business_sector_participant').slideToggle( "slow" );
                });
    
     });
     let btnmedia = document.getElementById('add-media');
     btnmedia.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"Different Sectors",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#media_male').val(),
                       staff_female:$('#media_female').val(),
                       province:"Media",
                       city: "n/a"
                     }
                }).
                done(function(res){
                    alert("datasaved"+res.msg);
                    $('#media_participant').slideToggle( "slow" );
                });
    
     });
     let btnbeneficiaries = document.getElementById('add-beneficiaries');
     btnbeneficiaries.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:"Different Sectors",
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#beneficiaries_male').val(),
                       staff_female:$('#beneficiaries_female').val(),
                       province: "Beneficiaries",
                       city:"n/a"
                     }
                }).
                done(function(res){
                    alert("datasaved"+res.msg);
                    $('#beneficiaries_participant').slideToggle( "slow" );
                });
    
     });
     
     
</script>    

@endpush