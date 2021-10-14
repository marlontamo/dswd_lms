@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', 'Events Activities | '.app_name())

@push('after-styles')
    <style>
       td.details-control {
        background: url('/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('/images/details_close.png') no-repeat center center;
    }
    </style>
@endpush

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">Event Activities</h3>
            <div class="float-right">
                <a href="{{ route('admin.eventacts.create') }}@if(request('event_id')){{'?event_id='.request('event_id')}}@endif"
                    class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('event_id', 'Events', ['class' => 'control-label']) !!}
                    {!! Form::select('event_id', $events,  (request('event_id')) ? request('event_id') : old('event_id'), ['class' => 'form-control js-example-placeholder-single select2 ', 'id' => 'event_id']) !!}
                </div>
            </div>
            <div class="d-block">
                <ul class="list-inline">
                    <li class="list-inline-item">
                        <a href="{{ route('admin.eventacts.index',['event_id'=>request('event_id')]) }}"
                           style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">{{trans('labels.general.all')}}</a>
                    </li>
                    |
                    <li class="list-inline-item">
                        <a href="{{trashUrl(request()) }}"
                           style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">{{trans('labels.general.trash')}}</a>
                    </li>
                </ul>
            </div>

            @if(request('event_id') != "" || request('show_deleted') != "")
                <div class="table-responsive">

                    <table id="myTable" class="table table-bordered table-striped dt-select">
                        <thead>
                        <tr>
                            <th></th>
                            @if ( request('show_deleted') != 1 )
                                <th style="text-align:center;"><input class="mass" type="checkbox" id="select-all"/>
                                </th>
                            @endif
                            <th>@lang('labels.general.sr_no')</th>
                            <th>Title</th>
                            <th>Activity Date</th>
                            <th>Action &nbsp;
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            @endif

        </div>
    </div>

@stop

@push('after-scripts')
    <script>

        function format ( d ) {
            // `d` is the original data object for the row
            var data = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';

            data += '<tr>'+
                '<th>First Name</th>'+
                '<th>Middle Name</th>'+
                '<th>Last Name</th>'+
                '<th>Position</th>'+
                '<th>Province</th>'+
                '<th>Municipality</th>'+
            '</tr>';
            
            var attendance = JSON.parse(d.eventactUsers);
            var prov = d.provinces;
            var mun = d.municipality;

            for (const [key, value] of Object.entries(attendance)) {
                var mun_code = value["city"];
                var prov_code = value["province"];

                data += 
                '<tr>'+
                    '<td>' + value["first_name"]    +'</td>'+
                    '<td>' + value["middle_name"]   +'</td>'+
                    '<td>' + value["last_name"]     +'</td>'+
                    '<td>' + value["position"]      +'</td>'+
                    '<td>' + prov[prov_code]        +'</td>'+
                    '<td>' + mun[mun_code]          +'</td>'+
                '</tr>';
            }

            data += '</table>';

            return data;
        }

        $(document).ready(function () {
            var route = '{{route('admin.eventacts.get_data')}}';

            @php
                $show_deleted = (request('show_deleted') == 1) ? 1 : 0;
                $event_id = (request('event_id') != "") ? request('event_id') : 0;
                $route = route('admin.eventacts.get_data',['show_deleted' => $show_deleted,'event_id' => $event_id]);
            @endphp

            route = '{{$route}}';
            route = route.replace(/&amp;/g, '&');


            @if(request('event_id') != "" || request('show_deleted') != "")

            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                iDisplayLength: 10,
                retrieve: true,
                dom: 'lfBrtip<"actions">',
                buttons: [
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4]
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4]
                        }
                    },
                    'colvis'
                ],
                ajax: route,
                columns: [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    @if(request('show_deleted') != 1)
                    {
                        "data": function (data) {
                            return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" />';
                        }, "orderable": false, "searchable": false, "name": "id"
                    },
                    @endif
                    {
                        data: "DT_RowIndex", name: 'DT_RowIndex'
                    },
                    {data: "title", name: 'title'},
                    {data: "activity_date", name: "activity_date"},
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

            // Add event listener for opening and closing details
            $('#myTable tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
        
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );
            @endif

            @if(request('show_deleted') != 1)
                $('.actions').html('<a href="' + '{{ route('admin.eventacts.mass_destroy') }}' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Delete selected</a>');
            @endif


            $(".js-example-placeholder-single").select2({
                placeholder: "Select Events",
            });
            $(document).on('change', '#event_id', function (e) {
                var event_id = $(this).val();
                window.location.href = "{{route('admin.eventacts.index')}}" + "?event_id=" + event_id
            });
        });

    </script>
@endpush