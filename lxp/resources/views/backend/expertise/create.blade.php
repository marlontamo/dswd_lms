@extends('backend.layouts.app')
@section('title', 'Expertise | '.app_name())

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
{!! Form::open(['method' => 'POST', 'route' => ['admin.expertise.store'], 'files' => true,]) !!}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Add New Expertise</h3>
            <div class="float-right">
                <a href="{{ route('admin.expertise.index') }}" class="btn btn-success">View List of Expertise</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('slug',trans('labels.backend.blogs.fields.slug'), ['class' => 'control-label']) !!}
                    {!! Form::text('slug', old('slug'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.lessons.slug_placeholder')]) !!}

                </div>
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('category', trans('labels.backend.blogs.fields.category'), ['class' => 'control-label']) !!}
                    {!! Form::select('category', $category, (request('category')) ? request('category') : old('category'), ['class' => 'form-control select2', 'required' => true]) !!}
                </div>
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('featured_image', 'Image (max file size 10 mb)', ['class' => 'control-label']) !!}
                    {!! Form::file('featured_image', ['class' => 'form-control' , 'accept' => 'image/jpeg,image/gif,image/png']) !!}
                    {!! Form::hidden('featured_image_max_size', 8) !!}
                    {!! Form::hidden('featured_image_max_width', 4000) !!}
                    {!! Form::hidden('featured_image_max_height', 4000) !!}

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('first_name', 'First Name', ['class' => 'control-label']) !!}
                    {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => 'First Name', ]) !!}
                </div>

                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('middle_name', 'Middle Name', ['class' => 'control-label']) !!}
                    {!! Form::text('middle_name', old('middle_name'), ['class' => 'form-control', 'placeholder' => 'Middle Name', ]) !!}
                </div>

                <div class="col-12 col-lg-4 form-group">
                    {!! Form::label('last_name', 'Last Name', ['class' => 'control-label']) !!}
                    {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => 'Last Name', ]) !!}
                </div>

            </div>
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email', ]) !!}
                </div>

                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('position', 'Position', ['class' => 'control-label']) !!}
                    {!! Form::text('position', old('position'), ['class' => 'form-control', 'placeholder' => 'Position', ]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-12 form-group">
                    {!! Form::label('office', 'Office / Organization Name', ['class' => 'control-label']) !!}
                    {!! Form::text('office', old('office'), ['class' => 'form-control', 'placeholder' => 'Office', ]) !!}
                </div>

            </div>

            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('content', trans('labels.backend.blogs.fields.content'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('content', old('content'), ['class' => 'form-control editor', 'placeholder' => '','id' => 'editor']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center form-group">
                    <button type="submit" class="btn btn-info waves-effect waves-light ">
                        Save
                    </button>
                    <button type="reset" class="btn btn-danger waves-effect waves-light ">
                        Cancel
                    </button>
                </div>

            </div>

        </div>
    </div>



@endsection

@push('after-scripts')
<script src="{{asset('plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script src="{{asset('/vendor/laravel-filemanager/js/lfm.js')}}"></script>
<script>
    $('.editor').each(function() {
        CKEDITOR.replace($(this).attr('id'), {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',

            extraPlugins: 'smiley,lineutils,widget,codesnippet,prism,colorbutton',
        });
    });
    var uploadField = $('input[type="file"]');

    $(document).on('change', 'input[type="file"]', function() {
        var $this = $(this);
        $(this.files).each(function(key, value) {
            if ((value.size / 1024) > 5000000) {
                alert('"' + value.name + '"' + 'exceeds limit of maximum file upload size')
                $this.val("");
            }
        })
    })
</script>
@endpush