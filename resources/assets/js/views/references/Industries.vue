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
                                Industries
                                <small class="font-italic">List of all registered industry.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                                    <b-button v-if="checkRights('2-6')" variant="success" @click="$refs.industryentry.showModalEntry = true, $refs.industryentry.entryMode='Add', $refs.industryentry.clearFields('industry')">
                                            <i class="fa fa-file-o"></i> &nbsp; Create New Industry
                                    </b-button>
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                                    <b-form-input 
                                                v-model="filters.industries.criteria"
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
                                    :filter="filters.industries.criteria"
                                    :fields="tables.industries.fields"
                                    :items.sync="tables.industries.items"
                                    :current-page="paginations.industries.currentPage"
                                    :per-page="paginations.industries.perPage"
                                    @filtered="onFiltered($event,'industries')"
                                    striped hover small show-empty
                                >
                                    <template v-slot:cell(action)="data">
                                        <b-btn v-if="checkRights('2-7')" :size="'sm'" variant="primary" @click="$refs.industryentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('2-8')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.industry_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template>
                                    
                                </b-table>
                            </b-col>
                        </b-row>

                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.industries.totalRows" :per-page="paginations.industries.perPage" v-model="paginations.industries.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <industryentry type="reference" ref="industryentry"></industryentry>
        <deleteentry entity="industry" table="industries" primary_key="industry_id" ref="deleteentry"></deleteentry>
    </div>
</template>

<script>
import industryentry from '../modals/IndustryEntry'
import deleteentry from '../modals/DeleteEntry'
export default {
    name: 'industries',
    components: {
        industryentry,
        deleteentry
    },
    data () {
        return {
            tables: {
                industries: {
                    fields:[
                        {
                            key:'industry_name',
                            label: 'Industry',
                            thStyle: {width: '150px'},
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'industry_desc',
                            label: 'Description',
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
                industries: {
                    criteria: null
                }
            },
            paginations: {
                industries: {
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
                if((this.checkRights('2-7') || this.checkRights('2-8')) == false){
                    this.tables.industries.fields.pop()
                }
            }
            return true
        }
    },
    created () {
        this.fillTableList('industries');
    },
  }
</script>

