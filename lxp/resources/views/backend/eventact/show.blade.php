@extends('backend.layouts.app')
@section('title', 'Events Activity | '.app_name())

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Event Activity & Post Evaluation Report</h3>
        </div>
        <div class="card-body">
            <h4>Event Activity</h4>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Events</th>
                            <td>{{ $eventact->events->title}}</td>
                        </tr>
                        <tr>
                            <th>Activity Title</th>
                            <td>{{ $eventact->title }}</td>
                        </tr>
                        <tr>
                            <th>Activity slug</th>
                            <td>{{ $eventact->slug }}</td>
                        </tr>
                        <tr>
                            <th>Activity Posters</th>
                            <td>
                            @if($eventact->act_posters)
                                @foreach(json_decode($eventact->act_posters) as $key=> $eventimage)
                                    <a href="{{ asset('storage/uploads/' . $eventimage) }}" target="_blank"><img
                                                src="{{ asset('storage/uploads/' . $eventimage) }}" height="100px"/></a>
                                @endforeach 
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{!! $eventact->full_text !!}</td>
                        </tr>
                        <tr>
                            <th>Sequence</th>
                            <td>{{ $eventact->sequence }}</td>
                        </tr>

                        <tr>

                            <th>Presentations / Files</th>
                            <td>
                                @if(count($eventact->downloadableMedia) > 0 )
                                    @foreach($eventact->downloadableMedia as $media)
                                        <p class="form-group">
                                            <a href="{{ asset('storage/uploads/'.$media->name) }}"
                                               target="_blank">{{ $media->name }}
                                                ({{ $media->size }} KB)</a>
                                        </p>
                                    @endforeach
                                @else
                                    <p>No Files</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Published</th>
                            <td>{{ Form::checkbox("published", 1, $eventact->published == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            <div class = "row">
                <div class="col-md-6">
                    <h4>Post Evaluation Report</h4>
                </div>
                <div class="col-md-6">
                    <a class = "float-right" href="{{ URL::to('user/downloadExcel/' . $eventact->id) }}"><button class="btn btn-success float-right">Download Excel xls</button></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="align-middle" rowspan="2">Areas</th>
                                <th>Excellent</th>
                                <th>Very Satisfactory</th>
                                <th>Satisfactory</th>
                                <th>Fair</th>
                                <th>Poor</th>
                                <th class="align-middle" rowspan="2">Total Respondent</th>
                                <th colspan="2">Rating Per Item</th>
                            </tr>
                            <tr>
                                <th>4.5-5</th>
                                <th>4.5-3.49</th>
                                <th>2.5-3.49</th>
                                <th>1.5-2.49</th>
                                <th>1.49-below</th>
                                <th>Rate</th>
                                <th>Adjective</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($full_questions as $key => $value)
                                @if($key != "")
                                <tr>
                                   <td colspan="9" class="font-weight-bold">{{$key}}</td> 
                                </tr>
                                @endif
                                    @if(!empty($value))
                                        @foreach($value as $key_ans => $value_ans)
                                         <tr>
                                            <td class="font-weight-bold">{{$value_ans['question']}}</td>
                                            <td> 
                                                @if(isset($value_ans['stats'][5]))
                                                    {{ $value_ans['stats'][5] }}<br>
                                                    <span class="badge badge-info">
                                                        {{ number_format(($value_ans['stats'][5]/$value_ans['respondents'])*100) }}%
                                                    </span>
                                                @endif
                                                
                                            </td>
                                            <td> 
                                                @if(isset($value_ans['stats'][4]))
                                                    {{ $value_ans['stats'][4] }}<br>
                                                    <span class="badge badge-info">
                                                        {{ number_format(($value_ans['stats'][4]/$value_ans['respondents'])*100) }}%
                                                    </span>
                                                @endif
                                            </td>
                                            <td> 
                                                @if(isset($value_ans['stats'][3]))
                                                    {{ $value_ans['stats'][3] }}<br>
                                                    <span class="badge badge-info">
                                                        {{ number_format(($value_ans['stats'][3]/$value_ans['respondents'])*100) }}%
                                                    </span>
                                                @endif
                                            </td>
                                            <td> 
                                                @if(isset($value_ans['stats'][2]))
                                                    {{ $value_ans['stats'][2] }}<br>
                                                    <span class="badge badge-info">
                                                        {{ number_format(($value_ans['stats'][2]/$value_ans['respondents'])*100) }}%
                                                    </span>
                                                @endif
                                            </td>
                                            <td> 
                                                @if(isset($value_ans['stats'][1]))
                                                    {{ $value_ans['stats'][1] }}<br>
                                                    <span class="badge badge-info">
                                                        {{ number_format(($value_ans['stats'][1]/$value_ans['respondents'])*100) }}%
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{$value_ans['respondents']}}
                                            </td>
                                            <td>
                                                {{$value_ans['rate']}}
                                            </td>
                                            <td>
                                                {{$value_ans['adjective']}}
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            <div class="row">
                <div class="col-md-12">
                    @foreach($qtext_ans as $key => $value)
                        @if($key != "")
                            <h4>{{$key}}</h4>
                        @else
                            <h4>General Question</h4>
                        @endif

                        <ol style="list-style: decimal inside;">
                            @foreach($value as $a_key => $a_value)
                                <li>{{$a_key}}</li>
                                
                                <ol style="list-style: decimal inside;">
                                    @foreach($a_value as $k_ans => $v_ans)
                                        <li>{{$v_ans}}</li>
                                    @endforeach
                                </ol>
                                
                            @endforeach
                        </ol>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('admin.eventacts.index', ['event_id' => $eventact->events->id]) }}"
               class="btn btn-default border">@lang('strings.backend.general.app_back_to_list')</a>
        </div>
    </div>
@stop