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
                                Carousel
                                <small class="font-italic">List of all registered carousel.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                                    <b-button v-if="checkRights('12-46')" variant="success" @click="$refs.carouselentry.showModalEntry = true, $refs.carouselentry.entryMode='Add', $refs.carouselentry.clearFields('carousel')">
                                            <i class="fa fa-file-o"></i> &nbsp; Create New Carousel
                                    </b-button>
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                                    <b-form-input 
                                                v-model="filters.carousels.criteria"
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
                                    :filter="filters.carousels.criteria"
                                    :fields="tables.carousels.fields"
                                    :items.sync="tables.carousels.items"
                                    :current-page="paginations.carousels.currentPage"
                                    :per-page="paginations.carousels.perPage"
                                    @filtered="onFiltered($event,'carousels')"
                                    striped hover small show-empty
                                >
                                    <template v-slot:cell(carousel_image_path)="{ value }">
                                            <img :src="value" alt="image">
                                    </template>           
                                    <template v-slot:cell(action)="data">
                                        <b-btn v-if="checkRights('12-47')" :size="'sm'" variant="primary" @click="$refs.carouselentry.setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('12-48')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.carousel_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template>
                                    
                                </b-table>
                            </b-col>
                        </b-row>

                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.carousels.totalRows" :per-page="paginations.carousels.perPage" v-model="paginations.carousels.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <carouselentry type="reference" ref="carouselentry"></carouselentry>
        <deleteentry entity="carousel" table="carousels" primary_key="carousel_id" ref="deleteentry"></deleteentry>
    </div>
</template>

<script>
import carouselentry from '../modals/CarouselEntry'
import deleteentry from '../modals/DeleteEntry'
export default {
    name: 'carousels',
    components: {
        carouselentry,
        deleteentry
    },
    data () {
        return {
            tables: {
                carousels: {
                    fields:[
                        {
                            key:'carousel_image_path',
                            label: 'Image',
                            thStyle: {width: '300px'},
                            tdClass: 'align-middle'
                        },        
                        {
                            key:'carousel_desc',
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
                carousels: {
                    criteria: null
                }
            },
            paginations: {
                carousels: {
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
                if((this.checkRights('12-47') || this.checkRights('12-48')) == false){
                    this.tables.carousels.fields.pop()
                }
            }
            return true
        }
    },
    created () {
        this.fillTableList('carousels');
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
