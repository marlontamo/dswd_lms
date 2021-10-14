@extends('backend.layouts.app')
@section('title', 'Events | '.app_name())

@section('content')

    {!! Form::model($event, ['method' => 'PUT', 'route' => ['admin.event.update', $event->id], 'files' => true,]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left">Create Event</h3>
            <div class="float-right">
                <a href="{{ route('admin.event.index') }}"
                   class="btn btn-success">View Event</a>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-12 col-lg-12 form-group">
                    {!! Form::label('title', 'Event Title *', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => 'Event Title', 'required' => false]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-12 form-group">
                    {!! Form::label('category_id',trans('labels.backend.courses.fields.category'), ['class' => 'control-label']) !!}
                    {!! Form::select('category_id', $categories, old('category_id'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => false, 'required' => true]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-lg-4 form-group">
                    {!! Form::label('event_image', 'Image', ['class' => 'control-label','accept' => 'image/jpeg,image/gif,image/png']) !!}
                    {!! Form::file('event_image', ['class' => 'form-control']) !!}
                    {!! Form::hidden('event_image_max_size', 8) !!}
                    {!! Form::hidden('event_image_max_width', 4000) !!}
                    {!! Form::hidden('event_image_max_height', 4000) !!}
                    @if ($event->event_image)
                        <a href="{{ asset('storage/uploads/'.$event->event_image) }}" target="_blank"><img
                                    height="50px" src="{{ asset('storage/uploads/'.$event->event_image) }}"
                                    class="mt-1"></a>
                    @endif
                </div>
                <div class="col-6 col-lg-4 form-group">
                    {!! Form::label('start_date', trans('labels.backend.courses.fields.start_date').' (yyyy-mm-dd)', ['class' => 'control-label']) !!}
                    {!! Form::text('start_date', old('start_date'), ['class' => 'form-control date', 'pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.courses.fields.start_date').' (Ex . 2019-01-01)']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('start_date'))
                        <p class="help-block">
                            {{ $errors->first('start_date') }}
                        </p>
                    @endif
                </div>                
                <div class="col-6 col-lg-4 form-group">
                    {!! Form::label('end_date', trans('labels.backend.courses.fields.end_date').' (yyyy-mm-dd)', ['class' => 'control-label']) !!}
                    {!! Form::text('end_date', old('end_date'), ['class' => 'form-control date', 'pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => trans('labels.backend.courses.fields.end_date').' (Ex . 2019-01-01)']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('end_date'))
                        <p class="help-block">
                            {{ $errors->first('end_date') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-12 form-group">
                    {!! Form::label('event_poster', 'Event Posters', ['class' => 'control-label','accept' => 'image/jpeg,image/gif,image/png']) !!}
                    {!! Form::file('event_poster[]', ['multiple','class' => 'form-control']) !!}
                    @if ($event->event_poster)
                        @foreach(json_decode($event->event_poster) as $key=> $eventimage)
                            <a href="{{ asset('storage/uploads/'.$eventimage) }}" target="_blank"><img
                                        height="50px" src="{{ asset('storage/uploads/'.$eventimage) }}"
                                        class="mt-1"></a>
                        @endforeach 
                    @endif
                </div>
            </div>
            <div class="row">

                <div class="col-12 form-group">
                    {!! Form::label('description',  trans('labels.backend.courses.fields.description'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => trans('labels.backend.courses.fields.description')]) !!}

                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    <div class="checkbox d-inline mr-4">
                        {!! Form::hidden('published', 0) !!}
                        {!! Form::checkbox('published', 1, old('published'), []) !!}
                        {!! Form::label('published', 'Active', ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12  text-center form-group">
                    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn btn-lg btn-danger btn-block']) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            $('#start_date').datepicker({
                autoclose: true,
                dateFormat: "{{ config('app.date_format_js') }}"
            });

            $('#end_date').datepicker({
                autoclose: true,
                dateFormat: "{{ config('app.date_format_js') }}"
            });
        });

        var uploadField = $('input[type="file"]');

        $(document).on('change', 'input[type="file"]', function () {
            var $this = $(this);
            $(this.files).each(function (key, value) {
                if ((value.size / 1024) > 5000000) {
                    alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                    $this.val("");
                }
            })
        })


        $(document).on('change', '#media_type', function () {
            if ($(this).val()) {
                if ($(this).val() != 'upload') {
                    $('#video').removeClass('d-none').attr('required', true)
                    $('#video_file').addClass('d-none').attr('required', false)
                } else if ($(this).val() == 'upload') {
                    $('#video').addClass('d-none').attr('required', false)
                    $('#video_file').removeClass('d-none').attr('required', true)
                }
            } else {
                $('#video_file').addClass('d-none').attr('required', false)
                $('#video').addClass('d-none').attr('required', false)
            }
        })


    </script>

@endpush