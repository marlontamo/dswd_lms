@extends('backend.layouts.app')
@section('title', 'Expertise | '.app_name())

@push('after-styles')
    <style>
        .blog-detail-content p img{
            margin: 2px;
        }
        .label{
            margin-bottom: 5px;
            display: inline-block;
            border-radius: 0!important;
            font-size: 0.9em;
        }
    </style>
@endpush

@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">View Expertise</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>First_name</th>
                            <td>{{ $expertise->first_name }}</td>
                        </tr>
                        <tr>
                            <th>Middle Name</th>
                            <td>{{ $expertise->middle_name }}</td>
                        </tr>
                        <tr>
                            <th>Last Name</th>
                            <td>{{ $expertise->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td>@if($expertise->image)<a href="{{ asset('storage/uploads/' . $expertise->image) }}" target="_blank"><img src="{{ asset('storage/uploads/' . $expertise->image) }}" height="100px"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>Position</th>
                            <td>{{ $expertise->position }}</td>
                        </tr>
                        <tr>
                            <th>Office</th>
                            <td>{{ $expertise->office }}</td>
                        </tr>
                        <tr>
                            <th>Content)</th>
                            <td>{!! $expertise->content !!}</td>
                        </tr>
                        <tr>
                            <th>Created at</th>
                            <td>{{ $expertise->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            <!-- Tab panes -->
            <a href="{{ route('admin.expertise.index') }}" class="btn btn-default border">@lang('strings.backend.general.app_back_to_list')</a>

        </div>
    </div>

@endsection

@push('after-scripts')
@endpush