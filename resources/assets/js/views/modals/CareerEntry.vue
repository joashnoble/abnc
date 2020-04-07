<template>
    <b-modal 
        v-model="showModalEntry"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('career_title')"
    >
        <div slot="modal-title">
            Career Entry - {{entryMode}}
        </div>
        <b-col lg=12>
            <b-form @keydown="resetFieldStates('career')" autocomplete="off">
                <b-form-group>
                    <label class="required" for="career_title">Career</label>
                    <b-form-input
                        ref="career_title"
                        id="career_title"
                        v-model="forms.career.fields.career_title"
                        debounce="250"
                        type="text"
                        placeholder="Career">
                    </b-form-input>
                </b-form-group>
                <b-form-group>
                    <label class="required">Career Desc</label>
                    <b-form-input
                        ref="career_description"
                        id="career_description"
                        v-model="forms.career.fields.career_description"
                        debounce="250"
                        type="text"
                        placeholder="Career Description">
                    </b-form-input>
                </b-form-group>
            </b-form>
        </b-col>
        <div slot="modal-footer">
            <b-button :disabled="forms.career.isSaving" variant="success" @click="onCareerEntry">
                <icon v-if="forms.career.isSaving" name="sync" spin></icon>
                <i class="fa fa-check"></i>
                Save
            </b-button>
            <b-button variant="danger" @click="showModalEntry=false">Close</b-button>            
        </div>
    </b-modal>
</template>
<script>
export default {
    name: 'careerentry',
    props: ['type'],
    data() {
        return {
            entryMode: 'Add',
            showModalEntry: false, //if true show modal
            forms: {
                career : {
                    isSaving: false,
                    fields: {
                        career_id: null,
                        career_title: null,
                        career_description: null
                    }
                }
            },
            row: []
        }
    },
    methods:{
        onCareerEntry () {
            if(this.type == 'reference'){
                if(this.entryMode == 'Add'){
                    this.$parent.createEntityRef('career', true, 'careers', 'careerentry')
                }
                else{
                    this.$parent.updateEntityRef('career', 'career_id', true, this.row, 'careerentry')
                }
            }
            else{
                this.$parent.createOptionsEntityRef('career', 'showModalEntry', 'careers', this.type, 'career_id', 'careerentry')
            }
        },
        setUpdate(data){
            this.row = data.item
            this.fillEntityForm('career', data.item.career_id, 'showModalEntry')
            this.entryMode='Edit'
        }
    },
}
</script>