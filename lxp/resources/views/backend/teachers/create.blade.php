@extends('backend.layouts.app')

@section('title', 'SME' . ' | '.app_name())

@section('content')
    {{ html()->form('POST', route('admin.teachers.store'))->acceptsFiles()->class('form-horizontal')->open() }}
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">Create Subject Matter Expert / Instructional Designer</h3>
            <div class="float-right">
                <a href="{{ route('admin.teachers.index') }}"
                   class="btn btn-success">View SME/ID</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        {{ html()->label('First Name')->class('col-md-2 form-control-label')->for('first_name') }}
                        <div class="col-md-10">
                            {{ html()->text('first_name')->class('form-control')->placeholder('First Name')->attribute('maxlength', 191)->required()->autofocus() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Middle Name')->class('col-md-2 form-control-label')->for('middle_name') }}
                        <div class="col-md-10">
                            {{ html()->text('middle_name')->class('form-control')->placeholder('Middle Name')->attribute('maxlength', 191) }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Last Name')->class('col-md-2 form-control-label')->for('last_name') }}

                        <div class="col-md-10">
                            {{ html()->text('last_name')->class('form-control')->placeholder('Last Name')->attribute('maxlength', 191)->required() }}
                        </div><!--col-->
                    </div><!--form-group-->
                    
                    <div class="form-group row">
                        {{ html()->label('User Name')->class('col-md-2 form-control-label')->for('username') }}

                        <div class="col-md-10">
                            {{ html()->text('username')->class('form-control')->placeholder('User Name')->attribute('maxlength', 191)->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Email')->class('col-md-2 form-control-label')->for('email') }}

                        <div class="col-md-10">
                            {{ html()->email('email')->class('form-control')->placeholder('Email')->attribute('maxlength', 191)->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Password')->class('col-md-2 form-control-label')->for('password') }}

                        <div class="col-md-10">
                            {{ html()->password('password')->class('form-control')->placeholder('Password')->required() }}
                        </div><!--col-->
                    </div><!--form-group-->

                    <div class="form-group row">
                        {{ html()->label('Image')->class('col-md-2 form-control-label')->for('image') }}

                        <div class="col-md-10">
                            {!! Form::file('image', ['class' => 'form-control d-inline-block', 'placeholder' => '']) !!}
                        </div><!--col-->
                    </div>
                    <div class="form-group row">
                        {{ html()->label('Sex')->class('col-md-2 form-control-label')->for('gender') }}
                        <div class="col-md-10">
                            <label class="radio-inline mr-3 mb-0">
                                <input type="radio" name="gender" value="male"> Male
                            </label>
                            <label class="radio-inline mr-3 mb-0">
                                <input type="radio" name="gender" value="female"> Female
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ html()->label(__('labels.teacher.facebook_link'))->class('col-md-2 form-control-label')->for('facebook_link') }}

                        <div class="col-md-10">
                            {{ html()->text('facebook_link')
                                            ->class('form-control')
                                            ->placeholder(__('labels.teacher.facebook_link')) }}
                        </div><!--col-->
                    </div>

                    <div class="form-group row">
                        {{ html()->label(__('labels.teacher.twitter_link'))->class('col-md-2 form-control-label')->for('twitter_link') }}

                        <div class="col-md-10">
                            {{ html()->text('twitter_link')
                                            ->class('form-control')
                                            ->placeholder(__('labels.teacher.twitter_link')) }}

                        </div><!--col-->
                    </div>

                    <div class="form-group row">
                        {{ html()->label(__('labels.teacher.linkedin_link'))->class('col-md-2 form-control-label')->for('linkedin_link') }}

                        <div class="col-md-10">
                            {{ html()->text('linkedin_link')
                                            ->class('form-control')
                                            ->placeholder(__('labels.teacher.linkedin_link')) }}
                        </div><!--col-->
                    </div>

                    <div class="paypal_details">
                        <div class="form-group row">
                            {{ html()->label(__('labels.teacher.paypal_email'))->class('col-md-2 form-control-label')->for('paypal_email') }}
                            <div class="col-md-10">
                                {{ html()->text('paypal_email')
                                        ->class('form-control')
                                        ->placeholder(__('labels.teacher.paypal_email')) }}
                            </div><!--col-->
                        </div>
                    </div>

                    <div class="form-group row">
                        {{ html()->label(__('labels.teacher.description'))->class('col-md-2 form-control-label')->for('description') }}

                        <div class="col-md-10">
                            {{ html()->textarea('description')
                                            ->class('form-control')
                                            ->placeholder(__('labels.teacher.description')) }}
                        </div><!--col-->
                    </div>

                    <div class="form-group row">
                        {{ html()->label(__('labels.backend.teachers.fields.status'))->class('col-md-2 form-control-label')->for('active') }}
                        <div class="col-md-10">
                            {{ html()->label(html()->checkbox('')->name('active')
                                        ->checked(true)->class('switch-input')->value(1)

                                    . '<span class="switch-label"></span><span class="switch-handle"></span>')
                                ->class('switch switch-lg switch-3d switch-primary')
                            }}
                        </div>

                    </div>

                    <div class="form-group row justify-content-center">
                        <div class="col-4">
                            {{ form_cancel(route('admin.teachers.index'), __('buttons.general.cancel')) }}
                            {{ form_submit(__('buttons.general.crud.create')) }}
                        </div>
                    </div><!--col-->
                </div>
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}
@endsection
@push('after-scripts')
<script>
    // @if(old('payment_method') && old('payment_method') == 'bank')
    // $('.paypal_details').hide();
    // $('.bank_details').show();
    // @elseif(old('payment_method') && old('payment_method') == 'paypal')
    // $('.paypal_details').show();
    // $('.bank_details').hide();
    // @else
    // $('.paypal_details').hide();
    // @endif
    // $(document).on('change', '#payment_method', function(){
    //     if($(this).val() === 'bank'){
    //         $('.paypal_details').hide();
    //         $('.bank_details').show();
    //     }else{
    //         $('.paypal_details').show();
    //         $('.bank_details').hide();
    //     }
    // });
</script>
@endpush
