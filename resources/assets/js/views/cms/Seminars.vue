<template>
    <!--<b-animated fade-in>  main container -->
    <div>
        <notifications group="notification" />
        <div v-show="$refs.seminarentry !== undefined ? $refs.seminarentry.showEntry === false : true" class="animated fadeIn">
            <b-row>
                <b-col sm="12">
                    <b-card class="card-accent-dark">
                        <h5 slot="header">
                            <span>
                                <!-- <i class="fa fa-bars"></i>  -->
                                Seminars
                                <small class="font-italic">List of all registered seminar.</small></span>
                                <b-button 
                                    variant="default" 
                                    style="float:right;margin-top:1px;" 
                                    @click="filterStatusList">
                                    <i class="fa fa-refresh"></i>
                                </b-button>
                        </h5>
                        <b-row class="mb-12">
                            <b-col sm="4">
                                <b-button v-if="checkRights('7-26')" variant="success" @click="$refs.seminarentry.setEntry()">
                                        <i class="fa fa-file-o"></i> &nbsp; Create New Seminar
                                </b-button>
                            </b-col>
                            <b-col  sm="2">
                                <div style="display: inline-block!important;float:right!important; margin-top: 5px!important;"><b>Status:</b></div>
                            </b-col>
                            <b-col  sm="2">
                                <select2
                                    v-model="forms.seminar.fields.status_id"
                                    :allowClear="false"
                                    :placeholder="'Select Status'"
                                    @input="filterStatusList"
                                    style="width: 100%!important;">
                                        <option :key="'all'" :value="'all'" selected>All</option>
                                        <option :key="1" :value="1">Active</option>
                                        <option :key="0" :value="0">Inactive</option>
                                </select2>
                            </b-col>
                            <b-col  sm="4">
                                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                                    <b-form-input 
                                                v-model="filters.seminars.criteria"
                                                type="text" 
                                                placeholder="Search"
                                                debounce="250">
                                    </b-form-input>
                                </b-input-group>
                            </b-col>
                        </b-row>
                        <br>
                        <b-row>
                            <b-col sm="12">
                                <b-table 
                                    v-if="checkAction"
                                    responsive
                                    :filter="filters.seminars.criteria"
                                    :fields="tables.seminars.fields"
                                    :items.sync="tables.seminars.items"
                                    :current-page="paginations.seminars.currentPage"
                                    :per-page="paginations.seminars.perPage"
                                    @filtered="onFiltered($event,'seminars')"
                                    striped hover small show-empty
                                >
                                    <template v-slot:cell(gallery_file_path)="{ value }">
                                            <img :src="value" alt="image" draggable="false">
                                    </template>   
                                    <template v-slot:cell(seminar_title)="data">  
                                        <span data-toggle="tooltip" :title="data.item.seminar_title">{{data.item.seminar_title}}</span>
                                    </template>    
                                    <template v-slot:cell(speaker_fullname)="data">  
                                        <span data-toggle="tooltip" :title="data.item.speaker_fullname">{{data.item.speaker_fullname}}</span>
                                    </template>    
                                    <template v-slot:cell(seminar_date)="data">  
                                        <span data-toggle="tooltip" :title="data.item.seminar_date">{{data.item.seminar_date}}</span>
                                    </template>   
                                    <template v-slot:cell(status)="data">  
                                        <i v-if="data.item.is_show == 1" class="fa fa-check-circle text-success"></i>
                                        <i v-else-if="data.item.is_show == 0" class="fa fa-times-circle text-danger"></i>
                                    </template>  
                                    <template v-slot:cell(action)="data">
                                        <b-btn 
                                            v-if="checkRights('7-27')" 
                                            v-show="data.item.is_show == 1"
                                            :size="'sm'" 
                                            variant="secondary" 
                                            data-toggle="tooltip" 
                                            :title="'Deactivate'"
                                            @click="$refs.showentry.setVisible(data,data.item.seminar_id,0,'inactive','seminar')">
                                            <i class="fa fa-eye-slash"></i>
                                        </b-btn>

                                        <b-btn 
                                            v-if="checkRights('7-27')" 
                                            v-show="data.item.is_show == 0"
                                            :size="'sm'" 
                                            variant="success" 
                                            data-toggle="tooltip" 
                                            :title="'Activate'"
                                            @click="$refs.showentry.setVisible(data,data.item.seminar_id,1,'activate','seminar')">
                                            <i class="fa fa-eye"></i>
                                        </b-btn>

                                        <b-btn 
                                            v-if="checkRights('7-27')" 
                                            :size="'sm'" 
                                            variant="primary" @click="$refs.seminarentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('7-28')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.seminar_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template>
                                    
                                </b-table>
                            </b-col>
                        </b-row>

                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.seminars.totalRows" :per-page="paginations.seminars.perPage" v-model="paginations.seminars.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <seminarentry type="reference" ref="seminarentry"></seminarentry>
        <deleteentry entity="seminar" table="seminars" primary_key="seminar_id" ref="deleteentry"></deleteentry>
        <showentry entity="seminar" table="seminars" primary_key="seminar_id" ref="showentry"></showentry>
    </div>
</template>

<script>
import seminarentry from '../modals/SeminarEntry'
import deleteentry from '../modals/DeleteEntry'
import showentry from '../modals/ShowEntry'
export default {
    name: 'seminars',
    components: {
        seminarentry,
        deleteentry,
        showentry
    },
    data () {
        return {
            tables: {
                seminars: {
                    fields:[
                        {
                            key:'gallery_file_path',
                            label: 'Cover Image',
                            thStyle: {width: '15%'},
                            tdClass: 'align-middle'
                        },      
                        {
                            key:'seminar_title',
                            label: 'Seminar Title',
                            thStyle: {width: '25%'},
                            tdClass: 'align-middle ellipsis',
                            sortable: true
                        },
                        {
                            key:'speaker_fullname',
                            label: 'Speaker',
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'seminar_date',
                            label: 'Seminar Date',
                            tdClass: 'align-middle',
                            sortable: true
                        },   
                        {
                            key:'sort_id',
                            label: 'Sort',
                            thStyle: {width: '5%'},
                            tdClass: 'align-middle text-right',
                            sortable: true
                        },  
                        {
                            key:'status',
                            label:'Status',
                            thStyle: {width: '5%', "text-align":"center"},
                            tdClass: 'text-center align-middle'
                        },      
                        {
                            key:'action',
                            label:'Action',
                            thStyle: {width: '15%', "text-align":"center"},
                            tdClass: 'text-center align-middle'
                        } 
                    ],
                    items: []
                }
            },
            forms: {
                seminar : {
                    fields: {
                        status_id: 'all'
                    }
                }
            },
            filters: {
                seminars: {
                    criteria: null
                }
            },
            paginations: {
                seminars: {
                    totalRows: 0,
                    currentPage: 1,
                    perPage: 10
                }
            }
        }
    },
    methods:{
        filterStatusList(){
            this.cmsfilterTableList('seminars', this.forms.seminar.fields.status_id);
        }
    },
    computed: {
        checkAction(){
            if(this.$store.state.rights.length > 0){
                if((this.checkRights('7-27') || this.checkRights('7-28')) == false){
                    this.tables.seminars.fields.pop()
                }
            }
            return true
        }
    },
    created () {
        this.cmsfilterTableList('seminars', this.forms.seminar.fields.status_id)
    },
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  img {
    height: 5rem;
  }
</style>
