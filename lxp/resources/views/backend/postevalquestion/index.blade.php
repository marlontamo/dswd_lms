@extends('backend.layouts.app')

@section('title', __('labels.backend.reports.students_report').' | '.app_name())

@section('content')

    <div id="sample" class="card">
        <div class="card-header">
            <!-- <h3 class="page-title d-inline">@lang('labels.backend.reports.students_report')</h3> -->
            <h3 class="page-title d-inline">Post Evaluation Questions</h3>
            <div class="float-right">
                <a href="{{ route('admin.postevaluationquestion.add_postevalquestion') }}" class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>
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
                            <template slot="answer_type" slot-scope="e">
                                <div v-if="e.row.answer_type == 1">
                                    Ratings (Poor to Very Satisfactory)
                                </div>                                
                                <div v-if="e.row.answer_type == 2">
                                    Text
                                </div>
                            </template>                            
                            <template slot="sme" slot-scope="e">
                                <div v-if="e.row.sme == 0">
                                    General Evaluation of the Activity
                                </div>                                
                                <div v-if="e.row.sme == 1">
                                    Subject Matter Expert Evaluation
                                </div>
                            </template>
                            <template slot="action" slot-scope="e">
                                <!-- <a href="{{ route('admin.event.create') }}" class="btn btn-xs btn-info mb-1"><i class="icon-eye"></i></a> -->
                                <a :href="'{{ route('admin.postevaluationquestion.edit_postevalquestion','') }}/'+e.row.peq_id" class="btn btn-xs btn-info mb-1"><i class="icon-pencil"></i></a>
                                <a :href="'{{ route('admin.postevaluationquestion.remove_postevalquestion','') }}/'+e.row.peq_id" class="btn btn-xs btn-danger mb-1"><i class="fa fa-trash"></i></a>
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
                    "question",
                    "answer_type",
                    "sme",
                    "action"
                ],
                options: {
                    uniqueKey:'pes_id',
                    headings: {
                        DT_RowIndex: 'Post evaluation Question No.',
                        question:    'Question',
                        answer_type: 'Answer Type',
                        sme: 'Question Type',
                    },
                    sortable: [
                        "DT_RowIndex",
                        "question",
                        "answer_type",
                    ],
                },
            },
        },
        mounted(){
            this.getAllPostEvaluation();
        },
        methods: {
            getAllPostEvaluation() {
                var url = "{{route('admin.postevaluationquestion.get_postevalquestion_data')}}";
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