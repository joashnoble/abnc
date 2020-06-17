<template>
    <!--<b-animated fade-in>  main container -->
    <div>
        <notifications group="notification" />
        <div v-show="$refs.newspublicationentry !== undefined ? $refs.newspublicationentry.showEntry === false : true" class="animated fadeIn">
            <b-row>
                <b-col sm="12">
                    <b-card class="card-accent-dark">
                        <h5 slot="header">
                            <span>
                                <!-- <i class="fa fa-bars"></i>  -->
                                News &amp; Publication List
                                <small class="font-italic">List of all news and publication.</small></span>
                                <b-button 
                                    variant="default" 
                                    style="float:right;margin-top:1px;" 
                                    @click="filterStatusList()">
                                    <i class="fa fa-refresh"></i>
                                </b-button>
                        </h5>
                        <b-row class="mb-12">
                            <b-col sm="4">
                                <b-button v-if="checkRights('6-22')" variant="success" @click="$refs.newspublicationentry.setEntry()">
                                        <i class="fa fa-file-o"></i> &nbsp; Publish News
                                </b-button>
                            </b-col>
                            <b-col  sm="2">
                                <div style="display: inline-block!important;float:right!important; margin-top: 5px!important;"><b>Status:</b></div>
                            </b-col>
                            <b-col  sm="2">
                                <select2
                                    v-model="forms.newspublication.fields.status_id"
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
                                                v-model="filters.newspublications.criteria"
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
                                    :filter="filters.newspublications.criteria"
                                    :fields="tables.newspublications.fields"
                                    :items.sync="tables.newspublications.items"
                                    :current-page="paginations.newspublications.currentPage"
                                    :per-page="paginations.newspublications.perPage"
                                    @filtered="onFiltered($event,'newspublications')"
                                    striped hover small show-empty
                                >               
                                    <template v-slot:cell(gallery_file_path)="{ value }">
                                            <img :src="value" alt="image" width="100%" draggable="false">
                                    </template>   
                                    <template v-slot:cell(news_title)="data">  
                                        <span data-toggle="tooltip" :title="data.item.news_title">{{data.item.news_title}}</span>
                                    </template>    
                                    <template v-slot:cell(news_description)="data">  
                                        <span data-toggle="tooltip" :title="data.item.news_description">{{data.item.news_description}}</span>
                                    </template>    
                                    <template v-slot:cell(status)="data">  
                                        <i v-if="data.item.is_show == 1" class="fa fa-check-circle text-success"></i>
                                        <i v-else-if="data.item.is_show == 0" class="fa fa-times-circle text-danger"></i>
                                    </template>  
                                    <template v-slot:cell(action)="data">

                                        <b-btn 
                                            v-if="checkRights('6-23')" 
                                            v-show="data.item.is_show == 1"
                                            :size="'sm'" 
                                            variant="secondary" 
                                            data-toggle="tooltip" 
                                            :title="'Deactivate'"
                                            @click="$refs.showentry.setVisible(data,data.item.news_id,0,'inactive','News and Publication')">
                                            <i class="fa fa-eye-slash"></i>
                                        </b-btn>

                                        <b-btn 
                                            v-if="checkRights('6-23')" 
                                            v-show="data.item.is_show == 0"
                                            :size="'sm'" 
                                            variant="success" 
                                            data-toggle="tooltip" 
                                            :title="'Activate'"
                                            @click="$refs.showentry.setVisible(data,data.item.news_id,1,'activate','News and Publication')">
                                            <i class="fa fa-eye"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('6-23')" 
                                            :size="'sm'" 
                                            variant="primary" 
                                            data-toggle="tooltip" 
                                            :title="'Edit'" 
                                            @click="$refs.newspublicationentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('6-24')" 
                                            :size="'sm'" 
                                            variant="danger" 
                                            data-toggle="tooltip" 
                                            :title="'Delete'" 
                                            @click="$refs.deleteentry.setDelete(data.item.news_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template>
                                    
                                </b-table>
                            </b-col>
                        </b-row>
                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.newspublications.totalRows" :per-page="paginations.newspublications.perPage" v-model="paginations.newspublications.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <newspublicationentry type="reference" ref="newspublicationentry"></newspublicationentry>
        <deleteentry entity="newspublication" table="newspublications" primary_key="news_id" ref="deleteentry"></deleteentry>
        <showentry entity="newspublication" table="newspublications" primary_key="news_id" ref="showentry"></showentry>
    </div>
</template>

<script>
import newspublicationentry from '../modals/NewsPublicationEntry'
import deleteentry from '../modals/DeleteEntry'
import showentry from '../modals/ShowEntry'
export default {
    name: 'newspublications',
    components: {
        newspublicationentry,
        deleteentry,
        showentry
    },
    data () {
        return {
            tables: {
                newspublications: {
                    fields:[
                        {
                            key:'gallery_file_path',
                            label: 'Cover Image',
                            thStyle: {width: '15%'},
                            tdClass: 'align-middle'
                        },                        
                        {
                            key:'news_title',
                            label: 'Title',
                            thStyle: {width: '25%'},
                            tdClass: 'align-middle ellipsis',
                            sortable: true
                        },
                        {
                            key:'news_publish_date',
                            label: 'Publication Date',
                            thStyle: {width: '20%'},
                            tdClass: 'align-middle',
                            sortable: true
                        },   
                        {
                            key:'publisher',
                            label: 'Published by',
                            thStyle: {width: '15%'},
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
                            tdClass: 'text-center align-middle',
                        }                       
                    ],
                    items: []
                }
            },
            forms: {
                newspublication : {
                    fields: {
                        status_id: 'all'
                    }
                }
            },
            filters: {
                newspublications: {
                    criteria: null
                }
            },
            paginations: {
                newspublications: {
                    totalRows: 0,
                    currentPage: 1,
                    perPage: 10
                }
            },
            row: []
        }
    },
    methods:{
        filterStatusList(){
            this.cmsfilterTableList('newspublications', this.forms.newspublication.fields.status_id);
        }
    },
    computed: {
        checkAction(){
            if(this.$store.state.rights.length > 0){
                if((this.checkRights('6-23') || this.checkRights('6-24')) == false){
                    this.tables.newspublications.fields.pop()
                }
            }
            return true
        }
    },
    created () {
        this.cmsfilterTableList('newspublications', this.forms.newspublication.fields.status_id)
    },
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  img {
    height: 5rem;
  }
</style>
