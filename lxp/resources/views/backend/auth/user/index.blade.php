@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-7">
                    <h4 class="card-title mb-0">
                        {{ __('labels.backend.access.users.management') }}
                        <small class="text-muted">{{ __('labels.backend.access.users.active') }}</small>
                    </h4>
                </div><!--col-->
                <div class="col-sm-5">
                    @include('backend.auth.user.includes.header-buttons')
                </div><!--col-->
            </div><!--row-->
            <hr>

            <div class = "row">
                <div class="col-sm-12">
                    <h4 class="card-title mb-0"> FILTER </h4>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="roles" > Roles: </label>
                        <select name="roles" id="roles" class="form-control">
                            <option value="">{{ __('labels.backend.access.users.select_role') }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div><!--col-->

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="user_type: " > User Type: </label>
                        <select name="user_type" id="user_type" class="form-control">
                            <option value="">Select User Type</option>
                            <option value="internal">Internal</option>
                            <option value="external">External</option>
                        </select>
                    </div>
                </div><!--col-->

                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="gender" > Sex: </label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="">Select User Type</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div><!--col-->
            </div><!--row-->

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="province" > Province: </label>
                        <select name="province" id="province" class="form-control">
                            <option value="">Select Province</option>
                            @foreach($provinces as $provkey => $provvalue)
                                <option value="{{ $provkey }}">{{ $provvalue }}</option>
                            @endforeach
                        </select>
                    </div>
                </div><!--col-->
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="city" > Municipality: </label>
                        <select name="city" id="city" class="form-control">
                            <option value="">Select Municipality</option>
                        </select>
                    </div>
                </div><!--col-->
            </div><!--row-->

            <hr>
            <div class="row mt-4">
                <div class="col">

                    <div class="table-responsive">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <!-- <th>Full Name</th> -->
                                <th>Email Address</th>
                                <th>Username</th>
                                <th>Province</th>
                                <th>Municipality</th>
                                <!-- <th>Address</th> -->
                                <th>User Type</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>Confirmed</th>
                                <th>Roles</th>
                                <!-- <th>@lang('labels.backend.access.users.table.other_permissions')</th> -->
                                <!-- <th>@lang('labels.backend.access.users.table.social')</th> -->
                                <!-- <th>Last Updated</th> -->
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div><!--col-->
            </div><!--row-->

        </div><!--card-body-->
    </div><!--card-->
@endsection


@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.auth.user.getData')}}';

            var myTable = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 11,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                        }
                    },
                    'colvis'
                ],
                ajax: {
                    url: route,
                    data: function (d) {
                        d.role = $('#roles').val();
                        d.user_type = $('#user_type').val();
                        d.gender = $('#gender').val();
                        d.province = $('#province').val();
                        d.city = $('#city').val();
                    }
                },
                columns: [
                    {data: "DT_RowIndex", name: 'DT_RowIndex', "orderable": false, "searchable": false},
                    {data: "first_name", name: 'first_name'},
                    {data: "middle_name", name: 'middle_name'},
                    {data: "last_name", name: 'last_name'},
                    // {data: "full_name", name: "first_name,middle_name,last_name"},
                    {data: "email", name: "email"},
                    {data: "username", name: "username"},
                    {data: "province", name: "province"},
                    {data: "municipality", name: "municipality"},
                    // {data: "address", name: "address"},
                    {data: "user_type", name: "user_type"},
                    {data: "gender", name: "gender"},
                    {data: "status_label", name: "active", "searchable": false},
                    {data: "confirmed_label", name: "confirmed_label"},
                    {data: "roles_label", name: "roles.name"},
                    // {data: "permissions_label", name: "permissions.name"},
                    // {data: "social_buttons", name: "social_accounts.provider", "searchable": false},
                    // {data: "last_updated", name: "last_updated"},
                    {data: "actions", name: "actions", "searchable": false}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                }
            });


            $(document).on('change', '#roles', function (e) {
                myTable.draw();
                e.preventDefault();
            });            
            $(document).on('change', '#user_type', function (e) {
                myTable.draw();
                e.preventDefault();
            });        
            $(document).on('change', '#gender', function (e) {
                myTable.draw();
                e.preventDefault();
            });
            $(document).on('change', '#province', function (e) {
                myTable.draw();
                e.preventDefault();
            });
            $(document).on('change', '#city', function (e) {
                myTable.draw();
                e.preventDefault();
            });

            
            $(document).on("change","#province",function(){
                let prov_code = $(this).val();
                let prov_data = {'prov_code':prov_code};
                let municipalities = "<option value=''>Select Municipality</option>";
                // let barangay = "<option value=''>Select Barangay</option>";

                if(prov_code != ""){
                    $.ajax({
                        type: "GET",
                        url: "{{route('get.municipalities')}}",
                        data: prov_data,
                        dataType: "json",
                        success: function (response) {
                            if(response.success)
                            {
                                $.each(response.data,function(i,v){
                                    municipalities += "<option value='"+v.city_code+"''>"+v.city_name+"</option>";
                                });

                                $("#city").html(municipalities);
                                // $("#barangay").html(barangay);
                            }
                        },
                    });
                }else{
                    $("#city").html(municipalities);
                }
            });
        });

    </script>

@endpush
