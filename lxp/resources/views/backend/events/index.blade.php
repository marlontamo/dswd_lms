@extends('backend.layouts.app')

@section('title', 'Event Library | '.app_name())

@section('content')
<div id="app">
    <div class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">Event Library</h3>
            <div class="float-right">
                <a href="#" class="btn btn-success" @click="addEvent('modal')">Add New</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">

                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" name="_token" id="mytoken" value="{{ csrf_token() }}" />
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Title</label>
                            <input type="text" class="form-control" v-model="form.title">
                        </div>
                        <div class="col-md-12">
                            <label for="">Description</label>
                            <textarea v-model="form.description" class="form-control" cols="5" rows="5"></textarea>
                        </div>
                        <hr>
                    </div>
                    <hr>
                    <h4>Event List</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <template v-for="(list,index) in form.task">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <h3 class="page-title d-inline">@{{index+1}}</h3>
                                            </div>
                                            <div class="col-md-10" v-if="list.sub.length >=1">
                                                <label for="">Progress: @{{getProgress(index).total_complete}} / @{{getProgress(index).total_sub}}</label>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" :style="getProgress(index).percent" :aria-valuenow="getProgress(index).total_complete" aria-valuemin="0" :aria-valuemax="getProgress(index).total_sub"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" v-model="form.task[index].title" placeholder="Event Title">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="date" class="form-control" v-model="form.task[index].deadline">
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-danger" @click="removeEvent('main',index) ">Delete</button>
                                            </div>
                                        </div>
                                        <template v-if="list.sub.length >=1">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5>Sub Event</h5>
                                                    <template v-for="(l,i) in list.sub">
                                                        <div class="row ">
                                                            <div class="col-md-1 text-right">
                                                                <label for="" class="">@{{i+1}}</label>
                                                            </div>
                                                            <div class="col-md-5 ">
                                                                <input type="text" class="form-control" v-model="list.sub[i].title">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type="date" class="form-control" v-model="list.sub[i].deadline">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <input type="checkbox" class="form-control" v-model="list.sub[i].complete">
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <button class="btn btn-danger" @click="removeEvent('sub',index,i) ">Delete</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <br>
                                                <label for=""></label>
                                                <button class="btn btn-primary " @click="addMainList('sub',index)">Add Sub Event</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </template>
                            <button class="btn btn-primary" @click="addMainList('new')">Add New List</button>
                            <div class="row">
                                <div class="col-md-12"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="saveEvent">Save Event</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@push('after-scripts')
<script>
    var app = new Vue({
        el: '#app',
        data: {
            form: {
                _token: $("#mytoken").val(),
                title: "",
                description: "",
                task: [{
                    title: "",
                    deadline: "",
                    complete: false,
                    sub: [{
                        title: "",
                        deadline: "",
                        complete: false,
                    }]
                }]
            }

        },
        methods: {
            saveEvent() {
                var url = 'save_event';
                $.post(url, this.form,
                    function(data, status) {
                        if (data.success) {
                            $("#addModal").modal('hide');
                        }
                    });
            },
            getProgress(index) {
                var total_sub = this.form.task[index].sub.length >= 1 ? this.form.task[index].sub.length : 0;
                var total_complete = 0;
                var percent = "0.00%"
                var total_percent = 0;
                if (total_sub >= 1) {
                    this.form.task[index].sub.forEach(e => {
                        if (e.complete) {
                            total_complete++;
                        }
                    });
                    total_percent = parseFloat(total_complete) / parseFloat(total_sub) * 100;
                }
                return {
                    "total_sub": total_sub,
                    "total_complete": total_complete,
                    "percent": "width: " + total_percent + "%"
                }
            },
            addMainList(type = '', ix = '') {
                console.log(ix)
                if (type == 'new') {
                    this.form.task.push({
                        title: "",
                        deadline: "",
                        sub: [{
                            title: "",
                            deadline: "",
                            complete: false,
                        }]
                    })
                } else if (type == 'sub') {
                    this.form.task[ix].sub.push({
                        title: "",
                        deadline: "",
                        complete: false,
                    })
                }
            },
            addEvent(type = "") {
                if (type == "modal") {
                    $("#addModal").modal('show');
                }
            },
            removeEvent(type = "", index = "", ix = "") {
                if (type == 'main') {
                    this.form.task.splice(index, 1)
                } else if (type == 'sub') {
                    this.form.task[index].sub.splice(ix, 1)
                }
            }
        }
    })
</script>
@endpush