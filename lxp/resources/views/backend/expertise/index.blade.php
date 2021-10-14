@extends('backend.layouts.app')
@section('title', 'Expertise | '.app_name())

@section('content')

    <div id="expertise" class="card">
        <div class="card-header">
            <h3 class="page-title d-inline">Directory of Expertise</h3>
            <div class="float-right">
                <a href="{{ route('admin.expertise.create') }}" class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-12">
                    <ul class="nav main-nav-tabs nav-tabs" >
                        <li class="nav-item"><a data-toggle="tab" class="nav-link active " href="#cgs">
                                Core Group of Specialist </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#swedlnet_ind">
                                SWDLNET(Individual)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a data-toggle="tab" class="nav-link" href="#swedlnet_org">
                                SWDLNET(Organization)
                            </a>
                        </li>
                    </ul>
                    <h4 class="card-title mb-0">
                        {{--{{ __('labels.backend.general_settings.management') }}--}}
                    </h4>
                </div><!--col-->
            </div><!--row-->

            
            <div class="tab-content">

                <!---CGS Tab--->
                <div id="cgs" class="tab-pane container active">
                    <div class="row justify-content-center">
                        <h5>Core Group of Specialist</h5>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <v-client-table :data="cgs_table.data.list" :columns="cgs_table.columns" :options="cgs_table.options">
                                    <template slot="index" slot-scope="e">
                                        @{{e.index}}
                                    </template>
                                    <template slot="image" slot-scope="e">
                                        <img :src="e.row.image" height="50px">
                                    </template>
                                    <template slot="action" slot-scope="e">
                                        <a class="btn btn-xs btn-primary mb-1" :href="e.row.action.show" target="_blank"> <i class="icon-eye"></i> </a>
                                        <a class="btn btn-xs btn-info mb-1" :href="e.row.action.edit" target="_blank"> <i class="icon-pencil"></i> </a>
                                        <!-- <a class="btn btn-xs btn-danger mb-1" :href="e.row.action.delete" target="_blank"> <i class="icon-trash"></i> </a> -->
                                        
                                        <a data-method="delete" data-trans-button-cancel="{{__('buttons.general.cancel')}}"
                                        data-trans-button-confirm="{{__('buttons.general.crud.delete')}}" data-trans-title="{{__('strings.backend.general.are_you_sure')}}"
                                        class="btn btn-xs btn-danger text-white mb-1" style="cursor:pointer;"
                                        onclick="$(this).find('form').submit();">
                                            <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{__('buttons.general.crud.delete')}}"></i>
                                            <form :action="e.row.action.delete" method="POST" name="delete_item" style="display:none">
                                                @csrf
                                                {{method_field('DELETE')}}
                                            </form>
                                        </a>

                                    </template>
                                </v-client-table> 
                            </div>
                        </div>
                    </div>
                </div>

                <!---SWEDLNET(Individual) Tab--->
                <div id="swedlnet_ind" class="tab-pane container fade">
                    <div class="row justify-content-center">
                        <h5>SWDLNET Individual Members</h5>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <v-client-table :data="ind_table.data.list" :columns="ind_table.columns" :options="ind_table.options">
                                    <template slot="index" slot-scope="e">
                                        @{{e.index}}
                                    </template>
                                    <template slot="image" slot-scope="e">
                                        <img :src="e.row.image" height="50px">
                                    </template>
                                    <template slot="action" slot-scope="e">
                                        <a class="btn btn-xs btn-primary mb-1" :href="e.row.action.show" target="_blank"> <i class="icon-eye"></i> </a>
                                        <a class="btn btn-xs btn-info mb-1" :href="e.row.action.edit" target="_blank"> <i class="icon-pencil"></i> </a>
                                        <!-- <a class="btn btn-xs btn-danger mb-1" :href="e.row.action.delete" target="_blank"> <i class="icon-trash"></i> </a> -->
                                        
                                        <a data-method="delete" data-trans-button-cancel="{{__('buttons.general.cancel')}}"
                                        data-trans-button-confirm="{{__('buttons.general.crud.delete')}}" data-trans-title="{{__('strings.backend.general.are_you_sure')}}"
                                        class="btn btn-xs btn-danger text-white mb-1" style="cursor:pointer;"
                                        onclick="$(this).find('form').submit();">
                                            <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{__('buttons.general.crud.delete')}}"></i>
                                            <form :action="e.row.action.delete" method="POST" name="delete_item" style="display:none">
                                                @csrf
                                                {{method_field('DELETE')}}
                                            </form>
                                        </a>

                                    </template>
                                </v-client-table> 
                            </div>
                        </div>
                    </div>
                </div>

                <!---SWEDLNET(Organization) Tab--->
                <div id="swedlnet_org" class="tab-pane container fade">
                    <div class="row justify-content-center">
                        <h5>SWDLNET Organizations</h5>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <v-client-table :data="org_table.data.list" :columns="org_table.columns" :options="org_table.options">
                                    <template slot="index" slot-scope="e">
                                        @{{e.index}}
                                    </template>
                                    <template slot="image" slot-scope="e">
                                        <img :src="e.row.image" height="50px">
                                    </template>
                                    <template slot="action" slot-scope="e">
                                        <a class="btn btn-xs btn-primary mb-1" :href="e.row.action.show" target="_blank"> <i class="icon-eye"></i> </a>
                                        <a class="btn btn-xs btn-info mb-1" :href="e.row.action.edit" target="_blank"> <i class="icon-pencil"></i> </a>
                                        <!-- <a class="btn btn-xs btn-danger mb-1" :href="e.row.action.delete" target="_blank"> <i class="icon-trash"></i> </a> -->
                                        
                                        <a data-method="delete" data-trans-button-cancel="{{__('buttons.general.cancel')}}"
                                        data-trans-button-confirm="{{__('buttons.general.crud.delete')}}" data-trans-title="{{__('strings.backend.general.are_you_sure')}}"
                                        class="btn btn-xs btn-danger text-white mb-1" style="cursor:pointer;"
                                        onclick="$(this).find('form').submit();">
                                            <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{__('buttons.general.crud.delete')}}"></i>
                                            <form :action="e.row.action.delete" method="POST" name="delete_item" style="display:none">
                                                @csrf
                                                {{method_field('DELETE')}}
                                            </form>
                                        </a>

                                    </template>
                                </v-client-table> 
                            </div>
                        </div>
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
        el: '#expertise',
        data: {
            course_id: "",
            courses: [],
            cgs_table: {
                data: {
                    list: []
                },
                columns: [
                    "index",
                    "fullname",
                    "image",
                    "email",
                    "position",
                    "office",
                    "cat_name",
                    "action",
                ],
                options: {
                    uniqueKey:'id',
                    headings: {
                        index: 'Sr No.',
                        fullname: 'Fullname',
                        image: 'Image',
                        email: 'Email',
                        position: 'Position',
                        office: 'Office',
                        cat_name: 'Category',
                        action: 'Action',
                    },
                    sortable: [
                        "index",
                        "fullname",
                        "cat_name",
                    ],
                },
            },
            ind_table: {
                data: {
                    list: []
                },
                columns: [
                    "index",
                    "fullname",
                    "image",
                    "email",
                    "position",
                    "office",
                    "cat_name",
                    "action",
                ],
                options: {
                    uniqueKey:'id',
                    headings: {
                        index: 'Sr No.',
                        fullname: 'Fullname',
                        image: 'Image',
                        email: 'Email',
                        position: 'Position',
                        office: 'Office',
                        cat_name: 'Category',
                        action: 'Action',
                    },
                    sortable: [
                        "index",
                        "fullname",
                        "cat_name",
                    ],
                },
            },
            org_table: {
                data: {
                    list: []
                },
                columns: [
                    "index",
                    "office",
                    "image",
                    "email",
                    "fullname",
                    "action",
                ],
                options: {
                    uniqueKey:'id',
                    headings: {
                        index: 'Sr No.',
                        office: 'Organization Name',
                        image: 'Image',
                        email: 'Email',
                        fullname: 'Representative Name',
                        action: 'Action',
                    },
                    sortable: [
                        "index",
                        "fullname",
                        "cat_name",
                    ],
                },
            },
        },
        mounted(){
            this.getData();
        },
        methods: {
            getData() {
                console.log("get_Data");
                var url = "{{route('admin.expertise.get_data')}}";
                axios.get(url)
                    .then(function (e) {
                        console.log(e)
                        app.cgs_table.data.list = e.data.cgs;
                        app.ind_table.data.list = e.data.individual;
                        app.org_table.data.list = e.data.org;
                    })
                    .catch(function (error) {
                        console.log(error)
                    });
            },
        },
    })
</script>

@endpush