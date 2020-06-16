<template>
    <!--<b-animated fade-in>  main container -->
    <div>
        <notifications group="notification" />
        <div v-show="showEntry === false" class="animated fadeIn">
            <b-row>
                <b-col sm="12">
                    <b-card class="card-accent-dark">
                        <h5 slot="header">
                            <span>
                                <!-- <i class="fa fa-bars"></i>  -->
                                Services
                                <small class="font-italic">List of all registered services.</small></span>
                        </h5>
                        <b-row class="mb-2">
                            <b-col sm="4">
                                    <!-- <b-button v-if="checkRights('5-18')" variant="success" @click="$refs.serviceentry.showModalEntry = true, $refs.serviceentry.entryMode='Add', $refs.serviceentry.clearFields('service')">
                                            <i class="fa fa-file-o"></i> &nbsp; Create New Service
                                    </b-button> -->

                                    <b-button variant="success" 
                                        v-if="checkRights('5-18')"
                                        @click="setEntry(false), addItem()">
                                            <i class="fa fa-file-o"></i> &nbsp; Create New Service
                                    </b-button>
                            </b-col>
                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                                    <b-form-input 
                                                v-model="filters.services.criteria"
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
                                    :filter="filters.services.criteria"
                                    :fields="tables.services.fields"
                                    :items.sync="tables.services.items"
                                    :current-page="paginations.services.currentPage"
                                    :per-page="paginations.services.perPage"
                                    @filtered="onFiltered($event,'services')"
                                    striped hover small show-empty
                                >
                                    <template v-slot:cell(service_type_desc)="data">  
                                        <span data-toggle="tooltip" :title="data.item.service_type_desc">{{data.item.service_type_desc}}</span>
                                    </template>
                                    <template v-slot:cell(service_desc)="data">  
                                        <span data-toggle="tooltip" :title="data.item.service_desc">{{data.item.service_desc}}</span>
                                    </template>
                                    <template v-slot:cell(action)="data">
                                        <b-btn v-if="checkRights('5-19')" :size="'sm'" variant="primary" @click="setUpdate(data)">
                                            <i class="fa fa-edit"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('5-20')" :size="'sm'" variant="warning" @click="$refs.archiveentry.setArchive(data.item.service_id,0)">
                                            <i class="fa fa-archive"></i>
                                        </b-btn>

                                        <b-btn v-if="checkRights('5-20')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.service_id)">
                                            <i class="fa fa-trash"></i>
                                        </b-btn>
                                    </template>
                                    
                                </b-table>
                            </b-col>
                        </b-row>

                        <template v-slot:footer>
                            <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1 ">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.services.totalRows" :per-page="paginations.services.perPage" v-model="paginations.services.currentPage"
                                    class="my-0" />
                                </b-col>
                            </b-row> <!-- Pagination -->
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        
        <div v-show="showEntry" class="animated fadeIn">
            <b-row>
                <b-col sm="12">
                    <b-card class="card-accent-dark">
                        <h5 slot="header">
                            <span>
                                Service Entry - <small>{{entryMode}}</small>
                            </span>
                        </h5>
                        <!-- @keydown="resetFieldStates('service_items')" -->
                        <b-form autocomplete="off">
                            <b-row>
                                <b-col sm=4>
                                    <b-form-group>
                                        <label class="required" for="service_code">Code</label>
                                        <b-form-input
                                            ref="service_code"
                                            id="service_code"
                                            v-model="forms.service.fields.service_code"
                                            debounce="250"
                                            type="text"
                                            placeholder="Service Code">
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col sm=4>
                                    <b-form-group>
                                        <label class="required">Service Type</label>
                                        <select2
                                            ref="service_type_id"
                                            :allowClear="false"
                                            :placeholder="'Select Type'"
                                            v-model="forms.service.fields.service_type_id"
                                            @input="displayCategory">
                                                <option v-for="servicestype in options.servicestype.items" :key="servicestype.service_type_id" :value="servicestype.service_type_id">{{servicestype.service_type_desc}}</option>
                                        </select2>
                                    </b-form-group>
                                </b-col>
                                <b-col sm=4> 
                                    <b-form-group>
                                        <label>Category</label>
                                        <b-form-input
                                            ref="category_desc"
                                            id="category_desc"
                                            v-model="forms.service.fields.category_desc"
                                            debounce="250"
                                            type="text"
                                            readonly="readonly"
                                            placeholder="Category">
                                        </b-form-input>
                                    </b-form-group>                                    
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col sm=6>
                                    <b-form-group>
                                        <label class="required">Service Description</label>
                                        <b-form-textarea
                                            tab="0"
                                            ref="service_desc"
                                            id="service_desc"
                                            v-model="forms.service.fields.service_desc"
                                            debounce="250"
                                            type="text"
                                            :rows="2"
                                            placeholder="Service Description">
                                        </b-form-textarea>
                                    </b-form-group>  
                                </b-col>
                                <b-col sm=6>
                                    <b-form-group>
                                        <label>Note</label>
                                        <b-form-textarea
                                            tab="0"
                                            ref="service_note"
                                            id="service_note"
                                            v-model="forms.service.fields.service_note"
                                            debounce="250"
                                            type="text"
                                            :rows="2"
                                            placeholder="Service Note">
                                        </b-form-textarea>
                                    </b-form-group>                                     
                                </b-col>
                            </b-row>                            
                            <b-row>
                                
                                <b-col lg="12">
                                    
                                    <b-table 
                                        responsive
                                        small bordered
                                        :fields="tables.service_items.fields"
                                        :items.sync="tables.service_items.items"
                                        show-empty>

                                        <template v-slot:cell(service_group_type_id)="data">
                                            <select2
                                                :allowClear="false"
                                                :placeholder="'Select Group Type'"
                                                v-model="data.item.service_group_type_id"
                                                @input="checkItem(data.index, data.item.service_group_type_id)"
                                            >
                                                <!-- <option value="0">None</option> -->
                                                <option v-for="servicesgrouptype in options.servicesgrouptype.items" :key="servicesgrouptype.service_group_type_id" :value="servicesgrouptype.service_group_type_id">
                                                    {{servicesgrouptype.service_group_desc}}
                                                </option>
                                            </select2>
                                        </template>
                                        <template v-slot:cell(service_fee)="data">
                                            <vue-autonumeric 
                                                :class="'form-control text-right'"
                                                v-model="data.item.service_fee" 
                                                :options="{minimumValue: 0, modifyValueOnWheel: false, emptyInputBehavior: 0}">
                                            </vue-autonumeric>
                                        </template>
                                        <template v-slot:cell(action)="data">
                                            <b-btn :size="'sm'" variant="primary" @click="addItem()" >
                                                <i class="fa fa-plus-circle"></i>
                                            </b-btn>
                                            <b-btn :size="'sm'" variant="danger" @click="removeItem(data.index)">
                                                <i class="fa fa-times-circle"></i>
                                            </b-btn>
                                        </template>
                                    </b-table>
                                </b-col>
                            </b-row>
                        </b-form>
                        <template v-slot:footer>
                            <b-row class="pull-right mt-2">
                                <b-col sm="12">
                                    <b-button 
                                        :disabled="forms.service.isSaving" 
                                        variant="success"
                                        @click="onServiceEntry">
                                        <icon v-if="forms.service.isSaving" name="sync" spin></icon>
                                        <i class="fa fa-check"></i>
                                        Save
                                    </b-button>
                                    <b-button variant="danger" @click="showEntry=false">Close</b-button>
                                </b-col>
                            </b-row>
                        </template>

                    </b-card>
                </b-col>
            </b-row>
        </div>
        <serviceentry type="reference" ref="serviceentry"></serviceentry>
        <deleteentry entity="service" table="services" primary_key="service_id" ref="deleteentry"></deleteentry>
        <archiveentry type="archive" entity="service" table="services" primary_key="service_id" ref="archiveentry"></archiveentry>
    </div>
