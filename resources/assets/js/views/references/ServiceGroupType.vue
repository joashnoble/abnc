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
                                Service Group Type
                                <small class="font-italic">List of all registered service group type.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                                    <b-button v-if="checkRights('4-14')" variant="success" @click="$refs.servicegrouptypeentry.showModalEntry = true, $refs.servicegrouptypeentry.entryMode='Add', $refs.servicegrouptypeentry.clearFields('servicegrouptype')">
                                            <i class="fa fa-file-o"></i> &nbsp; Create New Type
                                    </b-button>
                            </b-col>
                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                                    <b-form-input 
                                                v-model="filters.servicesgrouptype.criteria"
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
                                    :filter="filters.servicesgrouptype.criteria"
                                    :fields="tables.servicesgrouptype.fields"
                                    :items.sync="tables.servicesgrouptype.items"
                                    :current-page="paginations.servicesgrouptype.currentPage"
                                    :per-page="paginations.servicesgrouptype.perPage"
                                    @filtered="onFiltered($event,'servicesgrouptype')"
                                    striped hover small show-empty
                                >
                                    <template v-slot:cell(action)="data">
                                        <b-btn v-if="checkRights('4-15')" :size="'sm'" variant="primary" @click="$refs.servicegrouptypeentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('4-16')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.service_group_type_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template>
                                    
                                </b-table>
                            </b-col>
                        </b-row>

                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.servicesgrouptype.totalRows" :per-page="paginations.servicesgrouptype.perPage" v-model="paginations.servicesgrouptype.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <servicegrouptypeentry type="reference" ref="servicegrouptypeentry"></servicegrouptypeentry>
        <deleteentry entity="Service Group Type" table="servicesgrouptype" primary_key="service_group_type_id" ref="deleteentry"></deleteentry>
    </div>
</template>

<script>
import servicegrouptypeentry from '../modals/ServiceGroupTypeEntry'
import deleteentry from '../modals/DeleteEntry'
export default {
    name: 'servicesgrouptype',
    components: {
        servicegrouptypeentry,
        deleteentry
    },
    data () {
        return {
            tables: {
                servicesgrouptype: {
                    fields:[
                        {
                            key:'service_group_code',
                            label: 'Code',
                            thStyle: {width: '150px'},
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'service_group_desc',
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
                servicesgrouptype: {
                    criteria: null
                }
            },
            paginations: {
                servicesgrouptype: {
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
                    this.tables.servicesgrouptype.fields.pop()
                }
            }
            return true
        }
    },
    created () {
        this.fillTableList('servicesgrouptype');
    },
  }
</script>

