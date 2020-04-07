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
                                Service Type
                                <small class="font-italic">List of all registered service type.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                                    <b-button v-if="checkRights('4-14')" variant="success" @click="$refs.servicetypeentry.showModalEntry = true, $refs.servicetypeentry.entryMode='Add', $refs.servicetypeentry.clearFields('servicetype')">
                                            <i class="fa fa-file-o"></i> &nbsp; Create New Type
                                    </b-button>
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                                    <b-form-input 
                                                v-model="filters.servicestype.criteria"
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
                                    :filter="filters.servicestype.criteria"
                                    :fields="tables.servicestype.fields"
                                    :items.sync="tables.servicestype.items"
                                    :current-page="paginations.servicestype.currentPage"
                                    :per-page="paginations.servicestype.perPage"
                                    @filtered="onFiltered($event,'servicestype')"
                                    striped hover small show-empty
                                >
                                    <template v-slot:cell(action)="data">
                                        <b-btn v-if="checkRights('4-15')" :size="'sm'" variant="primary" @click="$refs.servicetypeentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('4-16')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.service_type_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template>
                                    
                                </b-table>
                            </b-col>
                        </b-row>

                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.servicestype.totalRows" :per-page="paginations.servicestype.perPage" v-model="paginations.servicestype.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <servicetypeentry type="reference" ref="servicetypeentry"></servicetypeentry>
        <deleteentry entity="servicetype" table="servicestype" primary_key="service_type_id" ref="deleteentry"></deleteentry>
    </div>
</template>

<script>
import servicetypeentry from '../modals/ServiceTypeEntry'
import deleteentry from '../modals/DeleteEntry'
export default {
    name: 'servicestype',
    components: {
        servicetypeentry,
        deleteentry
    },
    data () {
        return {
            tables: {
                servicestype: {
                    fields:[
                        {
                            key:'service_type_code',
                            label: 'Code',
                            thStyle: {width: '150px'},
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
                servicestype: {
                    criteria: null
                }
            },
            paginations: {
                servicestype: {
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
                if((this.checkRights('4-15') || this.checkRights('4-16')) == false){
                    this.tables.servicestype.fields.pop()
                }
            }
            return true
        }
    },
    created () {
        this.fillTableList('servicestype');
    },
  }
</script>

