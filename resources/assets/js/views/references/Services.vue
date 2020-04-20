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
                                <!-- <i class="fa fa-bars"></i>  -->
                                Services
                                <small class="font-italic">List of all registered services.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                                    <b-button v-if="checkRights('5-18')" variant="success" @click="$refs.serviceentry.showModalEntry = true, $refs.serviceentry.entryMode='Add', $refs.serviceentry.clearFields('service')">
                                            <i class="fa fa-file-o"></i> &nbsp; Create New Service
                                    </b-button>
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
                                    <template v-slot:cell(action)="data">
                                        <b-btn v-if="checkRights('5-19')" :size="'sm'" variant="primary" @click="$refs.serviceentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
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
        <serviceentry type="reference" ref="serviceentry"></serviceentry>
        <deleteentry entity="service" table="services" primary_key="service_id" ref="deleteentry"></deleteentry>
    </div>
</template>

<script>
import serviceentry from '../modals/ServiceEntry'
import deleteentry from '../modals/DeleteEntry'
export default {
    name: 'services',
    components: {
        serviceentry,
        deleteentry
    },
    data () {
        return {
            tables: {
                services: {
                    fields:[
                        {
                            key:'service_code',
                            label: 'Service Code',
                            thStyle: {width: '150px'},
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'service_desc',
                            label: 'Description',
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'category_desc',
                            label: 'Category',
                            tdClass: 'align-middle',
                            sortable: true
                        }, 
                        {
                            key:'service_type_desc',
                            label: 'Service Type',
                            tdClass: 'align-middle',
                            sortable: true
                        },                        
                        {
                            key:'action',
                            label:'',
                            thStyle: {width: '75px'},
                            tdClass: 'text-center align-middle',
                        }
                    ],
                    items: []
                }
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
            }
        }
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
    created () {
        this.fillTableList('services');
    },
  }
</script>

