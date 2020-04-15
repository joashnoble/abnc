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
                                News &amp; Publication List
                                <small class="font-italic">List of all news and publication.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                                    <b-button v-if="checkRights('4-14')" variant="success" @click="$refs.newspublicationentry.showModalEntry = true, $refs.newspublicationentry.entryMode='Add', $refs.newspublicationentry.clearFields('newspublication')">
                                            <i class="fa fa-file-o"></i> &nbsp; Publish News
                                    </b-button>
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                                    <b-form-input 
                                                v-model="filters.newspublications.criteria"
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
                                    :filter="filters.newspublications.criteria"
                                    :fields="tables.newspublications.fields"
                                    :items.sync="tables.newspublications.items"
                                    :current-page="paginations.newspublications.currentPage"
                                    :per-page="paginations.newspublications.perPage"
                                    @filtered="onFiltered($event,'newspublications')"
                                    striped hover small show-empty
                                >               
                                    <template v-slot:cell(gallery_file_path)="{ value }">
                                            <img :src="value" alt="image">
                                    </template>                                
                                    <template v-slot:cell(action)="data">
                                        <b-btn v-if="checkRights('4-15')" :size="'sm'" variant="primary" @click="$refs.newspublicationentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('4-16')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.news_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template>
                                    
                                </b-table>
                            </b-col>
                        </b-row>
                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.newspublications.totalRows" :per-page="paginations.newspublications.perPage" v-model="paginations.newspublications.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <newspublicationentry type="reference" ref="newspublicationentry"></newspublicationentry>
        <deleteentry entity="newspublication" table="newspublications" primary_key="news_id" ref="deleteentry"></deleteentry>
    </div>
</template>

<script>
import newspublicationentry from '../modals/NewsPublicationEntry'
import deleteentry from '../modals/DeleteEntry'
export default {
    name: 'newspublications',
    components: {
        newspublicationentry,
        deleteentry
    },
    data () {
        return {
            tables: {
                newspublications: {
                    fields:[
                        {
                            key:'gallery_file_path',
                            label: 'Cover Image',
                            thStyle: {width: '150px'},
                            tdClass: 'align-middle'
                        },                        
                        {
                            key:'news_title',
                            label: 'Title',
                            thStyle: {width: '150px'},
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'news_description',
                            label: 'Description',
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'news_publish_date',
                            label: 'Publication Date',
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
                newspublications: {
                    criteria: null
                }
            },
            paginations: {
                newspublications: {
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
                    this.tables.newspublications.fields.pop()
                }
            }
            return true
        }
    },
    created () {
        this.fillTableList('newspublications');
    },
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  img {
    height: 5rem;
  }
</style>
