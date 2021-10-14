@extends('backend.layouts.app')
@section('title', __('labels.backend.courses.title').' | '.app_name())

@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/amigo-sorter/css/theme-default.css')}}">
    <style>
        ul.sorter > span {
            display: inline-block;
            width: 100%;
            height: 100%;
            background: #f5f5f5;
            color: #333333;
            border: 1px solid #cccccc;
            border-radius: 6px;
            padding: 0px;
        }

        ul.sorter li > span .title {
            padding-left: 15px;
            width: 70%;
        }

        ul.sorter li > span .btn {
            width: 20%;
        }

        @media screen and (max-width: 768px) {

            ul.sorter li > span .btn {
                width: 30%;
            }

            ul.sorter li > span .title {
                padding-left: 15px;
                width: 70%;
                float: left;
                margin: 0 !important;
            }

        }


    </style>
@endpush

@section('content')

    <div class="card">

        <div class="card-header">
            <h3 class="page-title mb-0">@lang('labels.backend.courses.title')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('labels.backend.courses.fields.teachers')</th>
                            <td>
                                @foreach ($course->teachers as $singleTeachers)
                                    <span class="label label-info label-many">{{ $singleTeachers->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.title')</th>
                            <td>
                                @if($course->published == 1)
                                    <a target="_blank"
                                       href="{{ route('courses.show', [$course->slug]) }}">{{ $course->title }}</a>
                                @else
                                    {{ $course->title }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.slug')</th>
                            <td>{{ $course->slug }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.category')</th>
                            <td>{{ $course->category->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.description')</th>
                            <td>{!! $course->description !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.course_image')</th>
                            <td>@if($course->course_image)<a
                                        href="{{ asset('storage/uploads/' . $course->course_image) }}"
                                        target="_blank"><img
                                            src="{{ asset('storage/uploads/' . $course->course_image) }}"
                                            height="50px"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.lessons.fields.media_video')</th>
                            <td>
                                @if($course->mediaVideo !=  null )
                                    <p class="form-group mb-0">
                                        <a href="{{$course->mediaVideo->url}}"
                                           target="_blank">{{$course->mediaVideo->url}}</a>
                                    </p>
                                @else
                                    <p>No Videos</p>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.start_date')</th>
                            <td>{{ $course->start_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.published')</th>
                            <td>{{ Form::checkbox("published", 1, $course->published == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>

                        <tr>
                            <th>@lang('labels.backend.courses.fields.meta_title')</th>
                            <td>{{ $course->meta_title }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.meta_description')</th>
                            <td>{{ $course->meta_description }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.meta_keywords')</th>
                            <td>{{ $course->meta_keywords }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            @if(count($courseTimeline) > 0)
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-12  ">
                        <h4 class="">@lang('labels.backend.courses.course_timeline')</h4>
                        <p class="mb-0">@lang('labels.backend.courses.listing_note')</p>
                        <p class="">@lang('labels.backend.courses.timeline_description')</p>
                        <ul class="sorter d-inline-block">

                            @foreach($courseTimeline as $key=>$item)

                                @if(isset($item->model) && $item->model->published == 1)

                                    <li>
                                        <span data-id="{{$item->id}}" data-sequence="{{$item->sequence}}">
                                    @if($item->model_type == 'App\Models\Test')
                                        <p class="d-inline-block mb-0 btn btn-primary">
                                            @lang('labels.backend.courses.test')
                                         </p>
                                    @elseif($item->model_type == 'App\Models\Lesson')
                                      <p class="d-inline-block mb-0 btn btn-success">
                                        @lang('labels.backend.courses.lesson')
                                     </p>
                                     @endif
                                    @if($item->model)
                                    <p class="title d-inline ml-2">{{$item->model->title}}</p>
                                    @endif
                                     </span>

                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <a href="{{ route('admin.courses.index') }}"
                           class="btn btn-default border float-left">@lang('strings.backend.general.app_back_to_list')</a>

                        <a href="#" id="save_timeline"
                           class="btn btn-primary float-right">@lang('labels.backend.courses.save_timeline')</a>

                    </div>

                </div>
            @endif

            <hr>
            
            <div class = "row">
                <div class="col-md-6">
                    <h4>Post Evaluation Report</h4>
                </div>
                <div class="col-md-6">
                    <a class = "float-right" href="{{ URL::to('user/downloadCourseExcel/' . $course->id) }}"><button class="btn btn-success float-right">Download PES Report</button></a>
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
        </div>
    </div>
@stop

@push('after-scripts')
    <script src="{{asset('plugins/amigo-sorter/js/amigo-sorter.min.js')}}"></script>
    <script>
        $(function () {
            $('ul.sorter').amigoSorter({
                li_helper: "li_helper",
                li_empty: "empty",
            });
            $(document).on('click', '#save_timeline', function (e) {
                e.preventDefault();
                var list = [];
                $('ul.sorter li').each(function (key, value) {
                    key++;
                    var val = $(value).find('span').data('id');
                    list.push({id: val, sequence: key});
                });

                $.ajax({
                    method: 'POST',
                    url: "{{route('admin.courses.saveSequence')}}",
                    data: {
                        _token: '{{csrf_token()}}',
                        list: list
                    }
                }).done(function () {
                    location.reload();
                });
            })
        });

    </script>
@endpush