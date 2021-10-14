@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.edit'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        @lang('labels.backend.access.users.management')
                        <small class="text-muted">@lang('labels.backend.access.users.edit')</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->
            <hr>
        
        <div role="tabpanel">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a href="#edit" class="nav-link active" aria-controls="edit" role="tab" data-toggle="tab">Update Information</a>
                </li>
                <li class="nav-item">
                    <a href="#password" class="nav-link" aria-controls="password" role="tab" data-toggle="tab">Change Password</a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade show active pt-3" id="edit" aria-labelledby="edit-tab">
                    {{ html()->modelForm($user, 'PATCH', route('admin.auth.user.update', $user->id))->class('form-horizontal')->open() }}
                    <div class="row mt-4 mb-4">
                        <div class="col">
                            <div class="form-group row">
                                {{ html()->label('User Type')->class('col-md-2 form-control-label')->for('user_type') }}
                                <div class="col-md-10">
                                    <select class="form-control" name="user_type" id="user_type">
                                        <option value="">Select Type</option>
                                        <option value="internal" "@if($user->user_type == 'internal') selected @endif">Internal (DSWD Personnel)</option>
                                        <option value="external" "@if($user->user_type == 'external') selected @endif">External (Intermediaries)</option>
                                    </select>
                                </div>
                                <span id="user-type-error" class="text-danger"></span>
                            </div>
                            <div class="form-group row">
                                {{ html()->label('First Name')->class('col-md-2 form-control-label')->for('first_name') }}
                                <div class="col-md-10">
                                    {{ html()->text('first_name')->class('form-control')->placeholder('First Name')->attribute('maxlength', 191)->required() }}
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
                                {{ html()->label('E-mail Address')->class('col-md-2 form-control-label')->for('email') }}
                                <div class="col-md-10">
                                    {{ html()->email('email')->class('form-control')->placeholder('Email Address')->attributes(['maxlength'=> 191])->required() }}
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label('User Name')->class('col-md-2 form-control-label')->for('username') }}
                                <div class="col-md-10">
                                    {{ html()->text('username')->class('form-control')->placeholder('User Name')->attributes(['maxlength'=> 191])->required() }}
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label('Gender')->class('col-md-2 form-control-label')->for('gender') }}
                                <div class="col-md-10">
                                    <label class="radio-inline mr-3 mb-0">
                                        <input type="radio" name="gender" value="male" {{ $user->gender == 'male'?'checked':'' }}> {{__('validation.attributes.frontend.male')}}
                                    </label>
                                    <label class="radio-inline mr-3 mb-0">
                                        <input type="radio" name="gender" value="female" {{ $user->gender == 'female'?'checked':'' }}> {{__('validation.attributes.frontend.female')}}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ html()->label('Phone')->class('col-md-2 form-control-label')->for('phone') }}
                                <div class="col-md-10">
                                    {{ html()->text('phone')->class('form-control')->placeholder('Phone')->attribute('maxlength', 12)->required() }}
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label('Date of Birth')->class('col-md-2 form-control-label')->for('dob') }}
                                <div class="col-md-10">
                                    <input type="date" class="form-control mb-0" value="{{$user->dob}}" name="dob" placeholder="Date of Birth">
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label('Position')->class('col-md-2 form-control-label')->for('position') }}
                                <div class="col-md-10">
                                    {{ html()->text('position')->class('form-control')->placeholder('Position')->attribute('maxlength', 191)->required() }}
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label('Region')->class('col-md-2 form-control-label')->for('state') }}
                                <div class="col-md-10">
                                    {{ html()->text('state')->class('form-control')->placeholder('Region')->attribute('maxlength', 191)->required() }}
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label('Province')->class('col-md-2 form-control-label')->for('province') }}
                                <div class="col-md-10">
                                    {{ html()->text('province')->class('form-control')->placeholder('Province')->attribute('maxlength', 191)->required() }}
                                </div><!--col-->
                            </div><!--form-group-->
                            
                            <div class="form-group row">
                                {{ html()->label('Municipality')->class('col-md-2 form-control-label')->for('province') }}
                                <div class="col-md-10">
                                    {{ html()->text('city')->class('form-control')->placeholder('Municipality')->attribute('maxlength', 191)->required() }}
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label('Address')->class('col-md-2 form-control-label')->for('address') }}

                                <div class="col-md-10">
                                    <textarea class="form-control mb-0" name="address" placeholder="Address">{{$user->address}}</textarea>
                                </div><!--col-->
                            </div><!--form-group-->

                            <div class="form-group row">
                                {{ html()->label('Abilities')->class('col-md-2 form-control-label') }}

                                <div class="table-responsive col-md-10">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>@lang('labels.backend.access.users.table.roles')</th>
                                                
                                                @if ($logged_in_user->isSuperAdmin())
                                                    <th>@lang('labels.backend.access.users.table.permissions')</th>
                                                @endif

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    @if($roles->count())
                                                        @foreach($roles as $role)
                                                        @if ($role->name != 'superadmin')
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <div class="checkbox d-flex align-items-center">
                                                                        {{ html()->label(
                                                                                html()->checkbox('roles[]', in_array($role->name, $userRoles), $role->name)
                                                                                        ->class('switch-input')
                                                                                        ->id('role-'.$role->id)
                                                                                . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                                                            ->class('switch switch-label switch-pill switch-primary mr-2')
                                                                            ->for('role-'.$role->id) }}
                                                                        {{ html()->label(ucwords($role->name))->for('role-'.$role->id) }}
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    @if($role->id != 1)
                                                                        @if($role->permissions->count())
                                                                            @foreach($role->permissions as $permission)
                                                                                <i class="fas fa-dot-circle"></i> {{ ucwords($permission->name) }}
                                                                            @endforeach
                                                                        @else
                                                                            @lang('labels.general.none')
                                                                        @endif
                                                                    @else
                                                                        @lang('labels.backend.access.users.all_permissions')
                                                                    @endif
                                                                </div>
                                                            </div><!--card-->
                                                        @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                
                                                @if ($logged_in_user->isSuperAdmin())
                                                <td>
                                                    @if($permissions->count())
                                                        @foreach($permissions as $permission)
                                                            <div class="checkbox d-flex align-items-center">
                                                                {{ html()->label(
                                                                        html()->checkbox('permissions[]', in_array($permission->name, $userPermissions), $permission->name)
                                                                                ->class('switch-input')
                                                                                ->id('permission-'.$permission->id)
                                                                            . '<span class="switch-slider" data-checked="on" data-unchecked="off"></span>')
                                                                        ->class('switch switch-label switch-pill switch-primary mr-2')
                                                                    ->for('permission-'.$permission->id) }}
                                                                {{ html()->label(ucwords($permission->name))->for('permission-'.$permission->id) }}
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!--col-->
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->

                    <div class="row">
                        <div class="col">
                            {{ form_cancel(route('admin.auth.user.index'), 'Cancel') }}
                        </div><!--col-->

                        <div class="col text-right">
                            {{ form_submit('Update') }}
                        </div><!--row-->
                    </div><!--row-->
                
                    {{ html()->closeModelForm() }}
                </div><!--tab panel profile-->

                <div role="tabpanel" class="tab-pane fade show pt-3" id="password" aria-labelledby="password-tab">
                    {{ html()->form('PATCH', route('admin.account.post',$user->email))->class('form-horizontal')->open() }}
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.new_password'))->for('password') }}

                                    {{ html()->password('password')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.new_password'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    {{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}

                                    {{ html()->password('password_confirmation')
                                        ->class('form-control')
                                        ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-0 clearfix">
                                    {{ form_submit(__('labels.general.buttons.update') . ' ' . __('validation.attributes.frontend.password')) }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                    {{ html()->form()->close() }}
                </div><!--tab panel change password-->

            </div><!--tab content-->
        </div><!--tab panel-->
        </div><!--card-body-->

        <div class="card-footer">

        </div><!--card-footer-->
    </div><!--card-->
@endsection
