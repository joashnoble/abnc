<template>
    <b-modal 
        v-model="showModalEntry"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('csr_title')"
    >
        <div slot="modal-title">
            CSR Entry - {{entryMode}}
        </div>
        <b-col lg=12>
            <b-form @keydown="resetFieldStates('csr')" autocomplete="off">
                <b-form-group>
                    <label class="required" for="csr_title">Title</label>
                    <b-form-input
                        ref="csr_title"
                        id="csr_title"
                        v-model="forms.csr.fields.csr_title"
                        debounce="250"
                        type="text"
                        placeholder="Title">
                    </b-form-input>
                </b-form-group>
                <b-form-group>
                    <label class="required">Description</label>
                    <b-form-input
                        ref="csr_text"
                        id="csr_text"
                        v-model="forms.csr.fields.csr_text"
                        debounce="250"
                        type="text"
                        placeholder="Description">
                    </b-form-input>
                </b-form-group>
            </b-form>
        </b-col>
        <div slot="modal-footer">
            <b-button :disabled="forms.csr.isSaving" variant="success" @click="onCSREntry">
                <icon v-if="forms.csr.isSaving" name="sync" spin></icon>
                <i class="fa fa-check"></i>
                Save
            </b-button>
            <b-button variant="danger" @click="showModalEntry=false">Close</b-button>            
        </div>
    </b-modal>
</template>
<script>
export default {
    name: 'csrentry',
    props: ['type'],
    data() {
        return {
            entryMode: 'Add',
            showModalEntry: false, //if true show modal
            forms: {
                csr : {
                    isSaving: false,
                    fields: {
                        csr_id: null,
                        csr_title: null,
                        csr_text: null
                    }
                }
            },
            row: []
        }
    },
    methods:{
        onCSREntry () {
            if(this.type == 'reference'){
                if(this.entryMode == 'Add'){
                    this.$parent.createEntityRef('csr', true, 'csrs', 'csrentry')
                }
                else{
                    this.$parent.updateEntityRef('csr', 'csr_id', true, this.row, 'csrentry')
                }
            }
            else{
                this.$parent.createOptionsEntityRef('csr', 'showModalEntry', 'csrs', this.type, 'csr_id', 'csrentry')
            }
        },
        setUpdate(data){
            this.row = data.item
            this.fillEntityForm('csr', data.item.csr_id, 'showModalEntry')
            this.entryMode='Edit'
        }
    },
}
</script>