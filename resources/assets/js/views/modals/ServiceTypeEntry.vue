<template>
    <b-modal 
        v-model="showModalEntry"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('service_type_code')"
    >
        <div slot="modal-title">
            Service Type Entry - {{entryMode}}
        </div>
        <b-col lg=12>
            <b-form @keydown="resetFieldStates('servicetype')" autocomplete="off">
                <b-form-group>
                    <label class="required" for="service_type_code">Code</label>
                    <b-form-input
                        ref="service_type_code"
                        id="service_type_code"
                        v-model="forms.servicetype.fields.service_type_code"
                        debounce="250"
                        type="text"
                        placeholder="Service Type Code">
                    </b-form-input>
                </b-form-group>
                <b-form-group>
                    <label class="required">Service Type</label>
                    <b-form-input
                        ref="service_type_desc"
                        id="service_type_desc"
                        v-model="forms.servicetype.fields.service_type_desc"
                        debounce="250"
                        type="text"
                        placeholder="Service Type">
                    </b-form-input>
                </b-form-group>
            </b-form>
            <b-form-group>
                <label class="required">Service Category</label>
                <select2
                    ref="category_id"
                    :allowClear="false"
                    :placeholder="'Select Category'"
                    v-model="forms.servicetype.fields.category_id">
                        <option v-for="categories in options.categories.items" :key="categories.category_id" :value="categories.category_id">{{categories.category_desc}}</option>
                </select2>
            </b-form-group>
            <b-form-group>
                <label class="required">Service Select Type</label>
                <select2
                    ref="select_type_id"
                    :allowClear="false"
                    :placeholder="'Select Select Type'"
                    v-model="forms.servicetype.fields.select_type_id">
                        <option v-for="servicesselecttype in options.servicesselecttype.items" :key="servicesselecttype.select_type_id" :value="servicesselecttype.select_type_id">{{servicesselecttype.select_type}}</option>
                </select2>
            </b-form-group> 
        </b-col>
        <div slot="modal-footer">
            <b-button :disabled="forms.servicetype.isSaving" variant="success" @click="onServiceTypeEntry">
                <icon v-if="forms.servicetype.isSaving" name="sync" spin></icon>
                <i class="fa fa-check"></i>
                Save
            </b-button>
            <b-button variant="danger" @click="showModalEntry=false">Close</b-button>            
        </div>
    </b-modal>
</template>
<script>
export default {
    name: 'servicetypeentry',
    props: ['type'],
    data() {
        return {
            entryMode: 'Add',
            showModalEntry: false, //if true show modal
            options: {
                categories: {
                    items: []
                },        
                servicesselecttype: {
                    items: []
                },          
            }, 
            forms: {
                servicetype : {
                    isSaving: false,
                    fields: {
                        service_type_id: null,
                        service_type_code: null,
                        service_type_desc: null,
                        select_type_id:0,
                        category_id: 0
                    }
                }
            },
            row: []
        }
    },
    methods:{
        onServiceTypeEntry () {
            if(this.type == 'reference'){
                if(this.entryMode == 'Add'){
                    this.$parent.createEntityRef('servicetype', true, 'servicestype', 'servicetypeentry')
                }
                else{
                    this.$parent.updateEntityRef('servicetype', 'service_type_id', true, this.row, 'servicetypeentry')
                }
            }
            else{
                this.$parent.createOptionsEntityRef('servicetype', 'showModalEntry', 'servicestype', this.type, 'service_type_id', 'servicetypeentry')
            }
        },
        setUpdate(data){
            this.row = data.item
            this.fillEntityForm('servicetype', data.item.service_type_id, 'showModalEntry')
            this.entryMode='Edit'
        }
    },
    created(){
        this.fillOptionsList('categories'),
        this.fillOptionsList('servicesselecttype')
    }    
}
</script>