
<h1>Create Activity Accomplishment</h1>
{{ Form::open(array('url' => '/create_activity', 'method'=>'post')) }}
       <div class="row">
       
        
            <input type="hidden" class="form-control" name="email" id="email" value="{{Auth::user()->email}}">
        
        <div class="form-group col-md-4">
            <label for="reporting_to">Reporting to:</label>
            <select class="form-control" id="reporting_to" name="reporting_to">
            
           @foreach($reportingTo as $report)
            <option value= "{{$report->id}}">{{$report->title}}</option>
            @endforeach
            </select>

        </div>
        <!-- </div>
        <div class="row"> -->
        
    
  
            <div class="col-6 col-md-4  form-group">
                 <label for="selectProvince">Division:</label>   
                 <select class="form-control" id="selectProvince" name="division">
                    @foreach($divisions as $division)
                        <option value= "{{$division->id}}">{{$division->div_title}}</option>
                    @endforeach
                 </select>
            </div>
        <div class="col-6 col-md-4  form-group">
            <label for="report_period">Reporting Period:</label>   
            <input type="month" name="reporting_period" id="report_period" class="form-control" pattern="\d{4}-\d{2}-\d{2}">
        </div>
        </div>
        
        <div class="row">
                <div class="col-12  text-center form-group">

                    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-lg btn-secondary']) !!}
                </div>
            </div>
            
      
{{ Form::close() }}
