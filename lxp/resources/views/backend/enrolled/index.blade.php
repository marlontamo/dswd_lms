@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@section('title', 'Course Enrollees' .' | '.app_name())

@section('content')

    <div id="enrollees" class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">Course Enrollees</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6 form-group">
                    <label for="course_id">Courses</label>
                    <select class='form-control' v-on:change="getCourseStudentData" v-model = "course_id" name="course_id" id="course_id" required>
                        <template v-for = "(list,index) in courses">
                            <option v-bind:value="index">@{{list}}</option>
                        </template>
                    </select>
                </div>
            </div>

            
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <v-client-table :data="list_table.data.list" :columns="list_table.columns" :options="list_table.options">
                            <template slot="DT_RowIndex" slot-scope="e">
                                @{{e.index}}
                            </template>
                            <template slot="progress" slot-scope="e">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" :style="{ width: e.row.progress }" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                        @{{e.row.progress}}
                                    </div>
                                </div>
                            </template>
                            <template slot="child_row" slot-scope="e">
                                <div class="row">
                                    <div class="col-md-12">
                                        <v-client-table :data="e.row.tests" :columns="['sr_no','title','overall_score','passing_score','score','action']" >
                                            <template slot="sr_no" slot-scope="st">@{{st.index}}</template>
                                            <template slot="action" slot-scope="st">
                                                <a class="btn btn-warning" v-on:click="view_test_answers(st.row.id,e.row.id)" target="_blank"> Show Answers </a>
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
        el: '#enrollees',
        data: {
            course_id: "",
            courses: [],
            list_table: {
                data: {
                    list: []
                },
                columns: [
                    "DT_RowIndex",
                    "full_name",
                    "gender",
                    "address",
                    "progress",
                ],
                options: {
                    uniqueKey:'id',
                    headings: {
                        DT_RowIndex: 'Sr No.',
                        full_name: 'Full Name',
                        gender: 'Gender',
                        address: 'Address',
                        progress: 'Progress',
                    },
                    sortable: [
                        "DT_RowIndex",
                        "full_name",
                        "gender",
                        "address",
                        "progress",
                    ],
                },
            },
        },
        mounted(){
            this.getCourses();
        },
        methods: {
            getCourseStudentData() {
                console.log("getCourseStudentData");

                var c_id = {
                    params: {
                        course_id: app.course_id
                    }
                }

                if(c_id !== ""){
                    var url = "{{route('admin.enrollees.get_data')}}";
                    axios.get(url,c_id)
                    .then(function (e) {
                        console.log(e)
                        app.list_table.data.list = e.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
                }
            },
            getCourses() {
                var url = "{{route('admin.enrollees.get_courses')}}";
                axios.get(url)
                    .then(function (e) {
                        console.log(e)
                        app.courses = e.data;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
            view_test_answers(testid,userid) {
                route = '{{ route("admin.enrollees.test_answers")}}' + '?testid=' + testid + '&userid=' + userid;
                location.href = route;
            }
        },
    })
</script>

@endpush