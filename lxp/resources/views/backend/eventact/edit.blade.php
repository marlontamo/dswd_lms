@extends('backend.layouts.app')
@section('title', 'Events Activity | '.app_name())

@push('after-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
    <style>
        .select2-container--default .select2-selection--single {
            height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
        }

        .bootstrap-tagsinput {
            width: 100% !important;
            display: inline-block;
        }

        .bootstrap-tagsinput .tag {
            line-height: 1;
            margin-right: 2px;
            background-color: #2f353a;
            color: white;
            padding: 3px;
            border-radius: 3px;
        }

    </style>

@endpush
@section('content')
    {!! Form::model($eventact, ['method' => 'PUT', 'route' => ['admin.eventacts.update', $eventact->id], 'files' => true,]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Create Event Activity </h3>
            <div class="float-right">
                <a href="{{ route('admin.eventacts.index') }}"
                   class="btn btn-success">View Event Activities</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('event_id', 'Events', ['class' => 'control-label']) !!}
                    {!! Form::select('event_id', $events,  (request('event_id')) ? request('event_id') : old('event_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('pes_id', 'Post Evaluation Survey', ['class' => 'control-label']) !!}
                    {!! Form::select('pes_id', $postevaluations,  (request('pes_id')) ? request('pes_id') : old('pes_id'), ['class' => 'form-control select2', 'required' => true]) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('title', 'Title *', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.lessons.fields.title'), 'required' => '']) !!}
                </div>
                <div class="col-4 col-lg-4 form-group">
                    {!! Form::label('act_posters', 'Image', ['class' => 'control-label','accept' => 'image/jpeg,image/gif,image/png']) !!}
                    {!! Form::file('act_posters[]', ['multiple','class' => 'form-control']) !!}
                    @if ($eventact->act_posters)
                    
                    @foreach(json_decode($eventact->act_posters) as $key=> $eventimage)
                        <a href="{{ asset('storage/uploads/'.$eventimage) }}" target="_blank"><img
                                    height="50px" src="{{ asset('storage/uploads/'.$eventimage) }}"
                                    class="mt-1"></a>
                    @endforeach 

                    @endif
                </div>
                <div class="col-12 col-lg-2 form-group">
                    {!! Form::label('sequence', 'Sequence', ['class' => 'control-label']) !!}
                    {!! Form::number('sequence', old('sequence'), ['class' => 'form-control', 'placeholder' => 'Sequence', 'required' => '']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-lg-6 form-group">
                    {!! Form::label('link', 'Link of Activity', ['class' => 'control-label']) !!}
                    {!! Form::text('link', old('link'), ['class' => 'form-control', 'placeholder' => 'Google Meet link / Zoom link']) !!}
                </div>
                <div class="col-6 col-lg-6 form-group">
                    {!! Form::label('activity_date', 'Date of Activity (yyyy-mm-dd)', ['class' => 'control-label']) !!}
                    {!! Form::text('activity_date', old('activity_date'), ['class' => 'form-control date', 'pattern' => '(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))', 'placeholder' => 'Activity Date (Ex . 2019-01-01)', 'autocomplete' => 'off', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('activity_date'))
                        <p class="help-block">
                            {{ $errors->first('activity_date') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('full_text', trans('labels.backend.lessons.fields.full_text'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('full_text', old('full_text'), ['class' => 'form-control editor', 'placeholder' => '','id' => 'editor']) !!}
                </div>
            </div>

            
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('downloadable_files', trans('labels.backend.lessons.fields.downloadable_files').' '.trans('labels.backend.lessons.max_file_size'), ['class' => 'control-label']) !!}
                    {!! Form::file('downloadable_files[]', [
                        'multiple',
                        'class' => 'form-control file-upload',
                         'id' => 'downloadable_files',
                        'accept' => "image/jpeg,image/gif,image/png,application/msword,audio/mpeg,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-powerpoint,application/pdf,video/mp4"
                        ]) !!}
                    <div class="photo-block mt-3">
                        <div class="files-list">
                            @if(count($eventact->downloadableMedia) > 0)
                                @foreach($eventact->downloadableMedia as $media)
                                    <p class="form-group">
                                        <a href="{{ asset('storage/uploads/'.$media->name) }}"
                                           target="_blank">{{ $media->name }}
                                            ({{ $media->size }} KB)</a>
                                        <a href="#" data-media-id="{{$media->id}}"
                                           class="btn btn-xs btn-danger delete remove-file">@lang('labels.backend.lessons.remove')</a>
                                    </p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if(!empty($eventact->smes))
            @foreach($eventact->smes as $key_sme => $value_sme)
            <div class="sme_div">
                
                    
                    @if($key_sme == 0)
                    <div class="row">
                        <div class="col-11 form-group">
                            <label>SME</label>
                            <input type="text" name="smes[]" value="{{$value_sme}}" class="form-control">
                        </div>
                        <div class="col-1 form-group">
                            <label>&nbsp;</label>
                            <button class="btn btn-block btn-primary add_sme" type="button"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    @else
                    <div class="row cloned_sme">
                        <div class="col-11 form-group">
                            <input type="text" name="smes[]" value="{{$value_sme}}" class="form-control">
                        </div>
                        <div class="col-1 form-group">
                            <button class="btn btn-block btn-danger remove_sme" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                    @endif

            </div>
            @endforeach
            @else
            <div class="sme_div">
                <div class="row">
                    <div class="col-11 form-group">
                        <label>SME</label>
                        <input type="text" name="smes[]" class="form-control">
                    </div>
                    <div class="col-1 form-group">
                        <label>&nbsp;</label>
                        <button class="btn btn-block btn-primary add_sme" type="button"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">

                <div class="col-12 col-lg-3 form-group">
                    <div class="checkbox d-inline mr-4">
                        {!! Form::hidden('published', 0) !!}
                        {!! Form::checkbox('published', 1, old('published'), []) !!}
                        {!! Form::label('published', 'Active', ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>
                </div>
                <div class="col-12  text-left form-group">
                    {!! Form::submit(trans('strings.backend.general.app_save'), ['class' => 'btn  btn-danger btn-block']) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@push('after-scripts')
    <script src="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>

    <script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    <script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
    <script src="{{asset('/vendor/laravel-filemanager/js/lfm.js')}}"></script>
    <script>
        $('.editor').each(function () {

            CKEDITOR.replace($(this).attr('id'), {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',

                extraPlugins: 'smiley,lineutils,widget,codesnippet,prism',
            });

        });
        $(document).ready(function () {
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                var parent = $(this).parent('.form-group');
                var confirmation = confirm('{{trans('strings.backend.general.are_you_sure')}}')
                if (confirmation) {
                    var media_id = $(this).data('media-id');
                    $.post('{{route('admin.media.destroy')}}', {media_id: media_id, _token: '{{csrf_token()}}'},
                        function (data, status) {
                            if (data.success) {
                                parent.remove();
                            } else {
                                alert('Something Went Wrong')
                            }
                        });
                }
            })

            
            $('#activity_date').datepicker({
                autoclose: true,
                dateFormat: "{{ config('app.date_format_js') }}"
            });
        });

        var uploadField = $('input[type="file"]');


        $(document).on('change', 'input[name="act_posters"]', function () {
            var $this = $(this);
            $(this.files).each(function (key, value) {
                if ((value.size / 1024) > 5000000) {
                    alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                    $this.val("");
                }
            })
        });

        $(document).on('click', '.add_sme', function () {
            let html = "";
            html += '<div class="row  cloned_sme">';
            html += '    <div class="col-11 form-group">';
            html += '        <input type="text" name="smes[]" class="form-control">';
            html += '    </div>';
            html += '    <div class="col-1 form-group">';
            html += '        <button class="btn btn-block btn-danger remove_sme" type="button"><i class="fa fa-trash"></i></button>';
            html += '    </div>';
            html += '</div>';

            $(".sme_div").append(html);

        });

        $(document).on('click', '.remove_sme', function () {
            
            let index = $(this).parent().parent('.cloned_sme').index();
            console.log(index);

            $('.cloned_sme').eq(index-1).remove();
        });

    </script>
@endpush