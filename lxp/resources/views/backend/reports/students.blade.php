@extends('backend.layouts.app')

@section('title', __('labels.backend.reports.students_report').' | '.app_name())

@section('content')

    <div id="sample" class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">@lang('labels.backend.reports.students_report')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <v-client-table :data="list_table.data.list" :columns="list_table.columns" :options="list_table.options" ref='idcc_list_table'>
                            <template slot="DT_RowIndex" slot-scope="e">
                                @{{e.index}}
                            </template>
                            <template slot="child_row" slot-scope="e">
                                <div class="row">
                                    <div class="col-md-12">
                                        <v-client-table :data="e.row.students" :columns="['full_name','gender','progress']" >
                                            <template slot="progress" slot-scope="e">
                                                <div class="progress">
                                                  <div class="progress-bar progress-bar-striped" role="progressbar" :style="{ width: e.row.progress }" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </template>
                                        </v-client-table>
                                    </div>
                                </div>
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
                    "count_male",
                    "count_female",
                    "students_count",
                    "male_completed_count",
                    "female_completed_count",
                    "course_completed",
                ],
                options: {
                    uniqueKey:'id',
                    headings: {
                        DT_RowIndex: 'Sr No.',
                        title: 'Course',
                        students_count: 'Total Students',
                        count_male: 'Male Students',
                        count_female: 'Female Students',
                        male_completed_count: 'Male Students (Completed)',
                        female_completed_count: 'Female Students (Completed)',
                        course_completed: 'Completed'
                    },
                    sortable: [
                        "DT_RowIndex",
                        "title",
                        "count_male",
                        "count_female",
                        "students_count",
                        "completed",
                    ],
                },
            },
        },
        mounted(){
            this.getAllStudentReport();
        },
        methods: {
            getAllStudentReport() {
                var url = "{{route('admin.reports.get_students_data')}}";
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