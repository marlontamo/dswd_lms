@extends('backend.layouts.app')
@section('title', 'Events | '.app_name())

@section('content')

    {!! Form::open(['method' => 'POST', 'route' => ['admin.postevaluationquestion.store_postevalquestion']]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left">Create Post Evaluation Question</h3>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-12 col-lg-12 form-group">
                    {!! Form::label('question', trans('labels.backend.postevaluationquestion.fields.question').' *', ['class' => 'control-label font-weight-bold']) !!}
                    {!! Form::text('question', old('question'), ['class' => 'form-control', 'placeholder' => trans('labels.backend.postevaluationquestion.fields.question'), 'required' => true]) !!}
                </div>
                <div class="col-12 col-lg-12 form-group">
                    <label for="answer_type" class = "control-label">Answer Type</label>
                    <select class = "form-control" name="answer_type" id="answer_type" required>
                        <option value="1"> Rating </option>
                        <option value="2"> Text </option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-12 form-group">
                    <div class="checkbox d-inline mr-3">
                        {!! Form::hidden('sme', 0) !!}
                        {!! Form::checkbox('sme', 1, false, []) !!}
                        {!! Form::label('sme',  trans('labels.backend.postevaluationquestion.fields.sme'), ['class' => 'checkbox control-label font-weight-bold']) !!}
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
