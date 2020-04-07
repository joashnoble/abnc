<template>
    <b-modal 
        v-model="showModalEntry"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('seminar_title')"
    >
        <div slot="modal-title">
            Seminar Entry - {{entryMode}}
        </div>
        <b-col lg=12>
            <b-form @keydown="resetFieldStates('seminar')" autocomplete="off">
                <b-form-group>
                    <label class="required" for="seminar_title">Seminar Title</label>
                    <b-form-input
                        ref="seminar_title"
                        id="seminar_title"
                        v-model="forms.seminar.fields.seminar_title"
                        debounce="250"
                        type="text"
                        placeholder="Seminar Title">
                    </b-form-input>
                </b-form-group>
                <b-form-group>
                    <label class="required">Seminar Desc</label>
                    <b-form-textarea
                        tab="0"
                        ref="seminar_description"
                        id="seminar_description"
                        v-model="forms.seminar.fields.seminar_description"
                        debounce="250"
                        type="text"
                        :rows="2"
                        placeholder="Seminar Description">
                    </b-form-textarea>
                </b-form-group>
                <b-form-group>
                    <b-row>
                        <b-col lg=6>
                            <label class="required">Speaker</label>
                            <b-form-input
                                ref="speaker_fullname"
                                id="speaker_fullname"
                                v-model="forms.seminar.fields.speaker_fullname"
                                debounce="250"
                                type="textarea"
                                placeholder="Speaker Name">
                            </b-form-input>
                        </b-col>
                        <b-col lg=6>
                            <label>Position</label>
                            <b-form-input
                                ref="speaker_position"
                                id="speaker_position"
                                v-model="forms.seminar.fields.speaker_position"
                                debounce="250"
                                type="text"
                                placeholder="Position">
                            </b-form-input>
                        </b-col>
                    </b-row>

                </b-form-group>
                <b-form-group>
                    <label class="required">Venue</label>
                    <b-form-textarea
                        tab="0"
                        ref="seminar_venue"
                        id="seminar_venue"
                        v-model="forms.seminar.fields.seminar_venue"
                        debounce="250"
                        type="text"
                        :rows="2"
                        placeholder="Seminar Venue">
                    </b-form-textarea>
                </b-form-group>   
                <b-form-group>
                    <b-row>
                        <b-col lg=6>
                            <label class="required">Date</label>
                            <date-picker 
                                ref="seminar_date"
                                id="seminar_date"
                                v-model="forms.seminar.fields.seminar_date"
                                lang="en" 
                                input-class="form-control  "
                                format="MMMM DD, YYYY"
                                :clearable="false">
                            </date-picker>
                        </b-col>
                        <b-col lg=3>
                            <label class="required">Time From: </label>
                            <b-form-input
                                ref="seminar_time_from"
                                id="seminar_time_from"
                                v-model="forms.seminar.fields.seminar_time_from"
                                debounce="250"
                                type="text"
                                placeholder="From">
                            </b-form-input>
                        </b-col>
                        <b-col lg=3>
                            <label class="required">Time To: </label>
                            <b-form-input
                                ref="seminar_time_to"
                                id="seminar_time_to"
                                v-model="forms.seminar.fields.seminar_time_to"
                                debounce="250"
                                type="text"
                                placeholder="To">
                            </b-form-input>
                        </b-col>
                    </b-row>
                </b-form-group>                  
            </b-form>
        </b-col>
        <div slot="modal-footer">
            <b-button :disabled="forms.seminar.isSaving" variant="success" @click="onSeminarEntry">
                <icon v-if="forms.seminar.isSaving" name="sync" spin></icon>
                <i class="fa fa-check"></i>
                Save
            </b-button>
            <b-button variant="danger" @click="showModalEntry=false">Close</b-button>            
        </div>
    </b-modal>
</template>
<script>
export default {
    name: 'seminarentry',
    props: ['type'],
    data() {
        return {
            entryMode: 'Add',
            showModalEntry: false, //if true show modal
            forms: {
                seminar : {
                    isSaving: false,
                    fields: {
                        seminar_id: null,
                        seminar_title: null,
                        seminar_description: null,
                        speaker_fullname: null,
                        speaker_position: null,
                        seminar_date: null,
                        seminar_time_from: null,
                        seminar_time_to: null,
                        seminar_venue: null
                    }
                }
            },
            row: []
        }
    },
    methods:{
        onSeminarEntry () {
            if(this.type == 'reference'){
                if(this.entryMode == 'Add'){
                    this.$parent.createEntityRef('seminar', true, 'seminars', 'seminarentry')
                }
                else{
                    this.$parent.updateEntityRef('seminar', 'seminar_id', true, this.row, 'seminarentry')
                }
            }
            else{
                this.$parent.createOptionsEntityRef('seminar', 'showModalEntry', 'seminars', this.type, 'seminar_id', 'seminarentry')
            }
        },
        setUpdate(data){
            this.row = data.item
            this.fillEntityForm('seminar', data.item.seminar_id, 'showModalEntry')
            this.entryMode='Edit'
        }
    },
}
</script>