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
                                CSR
                                <small class="font-italic">List of all registered csr.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                                    <b-button v-if="checkRights('6-22')" variant="success" @click="$refs.csrentry.showModalEntry = true, $refs.csrentry.entryMode='Add', $refs.csrentry.clearFields('csr')">
                                            <i class="fa fa-file-o"></i> &nbsp; Create New
                                    </b-button>
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                                    <b-form-input 
                                                v-model="filters.csrs.criteria"
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
                                    :filter="filters.csrs.criteria"
                                    :fields="tables.csrs.fields"
                                    :items.sync="tables.csrs.items"
                                    :current-page="paginations.csrs.currentPage"
                                    :per-page="paginations.csrs.perPage"
                                    @filtered="onFiltered($event,'csrs')"
                                    striped hover small show-empty
                                >
                                    <template v-slot:cell(gallery_file_path)="{ value }">
                                            <img :src="value" alt="image">
                                    </template>       
                                    <template v-slot:cell(action)="data">
                                        <b-btn v-if="checkRights('6-23')" :size="'sm'" variant="primary" @click="$refs.csrentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('6-24')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.csr_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template>
                                    
                                </b-table>
                            </b-col>
                        </b-row>

                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.csrs.totalRows" :per-page="paginations.csrs.perPage" v-model="paginations.csrs.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <csrentry type="reference" ref="csrentry"></csrentry>
        <deleteentry entity="csr" table="csrs" primary_key="csr_id" ref="deleteentry"></deleteentry>
    </div>
</template>

<script>
import csrentry from '../modals/CSREntry'
import deleteentry from '../modals/DeleteEntry'
export default {
    name: 'csrs',
    components: {
        csrentry,
        deleteentry
    },
    data () {
        return {
            tables: {
                csrs: {
                    fields:[
                        {
                            key:'gallery_file_path',
                            label: 'Cover Image',
                            thStyle: {width: '150px'},
                            tdClass: 'align-middle'
                        },   
                        {
                            key:'csr_title',
                            label: 'Title',
                            thStyle: {width: '150px'},
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'csr_text',
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
                csrs: {
                    criteria: null
                }
            },
            paginations: {
                csrs: {
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
                if((this.checkRights('6-23') || this.checkRights('6-24')) == false){
                    this.tables.csrs.fields.pop()
                }
            }
            return true
        }
    },
    created () {
        this.fillTableList('csrs');
    },
  }
</script>


<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  img {
    height: 5rem;
  }
</style>
