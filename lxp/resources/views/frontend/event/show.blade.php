@extends('frontend.layouts.app')

@section('title', ($event->title) ? $event->title : app_name() )

@push('after-styles')
    <style>
        .leanth-course.go {
            right: 0;
        }
        
        .course-timeline-list {
            /* max-height: 300px;
            overflow: scroll; */
            border-style: double;

        }
        .course-details-category ul li {
            width: 100%;
        }
        .sidebar.is_stuck {
            top: 15% !important;
        }
    </style>
    <link rel="stylesheet" href="{{asset('plugins/plyr.css')}}"/>

@endpush

@section('content')

    <!-- Start of breadcrumb section
        ============================================= -->
    <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold"><span>{{$event->title}}</span></h2>
                </div>
            </div>
        </div>
    </section>
    <!-- End of breadcrumb section
        ============================================= -->

    <!-- Start of course details section
        ============================================= -->
    <section id="course-details" class="course-details-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="course-details-item border-bottom-0 mb-0">
                        <div class="course-single-text">
                            <div class="course-title mt10 headline relative-position">
                                <h3><a href="{{ route('event.show', [$event->slug]) }}" ><b>{{$event->title}}</b></a></h3>
                            </div>
                            <div class="course-details-content">
                                <p> {!! $event->description !!} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(!$registered_event)
                <div class="row">
                    <div class="col-md-12">
                        @if(config('swdforum_register'))
                            @if(!auth()->check())
                                    <a id="openLoginModal"
                                        class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                        data-target="#myModal" href="#">Please Login to access this event<i class="fas fa-caret-right"></i></a>
                            @else
                                    <a id="openRegisterModal"
                                        class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                        data-toggle="modal" data-target="#regModal" href="#">Click here to Register to This Event<i class="fas fa-caret-right"></i></a>
                                        
                                @if($errors->any())
                                    <h4 class="text-danger">{{$errors->first()}}</h4>
                                @endif
                            @endif
                        @else
                            <div class="d-flex justify-content-center">
                                <h4 class="text-danger">Please Login to access the Event</h4>
                            </div>
                        @endif
                    </div><br><br><br>
                    <div class="col-md-12">
                        <div class="course-details-item border-bottom-0 mb-0">
                            @if($event->event_poster != "")
                                @foreach(json_decode($event->event_poster) as $key=> $eventposter)
                                <div class="course-single-pic mb30">
                                    <img src="{{asset('storage/uploads/'.$eventposter)}}" alt="">
                                </div>
                                @endforeach 
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-9">
                        @if(session()->has('success'))
                            <div class="alert alert-dismissable alert-success fade show">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{session('success')}}
                            </div>
                        @endif
                        <div class="course-details-item border-bottom-0 mb-0">
                            @if($event->event_poster != "")
                                @foreach(json_decode($event->event_poster) as $key=> $eventposter)
                                    <div class="course-single-pic mb30">
                                        <img src="{{asset('storage/uploads/'.$eventposter)}}" alt="">
                                    </div>
                                @endforeach 
                            @endif 

                            <div class="course-single-text">
                                @if(count($activities)  > 0)
                                    <div class="course-details-category ul-li">
                                        <span class="float-none">ACTIVITIES</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- /course-details -->

                        <div class="affiliate-market-guide mb65">

                            <div class="affiliate-market-accordion">
                                <div id="accordion" class="panel-group">
                                    @if(count($activities)  > 0)
                                        @php $count = 0; @endphp
                                        @foreach($activities as $key=> $act)
                                        @php $count++ @endphp

                                        <div class="panel position-relative">
                                        
                                            @if(in_array($act->id,$completed_acts))
                                                <div class="position-absolute" style="right: 0;top:0px">
                                                    <span class="gradient-bg p-1 text-white font-weight-bold completed">Attended</span>
                                                </div>
                                            @endif
                                            <div class="panel-title" id="headingOne">
                                                <div class="ac-head">
                                                    <button class="btn btn-link @if($act->activity_date != date('Y-m-d')) collapsed @endif" 
                                                            data-toggle="collapse"
                                                            data-target="#collapse{{$count}}" aria-expanded="false"
                                                            aria-controls="collapse{{$count}}">
                                                        <span>{{ sprintf("%02d", $count)}}</span>
                                                        {{$act->title}}
                                                            <!-- <button onclick="getSurveyQuestions('{{$event->id}}','{{$act->id}}','{{$act->pes_id}}')" data-toggle="modal" data-target="#exampleModal" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"> Click Here For Post Evaluation Survey </button> -->
                                                        @if($act->activity_date == date('Y-m-d'))
                                                            <p>
                                                                @if(isset($activate_post_eval[$act->id]) && $activate_post_eval[$act->id] && date('Y-m-d H:i') >= date('Y-m-d 10:00'))
                                                                
                                                                <button onclick="getSurveyQuestions('{{$event->id}}','{{$act->id}}','{{$act->pes_id}}')" data-toggle="modal" data-target="#exampleModal" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"> Click Here For Post Evaluation Survey </button>
                                                                @endif

                                                                @if(in_array($act->id,$completed_acts))
                                                                    <a href="{{$act->link}}" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font" target="_blank"> Join the activity  </a>
                                                                @else
                                                                    <button onclick="joinMeeting( '{{$act->link}}','{{$act->id}}','{{$act->activity_date}}','TRUE')" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font" > Click Here for attendance  </button>
                                                                @endif
                                                            </p>
                                                        @elseif($act->activity_date > date('Y-m-d'))
                                                            <button onclick="joinMeeting( '{{$act->link}}','{{$act->id}}','{{$act->activity_date}}','FALSE'  )" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font" > Click here for attendance  </button>
                                                                <!-- <button data-toggle="modal" data-target="#alertModal" class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font" > Click Here to Join the meeting  </button> -->
                                                        
                                                        @endif
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div id="collapse{{$count}}" class="collapse @if($act->activity_date == date('Y-m-d')) show @endif" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <div class="col-md-12">
                                                    @if($act->act_posters != "")
                                                        <div class="course-details-item border-bottom-0 mb-0">
                                                            @foreach(json_decode($act->act_posters) as $key=> $eventimage)
                                                                <div class="course-single-pic mb30">
                                                                    <img src="{{asset('storage/uploads/'.$eventimage)}}" alt="">
                                                                </div>
                                                            @endforeach 
                                                        </div>
                                                    @endif
                                                    
                                                    @if(($act->downloadableMedia != "") && ($act->downloadableMedia->count() > 0))
                                                        <h4> @lang('labels.frontend.course.download_files') </h4>
                                                        @foreach($act->downloadableMedia as $media)
                                                            <div class="course-single-text mt-4 px-3 py-1 gradient-bg text-white">
                                                                <div class="course-details-content text-white">
                                                                    <p class="form-group">
                                                                        <a href="{{ route('downloadeventfile',['filename'=>$media->name,'eventact_id'=>$act->id]) }}"
                                                                        class="text-white font-weight-bold"><i class="fa fa-download"></i> {{ $media->name }}
                                                                            ({{ number_format((float)$media->size / 1024 , 2, '.', '')}} @lang('labels.frontend.course.mb'))</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <!-- <div class="col-md-12">
                                                    <p> {!! $act->full_text !!} </p>
                                                </div> -->
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /market guide -->
                    </div>

                    <div class="col-md-3">
                        <div id="sidebar" class="sidebar">
                            @if(count($participants)  > 0)
                                <h3>Registered Participants</h3>
                                <div class="course-details-category ul-li">
                                    <ul class="course-timeline-list">
                                    @php $count = 0; @endphp
                                    @foreach($participants as $key=> $user)
                                    <li> {{$user->fullname}} </li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            @endif
        </div>

        <!-- Modal -->
        <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header backgroud-style">
                    <div class="gradient-bg"></div>
                    <div class="popup-logo">
                        <img src="{{asset("storage/logos/".config('logo_popup'))}}" alt="">
                    </div>
                    <div class="popup-text text-center">
                        <h2>DSWD CAR LXP Alert</h2>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h5>Good day, participants. The attendance and/or google meet will be accepting participants starting on <span id = "sesdate">12 April 2021 </span>.</h5> 
                    <h5>Just log in with your username and password. Thank you for bearing with us.</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="regModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header backgroud-style">
                        <div class="gradient-bg"></div>
                        <div class="popup-logo">
                            <img src="{{asset("storage/logos/".config('logo_popup'))}}" alt="">
                        </div>
                        <div class="popup-text text-center">
                            <h2>Please fillout this form to register as participants to this event.</h2>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{ route('event.register') }}" method="POST">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}"/>

                            <div class="col-md-12">
                                <label>Organization/ Office: </label>
                                <div> 
                                    <select name="org" id="org" class="form-control">
                                        <option value="DSWD">DSWD</option>
                                        <option value="Local Government Unit (LGU)">Local Government Unit (LGU)</option>
                                        <option value="Civil Society Organization">Civil Society Organization</option>
                                        <option value="Academe">Academe</option>
                                        <option value="Peoples' Organization">Peoples' Organization</option>
                                        <option value="National Government Agency (NGA)">National Government Agency (NGA)</option>
                                        <option value="Private Sector">Private Sector</option>
                                        <option value="Non- Government Organization (NGO)">Non- Government Organization (NGO)</option>
                                        <option value="Religious Sector">Religious Sector</option>
                                        <option value="Business Sector">Business Sector</option>
                                        <option value="Media">Media</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <label>Division/ Section/ Program (for DSWD Staff only)</label>
                                <div> 
                                    <input type="text" class="form-control" name="odsu" id="odsu">
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <label>Office/Department/School (for other organizations)</label>
                                <div> 
                                    <input type="text" class="form-control" name="office" id="office">
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <label>Why do you want to attend this learning session? </label>
                                <div> 
                                    <textarea class="form-control"  name="reason" id="reason" cols="30" rows="10" required></textarea>
                                </div>
                            </div>
                            <hr>
                            <button class="genius-btn btn-block text-white  gradient-bg text-center text-uppercase  bold-font"
                                    href="#"  target="_blank">Save<i class="fas fa-caret-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header backgroud-style">
                    <div class="gradient-bg"></div>
                    <div class="popup-logo">
                        <img src="{{asset("storage/logos/".config('logo_popup'))}}" alt="">
                    </div>
                    <div class="popup-text text-center">
                        <h2>Post Evaluation Survey</h2>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form method="POST" action="{{ route('event.saveSurvey') }}">
                    @csrf
                  <div id="survey_body" class="modal-body">
                  </div>
                  <input type="hidden" name="event" id="survey_event">
                  <input type="hidden" name="activity" id="survey_activity">
                  <input type="hidden" name="survey" id="survey">
                
              <div class="modal-footer">
                <button class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
              </form>
            </div>
          </div>
        </div>



    </section>
    <!-- End of course details section
        ============================================= -->

