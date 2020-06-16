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
                                Clients Management
                                <small class="font-italic">List of all registered clients.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                                    <!-- <b-button v-if="checkRights('8-30')" variant="success" @click="$refs.csrentry.showModalEntry = true, $refs.csrentry.entryMode='Add', $refs.csrentry.clearFields('csr')">
                                            <i class="fa fa-file-o"></i> &nbsp; Create New
                                    </b-button> -->
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                                    <b-form-input 
                                                v-model="filters.clients.criteria"
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
                                    :filter="filters.clients.criteria"
                                    :fields="tables.clients.fields"
                                    :items.sync="tables.clients.items"
                                    :current-page="paginations.clients.currentPage"
                                    :per-page="paginations.clients.perPage"
                                    @filtered="onFiltered($event,'clients')"
                                    striped hover small show-empty
                                >   
                                    <!-- <template v-slot:cell(action)="data">
                                        <b-btn v-if="checkRights('8-31')" :size="'sm'" variant="primary" @click="$refs.clientsentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('8-32')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.client_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template> -->
                                    
                                </b-table>
                            </b-col>
                        </b-row>

                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.clients.totalRows" :per-page="paginations.clients.perPage" v-model="paginations.clients.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <!-- <deleteentry entity="clients" table="clients" primary_key="client_id" ref="deleteentry"></deleteentry> -->
    </div>
</template>

<script>
// import deleteentry from '../modals/DeleteEntry'
export default {
    name: 'clients',
    components: {
        // deleteentry
    },
    data () {
        return {
            tables: {
                clients: {
                    fields:[
                        {
                            key:'company_name',
                            label: 'Company',
                            thStyle: {width: '150px'},
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'company_email',
                            label: 'Emial Address',
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'business_service',
                            label: 'Business Service',
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'company_mobile',
                            label: 'Company Mobile ',
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
                clients: {
                    criteria: null
                }
            },
            paginations: {
                clients: {
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
                if((this.checkRights('8-31') || this.checkRights('8-32')) == false){
                    this.tables.clients.fields.pop()
                }
            }
            return true
        }
    },
    created () {
        this.fillTableList('clients');
    },
  }
</script>