<template>
    <div v-show="showEntry" class="animated fadeIn">
        <b-row>
            <b-col sm="12">
                <b-card class="card-accent-dark">
                    <h5 slot="header">
                        <span>
                            Seminar Entry - <small>{{entryMode}}</small>
                        </span>
                    </h5>   
                    <b-form @keydown="resetFieldStates('seminar')" autocomplete="off">
                        <b-row>
                            <b-col sm=4>
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
                                    <label class="required">Speaker</label>
                                    <b-form-input
                                        ref="speaker_fullname"
                                        id="speaker_fullname"
                                        v-model="forms.seminar.fields.speaker_fullname"
                                        debounce="250"
                                        type="text"
                                        placeholder="Speaker Name">
                                    </b-form-input>
                                </b-form-group>
                                <b-form-group>
                                    <label>Position</label>
                                    <b-form-input
                                        ref="speaker_position"
                                        id="speaker_position"
                                        v-model="forms.seminar.fields.speaker_position"
                                        debounce="250"
                                        type="text"
                                        placeholder="Position">
                                    </b-form-input>
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
                                        <b-col lg=8>
                                            <b-form-group>
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
                                            </b-form-group>
                                        </b-col>
                                        <b-col lg=4>
                                            <b-form-group>
                                                <label>Sort</label>
                                                <vue-autonumeric 
                                                    ref="sort_id"
                                                    v-model="forms.seminar.fields.sort_id"
                                                    :class="'form-control text-right'" 
                                                    :options="{minimumValue: 0, 
                                                        modifyValueOnWheel: false, 
                                                        emptyInputBehavior: 0,
                                                        decimalPlaces: 0}">
                                                </vue-autonumeric>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </b-form-group>
                                <b-form-group>
                                    <b-row>
                                        <b-col lg=6>
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
                                        <b-col lg=6>
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
                                <b-form-group>
                                    <b-row>
                                        <b-col lg=12>
                                            <label>Cover Image</label>
                                            <div class="border" style="height: 200px; width: 100%">
                                                <b-img 
                                                    :src="forms.seminar.fields.gallery_file_path" 
                                                    v-model="forms.seminar.fields.gallery_file_path" 
                                                    ref="gallery_file_path"
                                                    id="gallery_file_path" 
                                                    style="width:100%"
                                                    height="200px"/>
                                            </div>
                                            <br>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col lg=12>
                                            <b-form-file @change="fieldChange" ref="file" accept=".jpg, .png, .gif" plain style="display: none;"></b-form-file>
                                            <b-btn variant="info" style="width:49%" @click="$refs.file.$el.click()">
                                                <i class="fa fa-file-image-o"></i> Browse
                                            </b-btn>
                                            <b-btn variant="danger" style="width:49%" @click="$refs.file.reset(), forms.seminar.fields.gallery_file_path = 'uploads/gallery/default.jpg'">
                                                <i class="fa fa-times"></i> Remove
                                            </b-btn>
                                        </b-col>
                                    </b-row>
                                </b-form-group>
                            </b-col>
                            <b-col sm=8>
                                <b-form-group>
                                    <label class="required">Description</label>
                                    <ckeditor v-model="forms.seminar.fields.seminar_description" :config="editorConfig"></ckeditor>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-form>
                    <template v-slot:footer>
                        <b-row class="pull-right mt-2">
                            <b-col sm="12">
                                <b-button 
                                    :disabled="forms.seminar.isSaving" 
                                    variant="success"
                                    @click="onSeminarEntry">
                                    <icon v-if="forms.seminar.isSaving" name="sync" spin></icon>
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
</template>
<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    name: 'seminarentry',
    components: {
        vueDropzone: vue2Dropzone
    },      
    props: ['type'],
    data() {
        return {
            entryMode: 'Add',
            showEntry: false, //if true show modal
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
                        seminar_venue: null,
                        gallery_file_path: null,
                        gallery_file_paths: null,
                        id: null,
                        sort_id: null
                    }
                }
            },
            image: new FormData,
            row: [],
            editorConfig: {
                toolbar: [ [ 'Bold','Italic','BulletedList','NumberedList' ] ],
                height: '355px'
            },
            url: null,
            dropzoneOptions: {
                url: '/api/formSubmit',
                thumbnailWidth: 150,
                maxFilesize: 0.5,
                addRemoveLinks: true,
                headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }                
            },   
        }
    },
    methods:{
        onSeminarEntry () {
            if(this.type == 'reference'){
                if(this.entryMode == 'Add'){
                    this.$parent.createEntityRef('seminar', false, 'seminars', 'seminarentry')
                }
                else{
                    this.$parent.updateEntityRef('seminar', 'seminar_id', false, this.row, 'seminarentry')
                }
            }
            else{
                this.$parent.createOptionsEntityRef('seminar', 'showModalEntry', 'seminars', this.type, 'seminar_id', 'seminarentry')
            }
        },
        setUpdate(data){
            this.row = data.item
            this.fillEntityForm('seminar', data.item.seminar_id, 'showEntry')
            this.entryMode='Edit'
        },
        fieldChange(e){

            let attachment = e.target.files[0]
            let path = 'uploads/gallery'

            this.image.append('file', attachment)
            this.image.append('path', path)
            this.image.append('id', this.forms.seminar.fields.id)

            this.$http.post('/api/gallery/upload', this.image, {
                headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token'),
                      'Content-Type' : 'multipart/form-data'
                  }
            })
            .then((response) => {
                this.forms.seminar.fields.gallery_file_path = response.data.path
            })
            .catch(error => {
              if (!error.response) return
              console.log(error)
            })
        },
        setEntry(){ 
            this.clearFields('seminar')
            this.entryMode='Add'
            this.showEntry = true
            this.forms.seminar.fields.gallery_file_path = 'uploads/gallery/default.jpg'
        }
    },
    watch: {
        showEntry: function (showEntry) {
            if(showEntry){
                let self = this
                Vue.nextTick(function(){
                    self.focusElement('seminar_title')
                })
            }
        },
    },
}
</script>