<h1>Actual Numbers of Participants:for external </h1>
   <form id="participant_form" action="" method="post">
<div class="row" >
    <input type="hidden" name="reporting_to" value="{{Session::get('after_detail')}}">
    <input type="hidden" id="hidden_activity_id" name="activity_id" value="{{$activity_id->id}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
<div class="form-group col-md-4">
<label for="">Participants:</label>
    <select class="form-control" id="participant_grp_id" name="participant_group">
           @foreach($participants as $participant)
        <option value="{{$participant}}">{{$participant}}</option>
            @endforeach
    </select>
       </div>
       

        
<div class="form-group col-md-4">
            <label for="province">City:</label>
            <select class="form-control" id="chooseCity" name="city">
           @foreach($cities as $city)
            <option value="{{$city->city_name}}">{{$city->city_name}}</option>
            @endforeach
            </select>
        </div>       
</div>
<div class="row" id="baguio_participant">
        <div class="form-group col-md-4">
                    <label for="" id="baguio_label_male">Number of Staff FO male(Baguio) </label>
                    {!!Form::number('number_staff_FO_male_baguio','',['id'=>'staff_male_baguio','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>

       
        <div class="form-group col-md-4">
                    <label for=""id="baguio_label_female" >Number of Staff FO female(Baguio)</label>
                    {!!Form::number('number_staff_FO_female_baguio','',['id'=>'staff_female_baguio','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
        <div class="col-md-4"><br/><div class=" btn btn-primary btn-block " id="add-baguio">add participant in baguio</div></div>
</div>
<div class="row" id="benguet_participant">
        <div class="form-group col-md-4">
                    <label for="" id="benguet_label_male" >Number of Staff FO male(Benguet) </label>
                    {!!Form::number('number_staff_FO_male_benguet','',['id'=>'staff_male_benguet','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="" id="benguet_label_female">Number of Staff FO female(Benguet)</label>
                    {!!Form::number('number_staff_FO_female_benguet','',['id'=>'staff_female_benguet','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"><br/><div class=" btn btn-primary btn-block " id="add-benguet">add participants in Benguet</div></div>
</div>
<div class="row" id="abra_participant">
        <div class="form-group col-md-4">
                    <label for="" id="abra_label_male">Number of Staff FO male(Abra) </label>
                    {!!Form::number('number_staff_FO_male_abra','',['id'=>'staff_male_abra','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>

      
        <div class="form-group col-md-4">
                    <label for="" id="abra_label_female" >Number of Staff FO female(Abra)</label>
                    {!!Form::number('number_staff_FO_female_abra','',['id'=>'staff_female_abra','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"><br/><div class=" btn btn-primary btn-block " id="add-abra">add participants in Abra</div></div>
</div>
<div class="row" id="apayao_participant">
        <div class="form-group col-md-4">
                    <label for="" id="apayao_label_male" >Number of Staff FO male(Apayao) </label>
                    {!!Form::number('number_staff_FO_male_apayao','',['id'=>'staff_male_apayao','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="" id="apayao_label_female" >Number of Staff FO female(Apayao)</label>
                    {!!Form::number('number_staff_FO_female_apayao','',['id'=>'staff_female_apayao','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"></br><div class=" btn btn-primary btn-block " id="add-apayao">add participants in Apayao</div></div>
</div>
<div class="row" id="ifugao_participant">
        <div class="form-group col-md-4">
                    <label for="" id="ifugao_label_male" >Number of Staff FO male(Ifugao) </label>
                    {!!Form::number('number_staff_FO_male_ifugao','',['id'=>'staff_male_ifugao','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>


        <div class="form-group col-md-4">
                    <label for="" id="ifugao_label_female">Number of Staff FO female(Ifugao)</label>
                    {!!Form::number('number_staff_FO_female_ifugao','',['id'=>'staff_female_ifugao','class'=>'form-control', 'min'=>'0', 'max'=>'100'])!!}
                </div>
                <div class="col-md-4"></br><div class=" btn btn-primary btn-block " id="add-ifugao">add participants in Ifugao</div></div>
</div>
<div class="row" id="kalinga_participant">
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
</div>
<div class="row">
    <!-- <button type="submit" class="btn btn-primary btn-block">submit</button> -->
    </div>

</form>

@push('after-scripts')
<script>
let btnbaguio = document.getElementById('add-baguio');
     btnbaguio.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:$('#participant_grp_id').val(),
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_baguio').val(),
                       staff_female:$('#staff_female_baguio').val(),
                       province:"Benguet",
                       city: $('#chooseCity').val()

                     }
                }).
                done(function(res){
                    alert("datasaved"+res.msg);
                    $('#baguio_participant').slideToggle( "slow" );
                });
    
     });
     let btnbenguet = document.getElementById('add-benguet');
     btnbenguet.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:$('#participant_grp_id').val(),
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_benguet').val(),
                       staff_female:$('#staff_female_benguet').val(),
                       province: "Benguet",
                       city: $('#chooseCity').val()
                     }
                }).
                done(function(res){
                    alert("data saved"+res.msg);
                    $('#benguet_participant').slideToggle( "slow" );
                });
       
     });
     let btnabra = document.getElementById('add-abra');
     btnabra.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:$('#participant_grp_id').val(),
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_abra').val(),
                       staff_female:$('#staff_female_abra').val(),
                       province:"Abra",
                       city: $('#chooseCity').val()
                     }
                }).
                done(function(res){
                    alert("datasaved"+res.msg);
                    $('#abra_participant').slideToggle( "slow" );
                });
    
     });
     let btnapayao = document.getElementById('add-apayao');
     btnapayao.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:$('#participant_grp_id').val(),
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_apayao').val(),
                       staff_female:$('#staff_female_apayao').val(),
                       province:"Apayao",
                       city: $('#chooseCity').val()
                     }
                }).
                done(function(res){
                    alert("datasaved"+res.msg);
                    $('#apayao_participant').slideToggle( "slow" );
                });
    
     });
     let btnifugao = document.getElementById('add-ifugao');
     btnifugao.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:$('#participant_grp_id').val(),
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_ifugao').val(),
                       staff_female:$('#staff_female_ifugao').val(),
                       province: "ifugao",
                       city: $('#chooseCity').val()
                     }
                }).
                done(function(res){
                    alert("datasaved"+res.msg);
                    $('#ifugao_participant').slideToggle( "slow" );
                });
    
     });
     let btnkalinga = document.getElementById('add-kalinga');
     btnkalinga.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:$('#participant_grp_id').val(),
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_kalinga').val(),
                       staff_female:$('#staff_female_kalinga').val(),
                       province: "kalinga",
                       city: $('#chooseCity').val()
                     }
                }).
                done(function(res){
                    alert("datasaved"+res.msg);
                    $('#kalinga_participant').slideToggle( "slow" );
                });
    
     });
     let btnmtprovince = document.getElementById('add-mtprovince');
     btnmtprovince.addEventListener('click',function(e){
        e.preventDefault();
            $.ajax({
                type:'post',
                url:"{{route('actual_number')}}",
                data:{participant_grp:$('#participant_grp_id').val(),
                       activity_id :$('#hidden_activity_id').val(),
                       staff_male: $('#staff_male_mtprovince').val(),
                       staff_female:$('#staff_female_mtprovince').val(),
                       province: "Mt.Province",
                       city: $('#chooseCity').val()
                     }
                }).
                done(function(res){
                    alert("datasaved"+res.msg);
                    $('#mtprovince_participant').slideToggle( "slow" );
                });
    
     });

    $('#participant_grp_id').on('change', function(){
        let participant_selected = $('#participant_grp_id').val();
        if(participant_selected == "LGU Participants" ){
            var baguiotextmale ="number of LGU male represented (Baguio) ";
            var baguiotextfemale ="number of LGU female represented (Baguio) ";
            var benguettextmale ="number of LGU male represented (Benguet) ";
            var benguettextfemale ="number of LGU female represented (Benguet) ";
            var abratextmale ="number of LGU male represented (Abra) ";
            var abratextfemale ="number of LGU female represented (Abra) ";
            var apayaotextmale ="number of LGU male represented (Apayao)";
            var apayaotextfemale ="number of LGU female represented (Apayao)";
            var ifugaotextmale ="number of LGU male represented (Ifugao) ";
            var ifugaotextfemale ="number of LGU female represented (Ifugao) ";
            var kalingatextmale ="number of LGU male represented (Kalinga) ";
            var kalingatextfemale ="number of LGU female represented (Kalinga) ";
            var mtprovincetextmale ="number of LGU male represented (Mt.Province)";
            var mtprovincetextfemale ="number of LGU female represented (Mt.Province)";
            $('#baguio_label_male').text(baguiotextmale);
            $('#baguio_label_female').text(baguiotextfemale);
            $('#benguet_label_male').text(benguettextmale);
            $('#benguet_label_female').text(benguettextfemale);
            $('#abra_label_male').text(abratextmale);
            $('#abra_label_female').text(abratextfemale);
            $('#apayao_label_male').text(apayaotextmale);
            $('#apayao_label_female').text(apayaotextfemale);
            $('#ifugao_label_male').text(ifugaotextmale);
            $('#ifugao_label_female').text(ifugaotextfemale);
            $('#kalinga_label_male').text(kalingatextmale);
            $('#kalinga_label_female').text(kalingatextfemale);
            $('#mtprovince_label_male').text(mtprovincetextmale);
            $('#mtprovince_label_female').text(mtprovincetextfemale);
        }else if(participant_selected == "NGO Participants"){
            var baguiotextmale ="number of NGO male represented (Baguio) ";
            var baguiotextfemale ="number of NGO female represented (Baguio) ";
            var benguettextmale ="number of NGO male represented (Benguet) ";
            var benguettextfemale ="number of NGO female represented (Benguet) ";
            var abratextmale ="number of NGO male represented (Abra) ";
            var abratextfemale ="number of NGO female represented (Abra) ";
            var apayaotextmale ="number of NGO male represented (Apayao)";
            var apayaotextfemale ="number of NGO female represented (Apayao)";
            var ifugaotextmale ="number of NGO male represented (Ifugao) ";
            var ifugaotextfemale ="number of NGO female represented (Ifugao) ";
            var kalingatextmale ="number of NGO male represented (Kalinga) ";
            var kalingatextfemale ="number of NGO female represented (Kalinga) ";
            var mtprovincetextmale ="number of NGO male represented (Mt.Province)";
            var mtprovincetextfemale ="number of NGO female represented (Mt.Province)";
            $('#baguio_label_male').text(baguiotextmale);
            $('#baguio_label_female').text(baguiotextfemale);
            $('#benguet_label_male').text(benguettextmale);
            $('#benguet_label_female').text(benguettextfemale);
            $('#abra_label_male').text(abratextmale);
            $('#abra_label_female').text(abratextfemale);
            $('#apayao_label_male').text(apayaotextmale);
            $('#apayao_label_female').text(apayaotextfemale);
            $('#ifugao_label_male').text(ifugaotextmale);
            $('#ifugao_label_female').text(ifugaotextfemale);
            $('#kalinga_label_male').text(kalingatextmale);
            $('#kalinga_label_female').text(kalingatextfemale);
            $('#mtprovince_label_male').text(mtprovincetextmale);
            $('#mtprovince_label_female').text(mtprovincetextfemale);
        }else if(participant_selected == "NGA Participants"){
            var baguiotextmale ="number of NGA male represented (Baguio) ";
            var baguiotextfemale ="number of NGA female represented (Baguio) ";
            var benguettextmale ="number of NGA male represented (Benguet) ";
            var benguettextfemale ="number of NGA female represented (Benguet) ";
            var abratextmale ="number of NGA male represented (Abra) ";
            var abratextfemale ="number of NGA female represented (Abra) ";
            var apayaotextmale ="number of NGA male represented (Apayao)";
            var apayaotextfemale ="number of NGA female represented (Apayao)";
            var ifugaotextmale ="number of NGA male represented (Ifugao) ";
            var ifugaotextfemale ="number of NGA female represented (Ifugao) ";
            var kalingatextmale ="number of NGA male represented (Kalinga) ";
            var kalingatextfemale ="number of NGA female represented (Kalinga) ";
            var mtprovincetextmale ="number of NGA male represented (Mt.Province)";
            var mtprovincetextfemale ="number of NGA female represented (Mt.Province)";
            $('#baguio_label_male').text(baguiotextmale);
            $('#baguio_label_female').text(baguiotextfemale);
            $('#benguet_label_male').text(benguettextmale);
            $('#benguet_label_female').text(benguettextfemale);
            $('#abra_label_male').text(abratextmale);
            $('#abra_label_female').text(abratextfemale);
            $('#apayao_label_male').text(apayaotextmale);
            $('#apayao_label_female').text(apayaotextfemale);
            $('#ifugao_label_male').text(ifugaotextmale);
            $('#ifugao_label_female').text(ifugaotextfemale);
            $('#kalinga_label_male').text(kalingatextmale);
            $('#kalinga_label_female').text(kalingatextfemale);
            $('#mtprovince_label_male').text(mtprovincetextmale);
            $('#mtprovince_label_female').text(mtprovincetextfemale);

        }else if(participant_selected == "People's Org Participants"){
            var baguiotextmale ="number of P.O male represented (Baguio) ";
            var baguiotextfemale ="number of P.O female represented (Baguio) ";
            var benguettextmale ="number of P.O male represented (Benguet) ";
            var benguettextfemale ="number of P.O female represented (Benguet) ";
            var abratextmale ="number of P.O male represented (Abra) ";
            var abratextfemale ="number of P.O female represented (Abra) ";
            var apayaotextmale ="number of P.O male represented (Apayao)";
            var apayaotextfemale ="number of P.O female represented (Apayao)";
            var ifugaotextmale ="number of P.O male represented (Ifugao) ";
            var ifugaotextfemale ="number of P.O female represented (Ifugao) ";
            var kalingatextmale ="number of P.O male represented (Kalinga) ";
            var kalingatextfemale ="number of P.O female represented (Kalinga) ";
            var mtprovincetextmale ="number of P.O male represented (Mt.Province)";
            var mtprovincetextfemale ="number of P.O female represented (Mt.Province)";
            $('#baguio_label_male').text(baguiotextmale);
            $('#baguio_label_female').text(baguiotextfemale);
            $('#benguet_label_male').text(benguettextmale);
            $('#benguet_label_female').text(benguettextfemale);
            $('#abra_label_male').text(abratextmale);
            $('#abra_label_female').text(abratextfemale);
            $('#apayao_label_male').text(apayaotextmale);
            $('#apayao_label_female').text(apayaotextfemale);
            $('#ifugao_label_male').text(ifugaotextmale);
            $('#ifugao_label_female').text(ifugaotextfemale);
            $('#kalinga_label_male').text(kalingatextmale);
            $('#kalinga_label_female').text(kalingatextfemale);
            $('#mtprovince_label_male').text(mtprovincetextmale);
            $('#mtprovince_label_female').text(mtprovincetextfemale);

        }else if(participant_selected == "Volunteers"){
            var baguiotextmale ="number of Volunteers male represented (Baguio) ";
            var baguiotextfemale ="number of Volunteers female represented (Baguio) ";
            var benguettextmale ="number of Volunteers male represented (Benguet) ";
            var benguettextfemale ="number of Volunteers female represented (Benguet) ";
            var abratextmale ="number of Volunteers male represented (Abra) ";
            var abratextfemale ="number of Volunteers female represented (Abra) ";
            var apayaotextmale ="number of Volunteers male represented (Apayao)";
            var apayaotextfemale ="number of Volunteers female represented (Apayao)";
            var ifugaotextmale ="number of Volunteers male represented (Ifugao) ";
            var ifugaotextfemale ="number of Volunteers female represented (Ifugao) ";
            var kalingatextmale ="number of Volunteers male represented (Kalinga) ";
            var kalingatextfemale ="number of Volunteers female represented (Kalinga) ";
            var mtprovincetextmale ="number of Volunteers male represented (Mt.Province)";
            var mtprovincetextfemale ="number of Volunteers female represented (Mt.Province)";
            $('#baguio_label_male').text(baguiotextmale);
            $('#baguio_label_female').text(baguiotextfemale);
            $('#benguet_label_male').text(benguettextmale);
            $('#benguet_label_female').text(benguettextfemale);
            $('#abra_label_male').text(abratextmale);
            $('#abra_label_female').text(abratextfemale);
            $('#apayao_label_male').text(apayaotextmale);
            $('#apayao_label_female').text(apayaotextfemale);
            $('#ifugao_label_male').text(ifugaotextmale);
            $('#ifugao_label_female').text(ifugaotextfemale);
            $('#kalinga_label_male').text(kalingatextmale);
            $('#kalinga_label_female').text(kalingatextfemale);
            $('#mtprovince_label_male').text(mtprovincetextmale);
            $('#mtprovince_label_female').text(mtprovincetextfemale);
        }
        
    });
   
  
   
    
</script>    

@endpush