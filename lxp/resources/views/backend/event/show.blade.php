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
            <h3 class="page-title mb-0">Event Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Title</th>
                            <td>
                                @if($event->published == 1)
                                    <a target="_blank"
                                       href="{{ route('event.show', [$event->slug]) }}">{{ $event->title }}</a>
                                @else
                                    {{ $event->title }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Category)</th>
                            <td>{{ $event->category->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.slug')</th>
                            <td>{{ $event->slug }}</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.description')</th>
                            <td>{!! $event->description !!}</td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td>@if($event->event_image)<a
                                        href="{{ asset('storage/uploads/' . $event->event_image) }}"
                                        target="_blank"><img
                                            src="{{ asset('storage/uploads/' . $event->event_image) }}"
                                            height="50px"/></a>@endif</td>
                        </tr>
                        <tr>
                            <th>@lang('labels.backend.courses.fields.start_date')</th>
                            <td>{{ $event->start_date }}</td>
                        </tr>
                        
                        <tr>
                            <th>@lang('labels.backend.courses.fields.end_date')</th>
                            <td>{{ $event->end_date }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ Form::checkbox("published", 1, $event->published == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->

            <div class="row justify-content-center">
            @if(count($activities) > 0)
                <div class="col-lg-6 col-12  ">
                    <h4 class="">Event Programs/Activities</h4>
                    <ul class="sorter d-inline-block">
                        @foreach($activities as $key=>$item)
                        <li>
                            <span>
                                <p class="d-inline-block mb-0 btn btn-success">
                                    {{$item->session_date}}
                                </p>
                                <p class="title d-inline ml-2">{{$item->title}}</p>
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(count($participants) > 0)
                <div class="col-lg-6 col-12  ">
                    <h4 class="">Event Participants</h4>
                    <ul class="sorter d-inline-block">
                        @foreach($participants as $key=>$item)
                        <li>
                            <span>
                                <p class="title d-inline ml-2">{{$item->fullname}}</p>
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            </div>
            <div class = "row">
                <a href="{{ route('admin.event.index') }}"
                           class="btn btn-default border float-left">@lang('strings.backend.general.app_back_to_list')</a>
            </div>
        </div>
    </div>
@stop
