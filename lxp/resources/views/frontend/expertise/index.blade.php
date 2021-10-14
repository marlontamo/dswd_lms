@extends('frontend.layouts.app')
@push('after-styles')
    <style>
        .couse-pagination li.active {
            color: #333333!important;
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
            background-color:white;
            border:none;

        }
        ul.pagination{
            display: inline;
            text-align: center;
        }
    </style>
@endpush
@section('content')

	<!-- Start of breadcrumb section
		============================================= -->
		<section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
			<div class="blakish-overlay"></div>
			<div class="container">
				<div class="page-breadcrumb-content text-center">
					<div class="page-breadcrumb-title">
						<h2 class="breadcrumb-head black bold">{{env('APP_NAME')}} 
							<span> 
								@if($cattype == 0)
									Core Group of Specialist
								@else
									Social Welfare and Development Learning Network (SWDLNet)
								@endif
							</span>
						</h2>
					</div>
				</div>
			</div>
		</section>
	<!-- End of breadcrumb section
		============================================= -->



	<!-- Start of teacher section
		============================================= -->
		
		<section id="teacher-page" class="teacher-page-section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						@if(count($expertise) > 0)
						@foreach($expertise as $key => $exp)
						<h1>{{$key}}</h2>
						<div class="teachers-archive">
							<div class="row">
								@foreach($exp as $item)
								<div class="col-md-3 col-sm-3">
									<div class="teacher-pic-content">
										<div class="teacher-img-content relative-position">
											<img src="{{asset('storage/uploads/'. $item->image)}}" alt="">
											<div class="teacher-next text-center">
												<a href="{{route('expertise.show',['id'=>$item->exp_id])}}"><i class="text-gradiant fas fa-arrow-right"></i>
											</div>
											</a>
										</div>
										<div class="teacher-name-designation" style = "text-align: center;">
											@if($item->cat_slug != 'org')
												<span class="teacher-name">{{$item->first_name . ' ' . $item->middle_name. ' ' . $item->last_name}}</span>
												<span>{{$item->position}}</span><br>
												<span>{{$item->office}}</span><br>
											@else
												<span class="teacher-name">{{$item->office }}</span>
												<span>{{$item->email}}</span>
											@endif
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
						@endforeach
						@else
							<h4>No Data</h4>
						@endif
					</div>
					{{-- @include('frontend.layouts.partials.right-sidebar') --}}
				</div>
			</div>
		</section>
	<!-- End of teacher section
		============================================= -->
@endsection