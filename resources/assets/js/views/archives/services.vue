<template>
    <!--<b-animated fade-in>  main container -->
    <div>
        <notifications group="notification" />
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12">
                    <b-card class="card-accent-dark">
                        <h5 slot="header">
                            <span>
                                Archived Services
                                <small class="font-italic">List of all archived services.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                            </b-col>
                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                                    <b-form-input 
                                                v-model="filters.services.criteria"
                                                type="text" 
                                                placeholder="Search"
                                                debounce="250">
                                    </b-form-input>
                                </b-input-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col sm="12">
                                <b-table 
                                    v-if="checkAction"
                                    responsive
                                    :filter="filters.services.criteria"
                                    :fields="tables.services.fields"
                                    :items.sync="tables.services.items"
                                    :current-page="paginations.services.currentPage"
                                    :per-page="paginations.services.perPage"
                                    @filtered="onFiltered($event,'services')"
                                    striped hover small show-empty
                                >
                                    <template v-slot:cell(service_type_desc)="data">  
                                        <span data-toggle="tooltip" :title="data.item.service_type_desc">{{data.item.service_type_desc}}</span>
                                    </template>
                                    <template v-slot:cell(service_desc)="data">  
                                        <span data-toggle="tooltip" :title="data.item.service_desc">{{data.item.service_desc}}</span>
                                    </template>
                                    <template v-slot:cell(action)="data">

                                        <b-btn v-if="checkRights('5-20')" :size="'sm'" variant="warning" @click="$refs.archiveentry.setArchive(data.item.service_id,1)">
                                            <i class="fa fa-arrow-up"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('5-20')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.service_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template>
                                    
                                </b-table>
                            </b-col>
                        </b-row>

                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.services.totalRows" :per-page="paginations.services.perPage" v-model="paginations.services.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <deleteentry entity="service" table="services" primary_key="service_id" ref="deleteentry"></deleteentry>
        <archiveentry type="unarchive" entity="service" table="services" primary_key="service_id" ref="archiveentry"></archiveentry>
    </div>
</template>

<script>
import deleteentry from '../modals/DeleteEntry'
import archiveentry from '../modals/ArchiveEntry'
export default {
    name: 'archiveservices',
    components: {
        deleteentry,
        archiveentry
    },
    data () {
        return {
            entryMode: 'Add',
            showModalConfirmation: false,
            tables: {
                services: {
                    fields:[
                        {
                            key:'service_code',
                            label: 'Service Code',
                            thStyle: {width: '15%'},
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'category_desc',
                            label: 'Category',
                            thStyle: {width: '20%'},
                            tdClass: 'align-middle',
                            sortable: true
                        },  
                        {
                            key:'service_type_desc',
                            label: 'Service Type',
                            thStyle: {width: '25%'},
                            tdClass: 'align-middle ellipsis',
                            sortable: true
                        },
                        {
                            key:'service_desc',
                            label: 'Description',
                            thStyle: {width: '25%'},
                            tdClass: 'align-middle ellipsis',
                            sortable: true
                        },       
                        {
                            key:'action',
                            label:'',
                            thStyle: {width: '15%'},
                            tdClass: 'text-center align-middle',
                        }
                    ],
                    items: []
                },          
            },
            filters: {
                services: {
                    criteria: null
                }
            },
            paginations: {
                services: {
                    totalRows: 0,
                    currentPage: 1,
                    perPage: 10
                }
            },
            is_check_all: 0,
            row: []
        }
    },
    created () {
        this.archiveFillTableList('services',0)       
    },
    computed: {
        
        checkAction(){
            if(this.$store.state.rights.length > 0){
                if((this.checkRights('5-19') || this.checkRights('5-20')) == false){
                    this.tables.services.fields.pop()
                }
            }
            return true
        }
    },
  }
</script>

