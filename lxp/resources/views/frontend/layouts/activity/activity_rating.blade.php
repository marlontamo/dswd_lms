<h1>activity rating form</h1>
{{ Form::open(array('url' => '/save_rating', 'method'=>'post')) }}

<div class="row">

<div class="form-group col-md-4">
    <input type="hidden" name="reporting_to" value="{{Session::get('after_record_number')}}">
        <label for="">Activity Title:</label>   
                 <select class="form-control" id="selectProvince" name="activity_id">
                    @foreach($activities as $activity)
                        <option value= "{{$activity->Activity_id}}">{{$activity->Activity_Title}}</option>
                    @endforeach
                 </select>
</div>


<div class="form-group col-md-4">
            <label for="">poor:</label>
            {!!Form::number('poor','',['class'=>'form-control'])!!}
        </div>

<div class="form-group col-md-4">
            <label for="">Fair:</label>
            {!!Form::number('fair','',['class'=>'form-control'])!!}
        </div>
</div>
<div class="row">
<div class="form-group col-md-4">
            <label for="">satisfactory:</label>
            {!!Form::number('satisfactory','',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-4">
            <label for="">Very Satisfactory:</label>
            {!!Form::number('vary_satisfactory','',['class'=>'form-control'])!!}
        </div>
<div class="form-group col-md-4">
            <label for="">Excellent:</label>
            {!!Form::number('excellent','',['class'=>'form-control'])!!}
        </div>
</div>


    <div class="col-12  text-center form-group">

    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-lg btn-secondary']) !!}
    </div>
</div>
{{ Form::close() }}
