<template>
    <b-modal 
        v-model="showModalEntry"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('service_group_code')"
    >
        <div slot="modal-title">
            Service Group Type Entry - {{entryMode}}
        </div>
        <b-col lg=12>
            <b-form @keydown="resetFieldStates('servicegrouptype')" autocomplete="off">
                <b-form-group>
                    <label class="required" for="service_group_code">Code</label>
                    <b-form-input
                        ref="service_group_code"
                        id="service_group_code"
                        v-model="forms.servicegrouptype.fields.service_group_code"
                        debounce="250"
                        type="text"
                        placeholder="Service Group Type Code">
                    </b-form-input>
                </b-form-group>
                <b-form-group>
                    <label class="required">Service Group Type</label>
                    <b-form-input
                        ref="service_group_desc"
                        id="service_group_desc"
                        v-model="forms.servicegrouptype.fields.service_group_desc"
                        debounce="250"
                        type="text"
                        placeholder="Service Group Type">
                    </b-form-input>
                </b-form-group>
            </b-form>
        </b-col>
        <div slot="modal-footer">
            <b-button :disabled="forms.servicegrouptype.isSaving" variant="success" @click="onServiceGroupTypeEntry">
                <icon v-if="forms.servicegrouptype.isSaving" name="sync" spin></icon>
                <i class="fa fa-check"></i>
                Save
            </b-button>
            <b-button variant="danger" @click="showModalEntry=false">Close</b-button>            
        </div>
    </b-modal>
</template>
<script>
export default {
    name: 'servicegrouptypeentry',
    props: ['type'],
    data() {
        return {
            entryMode: 'Add',
            showModalEntry: false, //if true show modal
            forms: {
                servicegrouptype : {
                    isSaving: false,
                    fields: {
                        service_group_type_id: null,
                        service_group_code: null,
                        service_group_desc: null
                    }
                }
            },
            row: []
        }
    },
    methods:{
        onServiceGroupTypeEntry () {
            if(this.type == 'reference'){
                if(this.entryMode == 'Add'){
                    this.$parent.createEntityRef('servicegrouptype', true, 'servicesgrouptype', 'servicegrouptypeentry')
                }
                else{
                    this.$parent.updateEntityRef('servicegrouptype', 'service_group_type_id', true, this.row, 'servicegrouptypeentry')
                }
            }
            else{
                this.$parent.createOptionsEntityRef('servicegrouptype', 'showModalEntry', 'servicesgrouptype', this.type, 'service_group_type_id', 'servicegrouptypeentry')
            }
        },
        setUpdate(data){
            this.row = data.item
            this.fillEntityForm('servicegrouptype', data.item.service_group_type_id, 'showModalEntry')
            this.entryMode='Edit'
        }
    },
}
</script>