</template>

<script>
import serviceentry from '../modals/ServiceEntry'
import deleteentry from '../modals/DeleteEntry'
import archiveentry from '../modals/ArchiveEntry'
export default {
    name: 'services',
    components: {
        serviceentry,
        deleteentry,
        archiveentry
    },
    data () {
        return {
            entryMode: 'Add',
            showList: false,
            showEntry: false,
            showModalConfirmation: false,
            options: {
                servicestype: {
                    items: []
                },  
                servicesgrouptype: {
                    items: []
                },                
            },            
            tables: {
                services: {
                    fields:[
                        {
                            key:'service_code',
                            label: 'Service Code',
                            thStyle: {width: '15%'},
                            tdClass: 'align-middle',
                            sortable: true
                        },
                        {
                            key:'category_desc',
                            label: 'Category',
                            thStyle: {width: '20%'},
                            tdClass: 'align-middle',
                            sortable: true
                        },  
                        {
                            key:'service_type_desc',
                            label: 'Service Type',
                            thStyle: {width: '25%'},
                            tdClass: 'align-middle ellipsis',
                            sortable: true
                        },
                        {
                            key:'service_desc',
                            label: 'Description',
                            thStyle: {width: '25%'},
                            tdClass: 'align-middle ellipsis',
                            sortable: true
                        },       
                        {
                            key:'action',
                            label:'',
                            thStyle: {width: '15%'},
                            tdClass: 'text-center align-middle',
                        }
                    ],
                    items: []
                },
                service_items: {
                    fields: [
                        {
                            key: 'service_group_type_id',
                            label: 'Service Group Type',
                            thStyle: {width: '50%'},
                            tdClass: 'align-middle'
                        },
                        {
                            key: 'service_fee',
                            label: 'Fee',
                            tdClass: 'align-middle',
                            thStyle: {width: '40%'},
                        }, 
                        {
                            key:'action',
                            label:'',
                            thStyle: {width: '10%'},
                            tdClass: 'text-center align-middle',
                        }                         
                    ],
                    items: [
                        {
                            service_group_type_id: 1,
                            service_fee: 0.00
                        }
                    ]
                },              
            },
            forms: {
                service: {
                    isSaving: false,
                    fields: {
                        service_id : 0,
                        service_group_type_id : null,
                        service_code : null,
                        service_desc : null,
                        service_note : null,
                        category_id : null,
                        category_desc : null,
                        service_items: []
                    }
                }
            },
            filters: {
                services: {
                    criteria: null
                }
            },
            paginations: {
                services: {
                    totalRows: 0,
                    currentPage: 1,
                    perPage: 10
                }
            },
            is_check_all: 0,
            row: []
        }
    },
    methods:{
        setEntry(is_all){ 
            if(is_all){
                this.showModalConfirmation = true
            }
            else{
                this.showEntry = true
                this.entryMode='Add'
                this.tables.service_items.items=[]
                this.clearFields('service')
            }
        }, 
        addItem(){
            this.tables.service_items.items.push({
                service_group_type_id: 1,
                service_fee: 0.00
            })
        },
        removeItem(index){
            var rowCount = this.tables.service_items.items.length;
            if(rowCount  == 1){
                this.$notify({ type: 'error', group: 'notification', title: 'Error!',
                    text: 'Cannot Remove All Rows.'
                })
            }else{
                this.tables.service_items.items.splice(index, 1)
            }
        },    
        displayCategory: function (value, data){
            if(data.length > 0){
                var category = this.options.servicestype.items[data[0].element.index]
                this.forms.service.fields.category_desc = category.category_desc
            }
        },
        checkItem(index, value){
            if(value != 0){
                    var result = this.tables.service_items.items.filter(i => i.service_group_type_id == value);
                    if (result.length > 1){
                        this.tables['service_items'].items[index].service_group_type_id = 1;
                        this.$notify({ type: 'error', group: 'notification', title: 'Error!',
                            text: 'Type is already in the list.'
                        })    
                    }
            }
        },
        async onServiceEntry () {
            var result = this.tables.service_items.items.filter(i => i.service_fee == 0);
            if (result.length >= 1){
                this.$notify({ type: 'error', group: 'notification', title: 'Error!',
                    text: 'Service Fee must be greater than 0.'
                })    
            }else{
                this.forms.service.fields.service_items = this.tables.service_items.items
                if(this.entryMode == 'Add'){
                    await this.createEntity('service', false, 'services', true)
                }
                else{
                    await this.updateEntity('service', 'service_id', false, this.row)
                }
            }
        },  
        async setUpdate(data){

                this.row = data.item
                this.tables.service_items.items = []
                this.fillEntityForm('service', data.item.service_id)
            
                await this.$http.get('/api/service/items/'+ data.item.service_id,{
                headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then((response) => {
                    const res = response.data
                    this.tables.service_items.items = res.items 
                    this.forms.service.fields.category_desc = data.item.category_desc
                    this.showEntry=true
                    this.entryMode='Edit'
                })
                .catch(error => {
                if (!error.response) return
                console.log(error)
                })
        },        

    },
    created () {
        this.fillTableList('services'),
        this.fillOptionsList('servicestype'),
        this.fillOptionsList('servicesgrouptype')        
    },
    computed: {
        checkAction(){
            if(this.$store.state.rights.length > 0){
                if((this.checkRights('5-19') || this.checkRights('5-20')) == false){
                    this.tables.services.fields.pop()
                }
            }
            return true
        }
    },
    watch: {
        showEntry: function (showEntry) {
            if(showEntry){
                let self = this
                Vue.nextTick(function(){
                    // self.focusElement('tenant_id')
                })
            }
        },
    }
  }
</script>

