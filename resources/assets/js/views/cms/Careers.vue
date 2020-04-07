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
                                Careers
                                <small class="font-italic">List of all registered careers.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                                    <b-button v-if="checkRights('4-14')" variant="success" @click="$refs.careerentry.showModalEntry = true, $refs.careerentry.entryMode='Add', $refs.careerentry.clearFields('career')">
                                            <i class="fa fa-file-o"></i> &nbsp; Create New Career
                                    </b-button>
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                                    <b-form-input 
                                                v-model="filters.careers.criteria"
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
                                    :filter="filters.careers.criteria"
                                    :fields="tables.careers.fields"
                                    :items.sync="tables.careers.items"
                                    :current-page="paginations.careers.currentPage"
                                    :per-page="paginations.careers.perPage"
                                    @filtered="onFiltered($event,'careers')"
                                    striped hover small show-empty
                                >
                                    <template v-slot:cell(action)="data">
                                        <b-btn v-if="checkRights('4-15')" :size="'sm'" variant="primary" @click="$refs.careerentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('4-16')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.career_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template>
                                    
                                </b-table>
                            </b-col>
                        </b-row>

                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.careers.totalRows" :per-page="paginations.careers.perPage" v-model="paginations.careers.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <careerentry type="reference" ref="careerentry"></careerentry>
        <deleteentry entity="career" table="careers" primary_key="career_id" ref="deleteentry"></deleteentry>
    </div>
</template>

<script>
import careerentry from '../modals/CareerEntry'
import deleteentry from '../modals/DeleteEntry'
export default {
    name: 'careers',
    components: {
        careerentry,
        deleteentry
    },
    data () {
        return {
            tables: {
                careers: {
                    fields:[
                        {
                            key:'career_title',
                            label: 'Career',
                            thStyle: {width: '150px'},
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'career_description',
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
                careers: {
                    criteria: null
                }
            },
            paginations: {
                careers: {
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
                    this.tables.careers.fields.pop()
                }
            }
            return true
        }
    },
    created () {
        this.fillTableList('careers');
    },
  }
</script>

