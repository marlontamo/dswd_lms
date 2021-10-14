<h1>Activity Details (Based on Approved Proposal) INTERNAL PARTICIPANTS</h1>

{{ Form::open(array('url' => '/activity_detail', 'method'=>'post')) }}

<div class="form-group col-md-3">
            <label for="">Activity Title</label>
            {!!Form::text('activity_title','',['class'=>'form-control'])!!}
        </div>

<div class="form-group col-md-3">
            <label for="">proposed date:</label>
            <input type="date" name="proposed_date" id="proposed_date" class="form-control">
        </div>

<div class="form-group col-md-3">
            <label for="">proposed venue:</label>
            {!!Form::text('proposed_venue','',['class'=>'form-control'])!!}
        </div>

<div class="form-group col-md-3">
            <label for="">Local Government unit(LGU):</label>
            {!!Form::text('LGU','',['class'=>'form-control'])!!}
        </div>

<div class="form-group col-md-3">
            <label for="">National Government Organization:(NGO)</label>
            {!!Form::text('NGO','',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-3">
            <label for="">National Government Agencies:</label>
            {!!Form::text('national_government_Agencies','',['class'=>'form-control'])!!}
        </div>

<div class="row">
    <div class="col-12  text-center form-group">

    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-lg btn-secondary']) !!}
    </div>
</div>
{{ Form::close() }}
