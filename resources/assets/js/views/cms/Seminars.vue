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
                                Seminars
                                <small class="font-italic">List of all registered seminar.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                                    <b-button v-if="checkRights('5-18')" variant="success" @click="$refs.seminarentry.showModalEntry = true, $refs.seminarentry.entryMode='Add', $refs.seminarentry.clearFields('seminar')">
                                            <i class="fa fa-file-o"></i> &nbsp; Create New Seminar
                                    </b-button>
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
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
                                            <img :src="value" alt="image">
                                    </template>   
                                    <template v-slot:cell(action)="data">
                                        <b-btn v-if="checkRights('5-19')" :size="'sm'" variant="primary" @click="$refs.seminarentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('5-20')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.seminar_id)">
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
    </div>
</template>

<script>
import seminarentry from '../modals/SeminarEntry'
import deleteentry from '../modals/DeleteEntry'
export default {
    name: 'seminars',
    components: {
        seminarentry,
        deleteentry
    },
    data () {
        return {
            tables: {
                seminars: {
                    fields:[
                        {
                            key:'gallery_file_path',
                            label: 'Cover Image',
                            thStyle: {width: '150px'},
                            tdClass: 'align-middle'
                        },      
                        {
                            key:'seminar_title',
                            label: 'Seminar Title',
                            thStyle: {width: '150px'},
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'seminar_description',
                            label: 'Seminar Description',
                            tdClass: 'align-middle',
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
    computed: {
        checkAction(){
            if(this.$store.state.rights.length > 0){
                if((this.checkRights('5-19') || this.checkRights('5-20')) == false){
                    this.tables.seminars.fields.pop()
                }
            }
            return true
        }
    },
    created () {
        this.fillTableList('seminars');
    },
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  img {
    height: 5rem;
  }
</style>
