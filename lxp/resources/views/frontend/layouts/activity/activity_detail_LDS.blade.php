
<h1>Learning and Development Section (LDS-Activity is intended for Internal Participants)</h1>
{{ Form::open(array('url' => '/activity_detail_CBS', 'method'=>'post')) }}
<row class="row">
<input type="hidden" name="reporting_to" value="{{Session::get('next')}}">
<input type="hidden" name="activity_id" value="{{$activity_id->id}}">
<div class="form-group col-md-4">
            <label for="">Activity Title</label>
            {!!Form::text('activity_title','',['class'=>'form-control'])!!}
        </div>

<div class="form-group col-md-4">
            <label for="">proposed date of conduct:</label>
            <input type="date" name="proposed_date_of_conduct" id="proposed_date" class="form-control">
        </div>

<div class="form-group col-md-4">
            <label for="">proposed venue:</label>
            {!!Form::text('proposed_venue','',['class'=>'form-control'])!!}
        </div>
</div>
<div class="row">

        <div class="form-group col-md-3">
            <label for="">Field Office:</label>
            {!!Form::number('field_office','',['class'=>'form-control'])!!}
        </div>
        <div class="form-group col-md-3">
            <label for="">Central Office:</label>
            {!!Form::number('central_office','',['class'=>'form-control'])!!}
        </div>
        <div class="form-group col-md-3">
            <label for="">Center of institutions(CIS):</label>
            {!!Form::number('CIS','',['class'=>'form-control'])!!}
        </div>
        
        <div class="form-group col-md-3">
            <label for="">OBLIGATED Amount (Based on Approved P.O):</label>
            {!!Form::number('obligated_amount','',['class'=>'form-control'])!!}
        </div>
</div>
<div class="row">
    <div class="col-12  text-center form-group">

    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-lg btn-secondary']) !!}
    </div>
</div>
{{ Form::close() }}


 <!-- ------internal participants---
-activity Title
-Proposed date of conduct
-proposed_venue
===target number of participants===
-Field Office
-central Office
-CIS
-Obligated Amount -->


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



