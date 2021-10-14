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

    .listing-filter-form select {
        height: 50px !important;
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

 <section id="breadcrumb"  class="invisible breadcrumb-section relative-position backgroud-style">
    <!-- <div class="blakish-overlay"></div> -->
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
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<section class="container">

    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link " data-toggle="tab" href="#tabs-1" role="tab">Create activity (first step)</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Activity Detail (second step)</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Add Actual number of participants(third step)</a>
        </li>

    </ul><!-- Tab panes -->

    <div class="tab-content">
        <div class="tab-pane" id="tabs-1" role="tabpanel">
            <div> @include('frontend.layouts.activity.create_activity')</div>
        </div>


        <div class="tab-pane" id="tabs-2" role="tabpanel">
            @if(Session::get('next')== null)
            <div class="alert alert-danger text-center">please do the first step first to proceed</div>
            
            @elseif(Session::get('next')==1)
            <div>@include('frontend.layouts.activity.activity_detail_LDS')</div>
            
            @elseif(Session::get('next')==2)
            <div>@include('frontend.layouts.activity.activity_detail_CBS_external')</div>
            
            @elseif(Session::get('next')==3)
            <div>@include('frontend.layouts.activity.activity_detail_CBS_internal_staff')</div>
            @endif
        </div>
        <div class="tab-pane" id="tabs-3" role="tabpanel">
        
  
       
        @if(session()->get('after_detail'))
            <div>@include('frontend.layouts.activity.actual_number_of_participants_dswdstaff')</div>
            @elseif(session()->get('after_detail') == null)
            <div class="alert alert-danger text-center">please provide information on the first and second step to proceed</div>
            @endif
        </div>
        
        
    </div>
</section>
<section class="container">
    

<div class="invisible">@include('frontend.layouts.activity.activity_rating')</div>
</section>



@endsection