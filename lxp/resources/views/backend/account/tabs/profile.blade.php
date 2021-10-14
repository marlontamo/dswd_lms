<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <tr>
            <th>Avatar</th>
            <td><img src="{{ $user->picture }}" height="100px" class="user-profile-image" /></td>
        </tr>
        <tr>
            <th>Full Name</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>E-mail Address</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>User Name</th>
            <td>{{ $user->username }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{!! $logged_in_user->status_label !!}</td>
        </tr>
        <tr>
            <th>Gender</th>
            <td>{!! $logged_in_user->gender !!}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ timezone()->convertToLocal($user->created_at) }} ({{ $user->created_at->diffForHumans() }})</td>
        </tr>
        <tr>
            <th>Last Updated</th>
            <td>{{ timezone()->convertToLocal($user->updated_at) }} ({{ $user->updated_at->diffForHumans() }})</td>
        </tr>
        @if(config('registration_fields') != NULL)
            @php
                $fields = json_decode(config('registration_fields'));
            @endphp
            @foreach($fields as $item)
                <tr>
                    <th>{{__('labels.backend.general_settings.user_registration_settings.fields.'.$item->name)}}</th>
                    <td>{{$user[$item->name]}}</td>
                </tr>
            @endforeach
        @endif
    </table>
</div>
