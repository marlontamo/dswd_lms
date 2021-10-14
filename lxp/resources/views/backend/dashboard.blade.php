@extends('backend.layouts.app')

@section('title', __('strings.backend.dashboard.title').' | '.app_name())

@push('after-styles')
    <style>
        .trend-badge-2 {
            top: -10px;
            left: -52px;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            position: absolute;
            padding: 40px 40px 12px;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            background-color: #ff5a00;
        }

        .progress {
            background-color: #b6b9bb;
            height: 2em;
            font-weight: bold;
            font-size: 0.8rem;
            text-align: center;
        }

        .best-course-pic {
            background-color: #333333;
            background-position: center;
            background-size: cover;
            height: 150px;
            width: 100%;
            background-repeat: no-repeat;
        }


    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Welcome {{ $logged_in_user->name }}!</strong>
                </div>
                <!--card-header-->
                <div class="card-body">
                    <div class="row">
                    @if(auth()->user()->hasRole('superadmin') or auth()->user()->hasRole('admin'))
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{$courses_count}}</h1>
                                    <h3>Courses</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-light text-dark text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{$students_count}}</h1>
                                    <h3>Learners</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="card text-white bg-primary text-center py-3">
                                <div class="card-body">
                                    <h1 class="">{{$teachers_count}}</h1>
                                    <h3>Subject Matter Experts</h3>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <h1>Dashboard</h1>
                        </div>
                    @endif
                    </div>
                    
                    @if(auth()->user()->hasRole('teacher'))
                    <hr>
                    <div class="row">
                    
                        <div class="col-12">
                            <h4>My Courses</h4>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-3 col-12 border-right">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card text-white bg-primary text-center">
                                                <div class="card-body">
                                                    <h2 class="">{{count(auth()->user()->courses)}}</h2>
                                                    <h5>Your Courses</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card text-white bg-success text-center">
                                                <div class="card-body">
                                                    <h2 class="">{{$students_count}}</h2>
                                                    <h5>Learners Enrolled To Your Courses</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 col-12 border-right">
                                    <div class="d-inline-block form-group w-100">
                                        <h4 class="mb-0">Recent Reviews <a
                                                    class="btn btn-primary float-right"
                                                    href="{{route('admin.reviews.index')}}">View All</a>
                                        </h4>

                                    </div>
                                    <table class="table table-responsive-sm table-striped">
                                        <thead>
                                        <tr>
                                            <td>Course</td>
                                            <td>Review</td>
                                            <td>Time</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($recent_reviews) > 0)
                                            @foreach($recent_reviews as $item)
                                                <tr>
                                                    <td>
                                                        <a target="_blank"
                                                           href="{{route('courses.show',[$item->reviewable->slug])}}">{{$item->reviewable->title}}</a>
                                                    </td>
                                                    <td>{{$item->content}}</td>
                                                    <td>{{$item->created_at->diffforhumans()}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">No data available</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="d-inline-block form-group w-100">
                                        <h4 class="mb-0">Recent Messages <a
                                                    class="btn btn-primary float-right"
                                                    href="{{route('admin.messages')}}">View All</a>
                                        </h4>
                                    </div>


                                    <table class="table table-responsive-sm table-striped">
                                        <thead>
                                        <tr>
                                            <td>Message By</td>
                                            <td>Message</td>
                                            <td>Time</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($threads) > 0)
                                            @foreach($threads as $item)
                                                <tr>
                                                    <td>
                                                        <a target="_blank"
                                                           href="{{asset('/user/messages/?thread='.$item->id)}}">{{$item->title}}</a>
                                                    </td>
                                                    <td>{{$item->lastMessage->body}}</td>
                                                    <td>{{$item->lastMessage->created_at->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">No data available</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if(auth()->user()->hasRole('student'))
                    <hr>
                    <div class="row">

                            <div class="col-12">
                                <h4>Enrolled Courses</h4>
                            </div>

                            @if(count($purchased_courses) > 0)

                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($purchased_courses as $item)
                                        <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td><a href="{{ route('courses.show', [$item->slug]) }}">{{$item->title}}</a></td>
                                        <td>
                                            <a href="{{route('courses.category',['category'=>$item->category->slug])}}"
                                                   class="bg-success text-decoration-none px-2 p-1">{{$item->category->name}}</a>
                                        </td>
                                        <td>
                                            <div class="progress my-2">
                                                <div class="progress-bar" style="width:{{$item->progress() }}%"> 
                                                    Completed {{ $item->progress()  }} %
                                                </div>
                                            </div>
                                            @if($item->progress() == 100)
                                                @if(!$item->isUserCertified())
                                                    <!-- <form method="post" action="{{route('admin.certificates.generate')}}">
                                                        @csrf
                                                        <input type="hidden" value="{{$item->id}}"
                                                                name="course_id">
                                                        <button class="btn btn-success btn-block text-white mb-3 text-uppercase font-weight-bold"
                                                                id="finish">Finish Course</button>
                                                    </form> -->
                                                @else
                                                    <div class="alert alert-success px-1 text-center mb-0">
                                                        You're Certified for this course
                                                    </div>
                                                @endif
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="col-12 text-center">
                                    <h4 class="text-center">No data available</h4>
                                    <a class="btn btn-primary"
                                       href="{{route('courses.all')}}">Enroll Courses Now
                                        <i class="fa fa-arrow-right"></i></a>
                                </div>
                            @endif
                    </div>
                    @endif

                    <hr>
                    <div class="row">

                            <div class="col-12">
                                <h4>Events attended</h4>
                            </div>

                            @if(count($attendedEvents) > 0)
                            
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attendedEvents as $item)
                                        <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td><a href="{{ route('event.show', [$item->slug]) }}">{{$item->title}}</a></td>
                                        <td>
                                            <a href="{{route('courses.category',['category'=>$item->category->slug])}}"
                                                   class="bg-success text-decoration-none px-2 p-1">{{$item->category->name}}</a>
                                        </td>
                                        <td>                                                    
                                            <div class="progress my-2">
                                                <div class="progress-bar" style="width:{{$item->progress() }}%">
                                                    Completed
                                                    {{ $item->progress()  }} %
                                                </div>
                                            </div>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="col-12 text-center">
                                    <h4 class="text-center">No data available</h4>
                                </div>
                            @endif
                    </div>
                    
                </div>
            </div><!--card-body-->
        </div><!--card-->
    </div><!--col-->
@endsection
