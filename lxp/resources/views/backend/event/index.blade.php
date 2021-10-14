@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', 'Events | '.app_name())

@section('content')


    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Events</h3>
            <div class="float-right">
                <a href="{{ route('admin.event.create') }}" class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-block">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="{{ route('admin.event.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                        </li>
                        |
                        <li class="list-inline-item">
                            <a href="{{ route('admin.event.index') }}?show_deleted=1"
                               style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>
                        </li>
                    </ul>
                </div>


                <table id="myTable" class="table table-bordered table-striped dt-select">
                    <thead>
                    <tr>
                        @if ( request('show_deleted') != 1 )
                            <th style="text-align:center;"><input type="checkbox" class="mass" id="select-all"/></th>
                        @endif

                        <th>Sr No</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Duration</th>
                        <th>Activities</th>
                        <th>Participants</th>
                        <th>Status</th>
                        <th>Action</th>
                        
                    </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@push('after-scripts')
    <script>

        $(document).ready(function () {
            var route = '{{route('admin.events.get_data')}}';

            @if(request('show_deleted') == 1)
                route = '{{route('admin.events.get_data',['show_deleted' => 1])}}';
            @elseif(request('cat_id') != "")
                route = '{{route('admin.events.get_data',['cat_id' => request('cat_id')])}}';
            @endif

            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4,5,6 ]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4,5,6 ]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                    @if(request('show_deleted') != 1)
                        { "data": function(data){
                            return '<input type="checkbox" class="single" name="id[]" value="'+ data.id +'" />';
                        }, "orderable": false, "searchable":false, "name":"id" },
                    @endif

                    {data: "DT_RowIndex", name: 'DT_RowIndex'},
                    {data: "title", name: 'title'},
                    {data: "type", name: 'type', "searchable": false},
                    {data: "duration", name: 'duration'},
                    {data: "activities", name: 'activities', "searchable": false},
                    {data: "participants", name: 'participants', "searchable": false},
                    {data: "status", name: "status"},
                    {data: "actions", name: "actions"}
                ],
                @if(request('show_deleted') != 1)
                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"className": "text-center", "targets": [0]}
                ],
                @endif

                createdRow: function (row, data, dataIndex) {
                    $(row).attr('data-entry-id', data.id);
                },
            });

            @if(request('show_deleted') != 1)
                $('.actions').html('<a href="' + '{{ route('admin.event.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
            @endif
        });

    </script>

@endpush