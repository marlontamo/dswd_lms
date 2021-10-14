@extends('frontend.layouts.app')
@section('title', trans('labels.frontend.course.courses').' | '. app_name() )

@push('after-styles')
    <style>
        .couse-pagination li.active {
            color: #333333 !important;
            font-weight: 700;
        }

        .page-link {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #c7c7c7;
            background-color: white;
            border: none;
        }

        .page-item.active .page-link {
            z-index: 1;
            color: #333333;
            background-color: white;
            border: none;

        }
     .listing-filter-form select{
            height:50px!important;
        }

        ul.pagination {
            display: inline;
            text-align: center;
        }
    }
    </style>
@endpush
@section('content')

 <!-- Start of breadcrumb section
        ============================================= -->

        <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
        <div class="blakish-overlay"></div>
        <div class="container">
            <!-- <div class="page-breadcrumb-content text-center">
                <div class="page-breadcrumb-title">
                    <h2 class="breadcrumb-head black bold">
                      
                    </h2>
                </div>
            </div> -->
        </div>
    </section>
    <!-- End of breadcrumb section
        ====================start form create activity accomplishment========================= -->
<!-- error -->
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!-- end error -->

<section class="container">
        <table class="table table-dark">
  <thead class="thead-dark ">
    <tr>
     <th>Activity ID</th>
      <th scope="col">User Id</th>
      <th scope="col">Email</th>
      <th scope="col">reporting To</th>
      <th scope="col">reporting period</th>
      <th scope="col">division</th>
      <th scope="col">Actions</th>

    </tr>
  </thead>
  <tbody>
   
   @if(count($activities)>0)
  
    @foreach($activities as $activity)
   
    <tr>
      <th scope="row">{{$activity->id}}</th>
      <td class="text-light">{{$activity->user_id}}</td>
      <td class="text-light">{{$activity->email}}</td>
      <td class="text-light">{{$activity->reporting_to}}</td>
      <td class="text-light">{{$activity->reporting_period}}</td>
      <td class="text-light">{{$activity->div_id}}</td>
      <td class="text-light">
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary btn-sm"><a href="{{route('viewActivity',['id'=>$activity->id])}}">view</a></button>
        <button type="button" class="btn btn-warning btn-sm"><a href="{{route('edit-activity', ['id'=>$activity->id])}}">edit</a></button>
        <button type="button" class="btn btn-danger btn-sm"><a href="{{route('delete-activity', ['id'=>$activity->id])}}">delete</a></button>
    </div>
      </td>

</tr>
      @endforeach
    @else
    <h1 class="text-dark">no record found..</h1>
 @endif
  </tbody>
</table>
</section>

    
 

@endsection
