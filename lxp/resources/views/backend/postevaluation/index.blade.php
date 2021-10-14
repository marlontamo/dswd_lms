@extends('backend.layouts.app')

@section('title', __('labels.backend.reports.students_report').' | '.app_name())

@section('content')

    <div id="sample" class="card">
        <div class="card-header">
            <!-- <h3 class="page-title d-inline">@lang('labels.backend.reports.students_report')</h3> -->
            <h3 class="page-title d-inline">Post Evaluation Surveys</h3>
            <div class="float-right">
                <a href="{{ route('admin.postevaluation.add_posteval') }}" class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <v-client-table :data="list_table.data.list" :columns="list_table.columns" :options="list_table.options" ref='idcc_list_table'>
                            <template slot="DT_RowIndex" slot-scope="e">
                                @{{e.index}}
                            </template>
                            <template slot="action" slot-scope="e">
                                <!-- <a href="{{ route('admin.event.create') }}" class="btn btn-xs btn-info mb-1"><i class="icon-eye"></i></a> -->
                                <a :href="'{{ route('admin.postevaluation.edit_posteval','') }}/'+e.row.pes_id" class="btn btn-xs btn-info mb-1"><i class="icon-pencil"></i></a>
                                <a :href="'{{ route('admin.postevaluation.remove_posteval','') }}/'+e.row.pes_id" class="btn btn-xs btn-danger mb-1"><i class="fa fa-trash"></i></a>
                            </template>
                        </v-client-table> 
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('after-scripts')
    <script>
    Vue.use(VueTables.ClientTable);
    var app = new Vue({
        el: '#sample',
        data: {
            list_table: {
                data: {
                    list: []
                },
                columns: [
                    "DT_RowIndex",
                    "title",
                    "description",
                    "action"
                ],
                options: {
                    uniqueKey:'pes_id',
                    headings: {
                        DT_RowIndex: 'Post evaluation Survey No.',
                    },
                    sortable: [
                        "DT_RowIndex",
                        "title",
                        "description",
                    ],
                },
            },
        },
        mounted(){
            this.getAllPostEvaluation();
        },
        methods: {
            getAllPostEvaluation() {
                var url = "{{route('admin.postevaluation.get_posteval_data')}}";
                axios.get(url)
                    .then(function (e) {
                        console.log(e)
                        app.list_table.data.list = e.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
        }
    })
</script>

@endpush