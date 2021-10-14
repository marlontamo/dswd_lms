@extends('backend.layouts.app')
@section('title', 'Events | '.app_name())

@section('content')

    {!! Form::model($postevaluationquestion, ['method' => 'POST', 'route' => ['admin.postevaluationquestion.update_postevalquestion', $postevaluationquestion->peq_id]]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left">Update Post Evaluation Questions</h3>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-12 col-lg-12 form-group">
                    {!! Form::label('question', trans('labels.backend.postevaluationquestion.fields.question').' *', ['class' => 'control-label']) !!}
                    {!! Form::text('question', old('question'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.postevaluationquestion.fields.question'), 'required' => true]) !!}
                </div>
                <div class="col-12 col-lg-12 form-group">
                    <label for="answer_type" class = "control-label">Answer Type</label>
                    <select class = "form-control" name="answer_type" id="answer_type" required>
                        <option value="1" @if($postevaluationquestion->answer_type == 1) selected  @endif > Rating </option>
                        <option value="2" @if($postevaluationquestion->answer_type == 2) selected  @endif > Text </option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-12 form-group">
                    <div class="checkbox d-inline mr-3">
                        {!! Form::hidden('sme', 0) !!}
                        {!! Form::checkbox('sme', 1, old('sme'), []) !!}
                        {!! Form::label('sme',  trans('labels.backend.postevaluationquestion.fields.sme'), ['class' => 'checkbox control-label font-weight-bold']) !!}
                    </div>
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