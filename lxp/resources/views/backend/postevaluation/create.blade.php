@extends('backend.layouts.app')
@section('title', 'Events | '.app_name())

@section('content')

    {!! Form::open(['method' => 'POST', 'route' => ['admin.postevaluation.store_posteval']]) !!}

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left">Create Post Evaluation Survey</h3>
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
                    {!! Form::select('peq_id[]', $questions, old('peq_id'), ['class' => 'form-control select2 js-example-placeholder-single', 'multiple' => true, 'required' => true]) !!}
                </div>
            </div>
            <div class="row">

                <div class="col-12 form-group">
                    {!! Form::label('description',  trans('labels.backend.postevaluation.fields.description'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control ', 'placeholder' => trans('labels.backend.courses.fields.description')]) !!}

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
