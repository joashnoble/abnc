<template>
    <b-modal 
        v-model="showModalEntry"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('industry_name')"
    >
        <div slot="modal-title">
            Industry Entry - {{entryMode}}
        </div>
        <b-col lg=12>
            <b-form @keydown="resetFieldStates('industry')" autocomplete="off">
                <b-form-group>
                    <label class="required" for="industry_name">Industry Name</label>
                    <b-form-input
                        ref="industry_name"
                        id="industry_name"
                        v-model="forms.industry.fields.industry_name"
                        debounce="250"
                        type="text"
                        placeholder="Industry Name">
                    </b-form-input>
                </b-form-group>
                <b-form-group>
                    <label>Industry Desc</label>
                    <b-form-input
                        ref="industry_desc"
                        id="industry_desc"
                        v-model="forms.industry.fields.industry_desc"
                        debounce="250"
                        type="text"
                        placeholder="Industry Description">
                    </b-form-input>
                </b-form-group>
            </b-form>
        </b-col>
        <div slot="modal-footer">
            <b-button :disabled="forms.industry.isSaving" variant="success" @click="onIndustryEntry">
                <icon v-if="forms.industry.isSaving" name="sync" spin></icon>
                <i class="fa fa-check"></i>
                Save
            </b-button>
            <b-button variant="danger" @click="showModalEntry=false">Close</b-button>            
        </div>
    </b-modal>
</template>
<script>
export default {
    name: 'industryentry',
    props: ['type'],
    data() {
        return {
            entryMode: 'Add',
            showModalEntry: false, //if true show modal
            forms: {
                industry : {
                    isSaving: false,
                    fields: {
                        industry_id: null,
                        industry_name: null,
                        industry_desc: null
                    }
                }
            },
            row: []
        }
    },
    methods:{
        onIndustryEntry () {
            if(this.type == 'reference'){
                if(this.entryMode == 'Add'){
                    this.$parent.createEntityRef('industry', true, 'industries', 'industryentry')
                }
                else{
                    this.$parent.updateEntityRef('industry', 'industry_id', true, this.row, 'industryentry')
                }
            }
            else{
                this.$parent.createOptionsEntityRef('industry', 'showModalEntry', 'industries', this.type, 'industry_id', 'industryentry')
            }
        },
        setUpdate(data){
            this.row = data.item
            this.fillEntityForm('industry', data.item.industry_id, 'showModalEntry')
            this.entryMode='Edit'
        }
    },
}
</script>