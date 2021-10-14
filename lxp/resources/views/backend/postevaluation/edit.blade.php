@extends('backend.layouts.app')
@section('title', 'Events | '.app_name())

@section('content')

    {!! Form::model($postevaluation, ['method' => 'POST', 'route' => ['admin.postevaluation.update_posteval', $postevaluation->pes_id]]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left">Update Post Evaluation Survey</h3>
            <div class="float-right">
                <a href="{{ route('admin.post-evaluation-questions') }}"
                   class="btn btn-success">View Post Evaluation Questions</a>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-12 col-lg-12 form-group">
                    {!! Form::label('title', trans('labels.backend.postevaluation.fields.title').' *', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.postevaluation.fields.title'), 'required' => true]) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-12 form-group">
                    {!! Form::label('peq_id',trans('labels.backend.postevaluation.fields.questions'), ['class' => 'control-label']) !!}
                    {!! Form::select('peq_id[]', $questions, $peq_ids, ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => true, 'required' => true]) !!}
                </div>
            </div>

            <div class="row">

                <div class="col-12 form-group">
                    {!! Form::label('description',  trans('labels.backend.courses.fields.description'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => trans('labels.backend.courses.fields.description')]) !!}

                </div>
            </div>

            <div class="row">
                <div class="col-12  text-center form-group">
                    {!! Form::submit('Update', ['class' => 'btn btn-lg btn-danger btn-block']) !!}
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