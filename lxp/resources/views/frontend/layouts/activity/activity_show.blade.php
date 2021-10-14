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

<section class="container">
    <div class="row">
           
    <table class="table table-dark">
  <thead>
 
    <tr>
      <th scope="col">Title</th>
      <th scope="col">Proposed date</th>
      <th scope="col">Proposed venue</th>
      <th>field office</th>
      <th>central office</th>
      <th>CIS</th>
      <th scope="col">obligated amount</th>
      

      
    </tr>

  </thead>
  <tbody>
  
  
  
  <tr>
      <td scope="">{{$details->Activity_Title}}</td>
      <td>{{$details->Proposed_date_of_conduct}}</td>
      <td>{{$details->proposed_venue}}</td>
      <td>{{$details->field_office}}</td>
      <th>{{$details->central_office}}</th>
      <th>{{$details->CIS}}</th>
      <th>{{$details->obligated_amount}}</th>
      
    </tr>
   
   </tbody>
</table>
<table class="table table-dark">
  <thead>
    <tr>
    <th>LGU</th>
      <th>NGA</th>
      <th>NGO</th>
      <th>PO</th>
      <th>Volunteers</th>
      <th>Stakeholders</th>
      <th>Academe</th>
      <th>Religious</th>
      <th>Business</th>
      <th>Media</th>
      <th>Beneficiaries</th>
      <th>action</th>
    </tr>

  </thead>
  <tbody>
 
  <tr>
  <th>{{$details->LGU}}</th>
      <th>{{$details->NGA}}</th>
      <th>{{$details->NGO}}</th>
      <th>{{$details->PO}}</th>
      <th>{{$details->volunteers}}</th>
      <th>{{$details->stakeholders}}</th>
      <th>{{$details->academe}}</th>
      <th>{{$details->religious_sector}}</th>
      <th>{{$details->business_sector}}</th>
      <th>{{$details->media}}</th>
      <th>{{$details->beneficiaries}}</th>
      <th>
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-primary btn-sm"><a href="">view participants</a></button>
    </div>
      </th>
    </tr>
  
   </tbody>
</table>
<table class="table table-dark">
    <thead>
        <tr>
            <th>Participant group</th>
            <th>Municipality</th>
            <th>city</th>
            <th>male</th>
            <th>female</th>

        </tr>
    </thead> 
    <tbody>
        @if(!count($participants)>0)
        <b>no available data for this section</b>
        @else
        @foreach($participants as $participant)
        <tr>
            <td>{{$participant->participant_group}}</td>
            <td>{{$participant->minicipality_represented}}</td>
            <td>{{$participant->city}}</td>
            <td>{{$participant->staff_FO_male}}</td>
            <td>{{$participant->staff_FO_female}}</td>
        </tr>
        @endforeach
     @endif
    </tbody>  
</table>
    </div>
</section>
@endsection