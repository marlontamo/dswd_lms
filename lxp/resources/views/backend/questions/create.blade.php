@extends('backend.layouts.app')
@section('title', __('labels.backend.questions.title').' | '.app_name())

@section('content')

    {!! Form::open(['method' => 'POST', 'route' => ['admin.questions.store'], 'files' => true, 'id'=>'fomEditQ']) !!}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Exercise|Quiz|Activity</h3>
            <div class="float-right">
                <a href="{{ route('admin.questions.index') }}"
                   class="btn btn-success">@lang('labels.backend.questions.view')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group">
                    <label for="tests" class = "control-label">Output</label>
                    {!! Form::select('tests[]', $tests, old('tests'), ['class' => 'form-control select2', 'multiple' => 'multiple','required' => 'required']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('tests'))
                        <p class="help-block">
                            {{ $errors->first('tests') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    <label for="act_type" class = "control-label">Exercise Type</label>
                    <select class = "form-control" name="act_type" id="act_type" required>
                        <option value="0"> Select Exercise Type</option>
                        <option value="1"> Multiple Choice</option>
                        <option value="2"> Essay / Activity Output</option>
                    </select>
                </div>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0" id = "type_name">Output</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('question', trans('labels.backend.questions.fields.question').'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('question', old('question'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('question'))
                        <p class="help-block">
                            {{ $errors->first('question') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('question_image', trans('labels.backend.questions.fields.question_image'), ['class' => 'control-label']) !!}
                    {!! Form::file('question_image', ['class' => 'form-control', 'style' => 'margin-top: 4px;']) !!}
                    {!! Form::hidden('question_image_max_size', 8) !!}
                    {!! Form::hidden('question_image_max_width', 4000) !!}
                    {!! Form::hidden('question_image_max_height', 4000) !!}
                    <p class="help-block"></p>
                    @if($errors->has('question_image'))
                        <p class="help-block">
                            {{ $errors->first('question_image') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    {!! Form::label('score', trans('labels.backend.questions.fields.score').'*', ['class' => 'control-label']) !!}
                    {!! Form::number('score', old('score', 1), ['class' => 'form-control', 'min'=>'1','max'=>'100', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('score'))
                        <p class="help-block">
                            {{ $errors->first('score') }}
                        </p>
                    @endif
                </div>
            </div>

            <div id="content"></div>
            
        </div>
    </div>

    <div class = "row">
        <div class="col-12 text-center">
            {!! Form::submit(trans('strings.backend.general.app_save'), ['id'=>'submit-exam','class' => 'btn btn-danger mb-4 form-group']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop


@push('after-scripts')
    <script>
        $(function () {
            $(document).ready(function () {
                $('#submit-exam').on('click',function(){
                    var type = document.getElementById("act_type").value;
                    if(type == 0){
                        alert("Please select Exercise Type");
                        return false;
                    }
                    if(type == 1){
                        var checked = $("input[type='checkbox']:checked").length > 0;
                        if (!checked){
                            alert("Please check at least one checkbox");
                            return false;
                        }
                    }
                });
                $(document).on("change","#act_type",function(){
                    if(this.value == '1'){
                        // $('#essay').removeClass('active').addClass('fade')
                        // $('#multiple_choice').addClass('active').removeClass('fade')

                        document.getElementById("type_name").innerHTML = "Multiple Choice";
                        document.getElementById("content").innerHTML = '@for ($question=1; $question<=4; $question++) <div class="card"> ' +
                        '    <div class="card-body"> ' +
                        '        <div class="row"> ' +
                        '            <div class="col-12 form-group"> ' +
                        '                {!! Form::label("option_text_" . $question, trans("labels.backend.questions.fields.option_text")."*", ["class" => "control-label"]) !!} ' +
                        '                {!! Form::textarea("option_text_" . $question ,  old("option_text"), ["class" => "form-control ", "rows" => 3]) !!} ' +
                        '                <p class="help-block"></p> ' +
                        '                @if($errors->has("option_text_" . $question)) ' +
                        '                    <p class="help-block"> ' +
                        '                        {{ $errors->first("option_text_" . $question) }} ' +
                        '                    </p> ' +
                        '                @endif ' +
                        '            </div> ' +
                        '        </div> ' +
                        '        <div class="row"> ' +
                        '            <div class="col-12 form-group"> ' +
                        '                {!! Form::label("explanation_" . $question, trans("labels.backend.questions.fields.option_explanation"), ["class" => "control-label"]) !!} ' +
                        '                {!! Form::textarea("explanation_" . $question, old("explanation_".$question), ["class" => "form-control ", "rows" => 3]) !!} ' +
                        '                <p class="help-block"></p> ' +
                        '                @if($errors->has("explanation_" . $question)) ' +
                        '                    <p class="help-block"> ' +
                        '                        {{ $errors->first("explanation_" . $question) }} ' +
                        '                    </p> ' +
                        '                @endif ' +
                        '            </div> ' +
                        '        </div> ' +
                        '        <div class="row"> ' +
                        '            <div class="col-12 form-group"> ' +
                        '                {!! Form::label("correct_" . $question, trans("labels.backend.questions.fields.correct"), ["class" => "control-label"]) !!} ' +
                        '                {!! Form::hidden("correct_" . $question, 0) !!} ' +
                        '                {!! Form::checkbox("correct_" . $question, 1, false, []) !!} ' +
                        '                <p class="help-block"></p> ' +
                        '                @if($errors->has("correct_" . $question)) ' +
                        '                    <p class="help-block"> ' +
                        '                        {{ $errors->first("correct_" . $question) }} ' +
                        '                    </p> ' +
                        '                @endif ' +
                        '            </div> ' +
                        '        </div> ' +
                        '    </div> ' +
                        '</div> @endfor';

                    }else{
                        // $('#multiple_choice').removeClass('active').addClass('fade')
                        // $('#essay').addClass('active').removeClass('fade')
                        
                        document.getElementById("type_name").innerHTML = "Essay / Activity Output";
                        document.getElementById("content").innerHTML = '<div class="card"> ' +
                        '    <div class="card-body"> ' +
                        '        <div class="row"> ' +
                        '            <div class="col-12 form-group"> ' +
                        '                {!! Form::label("explanation_1", "Answer Explanation", ["class" => "control-label"]) !!} ' +
                        '                {!! Form::textarea("explanation_1", old("explanation_".$question), ["class" => "form-control ", "rows" => 3]) !!} ' +
                        '                <p class="help-block"></p> ' +
                        '                @if($errors->has("explanation_1")) ' +
                        '                    <p class="help-block"> ' +
                        '                        {{ $errors->first("explanation_1") }} ' +
                        '                    </p> ' +
                        '                @endif ' +
                        '            </div> ' +
                        '        </div> ' +
                        '    </div> ' +
                        '</div>';
                    }
                    
                });
            });
        });
    </script>
@endpush

