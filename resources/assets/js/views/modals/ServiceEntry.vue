
<template>
    <b-modal 
        v-model="showModalEntry"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('service_code')"
    >
        <div slot="modal-title">
            Service Entry - {{entryMode}}
        </div>
        <b-col lg=12>
            <b-form @keydown="resetFieldStates('service')" autocomplete="off">
                <b-form-group>
                    <label class="required" for="service_code">Service Code</label>
                    <b-form-input
                        ref="service_code"
                        id="service_code"
                        v-model="forms.service.fields.service_code"
                        debounce="250"
                        type="text"
                        placeholder="Service Code">
                    </b-form-input>
                </b-form-group>
                <b-form-group>
                    <label class="required">Service Desc</label>
                    <b-form-input
                        ref="service_desc"
                        id="service_desc"
                        v-model="forms.service.fields.service_desc"
                        debounce="250"
                        type="text"
                        placeholder="Service Description">
                    </b-form-input>
                </b-form-group>
                <b-form-group>
                    <label class="required">Service Category</label>
                    <select2
                        ref="category_id"
                        :allowClear="false"
                        :placeholder="'Select Category'"
                        v-model="forms.service.fields.category_id">
                            <option v-for="categories in options.categories.items" :key="categories.category_id" :value="categories.category_id">{{categories.category_desc}}</option>
                    </select2>
                </b-form-group>
                <b-form-group>
                    <label class="required">Service Type</label>
                    <select2
                        ref="service_type_id"
                        :allowClear="false"
                        :placeholder="'Select Type'"
                        v-model="forms.service.fields.service_type_id">
                            <option v-for="servicestype in options.servicestype.items" :key="servicestype.service_type_id" :value="servicestype.service_type_id">{{servicestype.service_type_desc}}</option>
                    </select2>
                </b-form-group>    
                <b-form-group>
                    <b-row>
                        <b-col lg=6>
                            <label class="required">Service Amount</label>
                            <vue-autonumeric 
                                ref="service_amount"
                                v-model="forms.service.fields.service_amount"
                                :class="'form-control text-right'" 
                                :options="{minimumValue: 0, modifyValueOnWheel: false, emptyInputBehavior: 0}">
                            </vue-autonumeric>
                        </b-col>
                    </b-row>
                </b-form-group>            
            </b-form>
        </b-col>
        <div slot="modal-footer">
            <b-button :disabled="forms.service.isSaving" variant="success" @click="onServiceEntry">
                <icon v-if="forms.service.isSaving" name="sync" spin></icon>
                <i class="fa fa-check"></i>
                Save
            </b-button>
            <b-button variant="danger" @click="showModalEntry=false">Close</b-button>            
        </div>
    </b-modal>
</template>
<script>
export default {
    name: 'serviceentry',
    props: ['type'],
    data() {
        return {
            entryMode: 'Add',
            showModalEntry: false, //if true show modal
            options: {
                categories: {
                    items: []
                },
                servicestype: {
                    items: []
                },                
            },
            forms: {
                service : {
                    isSaving: false,
                    fields: {
                        service_id: null,
                        service_code: null,
                        service_desc: null,
                        category_id: 0,
                        service_type_id: 0,
                        service_amount: 0
                    }
                }
            },
            row: []
        }
    },
    methods:{
        onServiceEntry () {
            if(this.type == 'reference'){
                if(this.entryMode == 'Add'){
                    this.$parent.createEntityRef('service', true, 'services', 'serviceentry')
                }
                else{
                    this.$parent.updateEntityRef('service', 'service_id', true, this.row, 'serviceentry')
                }
            }
            else{
                this.$parent.createOptionsEntityRef('service', 'showModalEntry', 'services', this.type, 'service_id', 'serviceentry')
            }
        },
        setUpdate(data){
            this.row = data.item
            this.fillEntityForm('service', data.item.service_id, 'showModalEntry')
            this.entryMode='Edit'
        }
    },
    created(){
        this.fillOptionsList('categories'),
        this.fillOptionsList('servicestype')
    }    
}
</script>