<h1>Capability Building Section (CBS- Activity is intended for External Participants/Partners) form</h1>
{{ Form::open(array('url' => '/activity_detail_CBS', 'method'=>'post')) }}
<div class="col-md-12 row">
<div class="form-group col-md-3">
           <input type="hidden" name="activity_id" value="{{$activity_id->id}}">
           <input type="hidden" name="reporting_to" value="{{Session::get('next')}}">
            <label for="">Activity Title</label>
            {!!Form::text('activity_title','',['class'=>'form-control'])!!}
        </div>

<div class="form-group col-md-3">
            <label for="">proposed date of conduct:</label>
            <input type="date" name="proposed_date_of_conduct" id="proposed_date" class="form-control">
        </div>

<div class="form-group col-md-3">
            <label for="">proposed venue:</label>
            {!!Form::text('proposed_venue','',['class'=>'form-control'])!!}
        </div>
        <div class="form-group col-md-3">
            <label for="">Central office</label>
            {!!Form::number('central_office','',['class'=>'form-control'])!!}
        </div> 
</div>
<div class="row">
<div class="form-group col-md-3">
            <label for="">Local Government Unit (LGU):</label>
            {!!Form::number('LGU','old(LGU)',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-3">
            <label for="">National Government Agencies(NGA):</label>
            {!!Form::number('NGA','old(NGA)',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-3">
            <label for="">Non Government Organization(NGO):</label>
            {!!Form::number('NGO','',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-3">
            <label for="">Business Sector:</label>
            {!!Form::number('business_sector','',['class'=>'form-control'])!!}
        </div>
</div>
<div class="row">
<div class="form-group col-md-3">
            <label for="">Peaple's Organization (PO):</label>
            {!!Form::number('PO','',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-3">
            <label for="">Volunteers:</label>
            {!!Form::number('volunteers','',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-3">
            <label for="">Stakeholders:</label>
            {!!Form::number('stakeholders','',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-3">
            <label for="">Media:</label>
            {!!Form::number('media','old(media)',['class'=>'form-control'])!!}
        
</div>
</div>
<div class="row">
<div class="form-group col-md-3">
            <label for="">Academe:</label>
            {!!Form::number('academe','old(academe)',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-3">
            <label for="">Centers and Institutions (CIS)</label>
            {!!Form::number('CIS','',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-3">
            <label for="">Religious Sector:</label>
            {!!Form::number('religious_sector','',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-3">
            <label for="">Beneficiaries:</label>
            {!!Form::number('beneficiaries','old(beneficiaries)',['class'=>'form-control'])!!}
        </div>
        <div class="form-group col-md-3">
            <label for="">Field Office:</label>
            {!!Form::number('field_office','',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-6">
            <label for="">OBLIGATED Amount (Based on Approved P.O):</label>
            {!!Form::text('obligated_amount','',['class'=>'form-control'])!!}
        </div>
        
</div>





<div class="row">
    <div class="col-12  text-center form-group">

    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-lg btn-secondary']) !!}
    </div>
</div>
{{ Form::close() }}

<!-- ----Partners external participants--- 
-activity Title
-Proposed date of conduct
-proposed_venue
===intermediaries===
-LGU
-NGA
-NGO
-PO
-volunteers
-stakeholders
-academe
-Religious sector 
-business sector 
-media
-beneficiaries  -->