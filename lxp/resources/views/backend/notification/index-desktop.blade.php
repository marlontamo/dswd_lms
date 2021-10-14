@inject('request', 'Illuminate\Http\Request')
@extends('backend.layouts.app')
@push('after-styles')
@if(session()->get('display_type') && session()->get('display_type') == "rtl")
<style>
    .message-box .msg_send_btn {
        right: unset !important;
        left: 0 !important;
    }
</style>
@endif
<style>
    textarea {
        resize: none;
    }
</style>
@endpush
@section('content')
<div id="notification_page">

    <div class="card message-box">
        <div class="card-header">
            <h3 class="page-title mb-0">Notification

                <a href="{{route('admin.messages').'?threads'}}" class="d-lg-none text-decoration-none threads d-md-none float-right">
                    <i class="icon-speech font-weight-bold"></i>
                </a>
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <v-client-table :data="list_table.data" :columns="list_table.columns" :options="list_table.options">
                        <template slot="title" slot-scope="e">
                            <span v-html="e.row.data.data.title"></span>
                        </template>
                        <template slot="description" slot-scope="e">
                            <span v-html="e.row.data.data.body"></span>
                        </template>
                        <template slot="date" slot-scope="e">
                            <div class="text-center">
                                <span class="badge badge-info">@{{e.row.read_at}}</span>
                            </div>
                        </template>
                        <template slot="action" slot-scope="e">
                            <button class="btn btn-danger btn-sm" @click="deleteNotification(e.row.id)">Delete</button>
                        </template>

                    </v-client-table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('after-scripts')
<script>
    Vue.use(VueTables.ClientTable);
    var notif_page = new Vue({
        el: '#notification_page',
        data: {
            course_id: "",
            courses: [],
            list_table: {
                data: [],
                columns: [
                    "title",
                    "description",
                    "date",
                    "action"
                ],
                options: {
                    uniqueKey: 'id',
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
        mounted() {
            this.getNotification();
        },
        methods: {
            deleteNotification(id) {
                var url = "{{route('admin.notification.delete')}}";
                axios.post(url, {
                        id: id
                    })
                    .then(function(e) {
                        notif_page.getNotification();
                    })
                    .catch(function(error) {
                        console.log(error)
                    });
            },
            getNotification() {

                var url = "{{route('admin.getNotificationList')}}";
                axios.get(url)
                    .then(function(e) {
                        console.log(e.data.notification)
                        notif_page.list_table.data = e.data.notification;
                    })
                    .catch(function(error) {
                        console.log(error)
                    });
            }
        },
    })
</script>

@endpush