@endsection

@push('after-scripts')
    <!-- <script src="https://cdn.plyr.io/3.5.3/plyr.polyfilled.js"></script> -->
    <script src="{{asset('plugins/plyr.polyfilled.js')}}"></script>

    <script>
        const player = new Plyr('#player');

        $(document).on('change', 'input[name="stars"]', function () {
            $('#rating').val($(this).val());
        })

        @if(isset($review))
        var rating = "{{$review->rating}}";
        $('input[value="' + rating + '"]').prop("checked", true);
        $('#rating').val(rating);
        @endif

        function joinMeeting(link,activity_id,activity_date,sesavailable) {
            //alert(link);
            if(sesavailable == "TRUE"){
                $.ajax({
                    url: "{{route('event.eventactProgress')}}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'activity_id': parseInt(activity_id)
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.success) {
                            window.open(link, '_blank');
                        }else{
                            alert(result.message);
                        }
                    }
                });
            }else{
                const months = ["JANUARY", "FEBRUARY", "MARCH","APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
                let current_datetime = new Date(activity_date)
                let formatted_date = current_datetime.getDate() + " " + months[current_datetime.getMonth()] + " " + current_datetime.getFullYear()
                $('#sesdate').html(formatted_date);
                $('#alertModal').modal();
            }
        }


        function getSurveyQuestions(event,activity,pes_id)
        {
            console.log(event + " - " + activity + " - " + pes_id);
            $("#survey_event").val(event);
            $("#survey_activity").val(activity);
            $("#survey").val(pes_id);

            $.ajax({
                    url: "{{route('event.surveyQuestions')}}",
                    method: "POST",
                    data: {
                        'pes_id': parseInt(pes_id),
                        'activity': parseInt(activity),
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.success) {
                            let form_body = '';

                            if(result.data.length > 0)
                            {
                                $.each(result.data, function( index, value ) {
                                    if(parseInt(value.sme) == 0)
                                    {
                                        form_body += '<div class="form-group">';
                                        form_body += '    <label class="col-form-label">'+value.question+'</label>';

                                        if(value.answer_type == 1){
                                            form_body += '<div class="form-control"> <div class = "row">';
                                            form_body += ' <div class="col-md-2"> <input type="radio" name="question['+value.peq_id+']" value="5" required> Excellent </input> </div>';
                                            form_body += ' <div class="col-md-3"> <input type="radio" name="question['+value.peq_id+']" value="4" required> Very Satisfactory </input> </div>';
                                            form_body += ' <div class="col-md-3"> <input type="radio" name="question['+value.peq_id+']" value="3" required> Satisfactory </input> </div>';
                                            form_body += ' <div class="col-md-2"> <input type="radio" name="question['+value.peq_id+']" value="2" required> Fair </input> </div>';
                                            form_body += ' <div class="col-md-2"> <input type="radio" name="question['+value.peq_id+']" value="1" required> Poor </input> </div>';
                                            form_body += '</div></div>';
                                        }else{
                                            form_body += '<div class = "row"> <div class="col-md-12"> <textarea name="question['+value.peq_id+']" class="form-control" required> </textarea> </div></div>';
                                        }

                                        form_body += '</div>';
                                    }
                                });


                                if(result.smes.length > 0)
                                {
                                    $.each(result.smes, function( i, v ) {
                                        form_body += '<hr>';
                                        form_body += '<h4>SME:'+v+'</h4>';
                                        $.each(result.data, function( index, value ) {
                                            if(parseInt(value.sme) == 1)
                                            {
                                                form_body += '<div class="form-group">';
                                                form_body += '    <label class="col-form-label">'+value.question+'</label>';
                                                
                                                if(value.answer_type == 1){
                                                    form_body += '<div class="form-control"> <div class = "row">';
                                                    form_body += '<div class="col-md-2"> <input type="radio" name="question['+value.peq_id+'_'+v+']" value="5" required> Excellent </input></div>';
                                                    form_body += '<div class="col-md-3"> <input type="radio" name="question['+value.peq_id+'_'+v+']" value="4" required> Very Satisfactory </input></div>';
                                                    form_body += '<div class="col-md-3"> <input type="radio" name="question['+value.peq_id+'_'+v+']" value="3" required> Satisfactory </input></div>';
                                                    form_body += '<div class="col-md-2"> <input type="radio" name="question['+value.peq_id+'_'+v+']" value="2" required> Fair </input></div>';
                                                    form_body += '<div class="col-md-2"> <input type="radio" name="question['+value.peq_id+'_'+v+']" value="1" required> Poor </input></div>';
                                                    form_body += '</div></div>';
                                                }else{
                                                    form_body += '<div class = "row"> <textarea name="question['+value.peq_id+'_'+v+']" class="form-control" required> </textarea> </div>';
                                                }

                                                form_body += '</div>';
                                            }
                                        });
                                    });
                                }


                                $("#survey_body").html(form_body);
                            }

                        }else{
                            alert(result.message);
                        }
                    }
                });
        }

    </script>
@endpush