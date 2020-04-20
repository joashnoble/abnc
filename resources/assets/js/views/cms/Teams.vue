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
                                Teams
                                <small class="font-italic">List of all registered teams.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                                    <b-button v-if="checkRights('11-42')" variant="success" @click="$refs.teamentry.showModalEntry = true, $refs.teamentry.entryMode='Add', $refs.teamentry.clearFields('team')">
                                            <i class="fa fa-file-o"></i> &nbsp; Create New Team
                                    </b-button>
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                                    <b-form-input 
                                                v-model="filters.teams.criteria"
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
                                    :filter="filters.teams.criteria"
                                    :fields="tables.teams.fields"
                                    :items.sync="tables.teams.items"
                                    :current-page="paginations.teams.currentPage"
                                    :per-page="paginations.teams.perPage"
                                    @filtered="onFiltered($event,'teams')"
                                    striped hover small show-empty
                                >
                                    <template v-slot:cell(gallery_file_path)="{ value }">
                                            <img :src="value" alt="image">
                                    </template>           
                                    <template v-slot:cell(action)="data">
                                        <b-btn v-if="checkRights('11-43')" :size="'sm'" variant="primary" @click="$refs.teamentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('11-44')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.team_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template>
                                    
                                </b-table>
                            </b-col>
                        </b-row>

                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.teams.totalRows" :per-page="paginations.teams.perPage" v-model="paginations.teams.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <teamentry type="reference" ref="teamentry"></teamentry>
        <deleteentry entity="team" table="teams" primary_key="team_id" ref="deleteentry"></deleteentry>
    </div>
</template>

<script>
import teamentry from '../modals/TeamEntry'
import deleteentry from '../modals/DeleteEntry'
export default {
    name: 'teams',
    components: {
        teamentry,
        deleteentry
    },
    data () {
        return {
            tables: {
                teams: {
                    fields:[
                        {
                            key:'gallery_file_path',
                            label: 'Image',
                            thStyle: {width: '300px'},
                            tdClass: 'align-middle'
                        },        
                        {
                            key:'team_desc',
                            label: 'Description',
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'department_desc',
                            label: 'Department',
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
                teams: {
                    criteria: null
                }
            },
            paginations: {
                teams: {
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
                if((this.checkRights('11-43') || this.checkRights('11-44')) == false){
                    this.tables.teams.fields.pop()
                }
            }
            return true
        }
    },
    created () {
        this.fillTableList('teams');
    },
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  img {
    height: 10rem;
    width: 100%;
  }
</style>
