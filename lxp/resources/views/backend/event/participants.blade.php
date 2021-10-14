@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', 'Events Participants | '.app_name())

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
            <h3 class="page-title d-inline">Events Participants</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    {!! Form::label('event_id', 'Events', ['class' => 'control-label']) !!}
                    {!! Form::select('event_id', $events,  (request('event_id')) ? request('event_id') : old('event_id'), ['class' => 'form-control js-example-placeholder-single select2 ', 'id' => 'event_id']) !!}
                </div>
            </div>

            @if(request('event_id') != "")
                <div class="table-responsive">

                    <table id="myTable" class="table table-bordered table-striped dt-select">
                        <thead>
                        <tr>
                            <th></th>
                            <th style="text-align:center;"><input class="mass" type="checkbox" id="select-all"/></th>
                            <th>@lang('labels.general.sr_no')</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th> &nbsp;
                            <th>Sex</th> &nbsp;
                            <th>Contact Number</th> &nbsp;
                            <th>Position</th> &nbsp;
                            <th>Organization / Office</th> &nbsp;
                            <th>SWAD Office/ Section/ Program</th> &nbsp;
                            <th>Province</th> &nbsp;
                            <th>Municipality</th> &nbsp;
                            <th>Reason</th> &nbsp;
                            <th>Progress</th> &nbsp;
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

            //data += d.event_act;
            var obj = d.event_act;
            data += 
            '<tr>'+
                '<th>Activity Title</th>'+
                '<th>Date Conducted</th>'+
                '<th>Link</th>'+
                '<th>Attended</th>'+
            '</tr>';

            for (const [key, value] of Object.entries(obj)) {
                data += 
                '<tr>'+
                    '<td>' + value["title"] +'</td>'+
                    '<td>' + value["activity_date"] +'</td>'+
                    '<td>' + value["link"] +'</td>'+
                    '<td>' + value["attended"] +'</td>'+
                '</tr>';
            }

            data += '</table>';

            return data;
        }

        $(document).ready(function () {
            var route = '{{route('admin.event.get_participants')}}';

            @php
                $event_id = (request('event_id') != "") ? request('event_id') : 0;
                $route = route('admin.event.get_participants',['event_id' => $event_id]);
            @endphp

            route = '{{$route}}';
            route = route.replace(/&amp;/g, '&');


            @if(request('event_id') != "")

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
                    {
                        "data": function (data) {
                            return '<input type="checkbox" class="single" name="id[]" value="' + data.id + '" />';
                        }, "orderable": false, "searchable": false, "name": "id"
                    },
                    {
                        data: "DT_RowIndex", name: 'DT_RowIndex'
                    },
                    {data: "first_name", name: 'first_name'},
                    {data: "middle_name", name: "middle_name"},
                    {data: "last_name", name: "last_name"},
                    {data: "gender", name: "gender"},
                    {data: "phone", name: "phone"},
                    {data: "position", name: "position"},
                    {data: "office", name: "office"},
                    {data: "odsu", name: "odsu"},
                    {data: "prov", name: "province", "searchable": false},
                    {data: "mun", name: "municipality", "searchable": false},
                    {data: "reason", name: "reason"},
                    {data: "progress", name: "progress"}
                ],
                columnDefs: [
                    {"width": "5%", "targets": 0},
                    {"className": "text-center", "targets": [0]}
                ],

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

            $('.actions').html('<a href="' + '#' + '" class="btn btn-xs btn-danger js-delete-selected" style="margin-top:0.755em;margin-left: 20px;">Create Certificate of selected</a>');

            $(".js-example-placeholder-single").select2({
                placeholder: "Select Event",
            });
            $(document).on('change', '#event_id', function (e) {
                var event_id = $(this).val();
                window.location.href = "{{route('admin.eventparticipants')}}" + "?event_id=" + event_id
            });
        });

    </script>
@endpush