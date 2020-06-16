<template>
    <div v-show="showEntry" class="animated fadeIn">
        <b-row>
            <b-col sm="12">
                <b-card class="card-accent-dark">
                    <h5 slot="header">
                        <span>
                            News &amp; Publication - <small>{{entryMode}}</small>
                        </span>
                    </h5>
                    <b-form @keydown="resetFieldStates('newspublication')" autocomplete="off">
                        <b-row>
                            <b-col lg=4>
                                <b-form-group>
                                    <label class="required" for="news_title">News Title</label>
                                    <b-form-input
                                        ref="news_title"
                                        id="news_title"
                                        v-model="forms.newspublication.fields.news_title"
                                        debounce="250"
                                        type="text"
                                        placeholder="News Title">
                                    </b-form-input>
                                </b-form-group>
                                <b-row>
                                    <b-col lg=8>
                                        <b-form-group>
                                            <label class="required">Publication Date</label>
                                            <date-picker 
                                                ref="news_publish_date"
                                                id="news_publish_date"
                                                v-model="forms.newspublication.fields.news_publish_date"
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
                                                v-model="forms.newspublication.fields.sort_id"
                                                :class="'form-control text-right'" 
                                                :options="{minimumValue: 0, 
                                                    modifyValueOnWheel: false, 
                                                    emptyInputBehavior: 0,
                                                    decimalPlaces: 0}">
                                            </vue-autonumeric>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-form-group>
                                    <label>Cover Image</label>
                                    <b-row>
                                        <b-col lg=12>
                                            <div class="border" style="height: 200px; width: 100%">
                                                <b-img :src="forms.newspublication.fields.gallery_file_path" v-model="forms.newspublication.fields.gallery_file_path" 
                                        ref="gallery_file_path"
                                        id="gallery_file_path" style="width:100%" height="200px"/>
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
                                            <b-btn variant="danger" style="width:49%" @click="$refs.file.reset(), forms.newspublication.fields.gallery_file_path = 'uploads/gallery/default.jpg'">
                                                <i class="fa fa-times"></i> Remove
                                            </b-btn>
                                        </b-col>
                                    </b-row>
                                </b-form-group>
                            </b-col>
                            <b-col lg=8>
                                <b-form-group>
                                    <label class="required">Description</label>
                                    <!-- <b-form-input
                                        ref="news_description"
                                        id="news_description"
                                        v-model="forms.newspublication.fields.news_description"
                                        debounce="250"
                                        type="text"
                                        placeholder="News Description">
                                    </b-form-input>
                                    -->
                                    <ckeditor v-model="forms.newspublication.fields.news_description" :config="editorConfig"></ckeditor>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-form>
                    <template v-slot:footer>
                        <b-row class="pull-right mt-2">
                            <b-col sm="12">
                                <b-button 
                                    :disabled="forms.newspublication.isSaving" 
                                    variant="success"
                                    @click="onNewsPublicationEntry">
                                    <icon v-if="forms.newspublication.isSaving" name="sync" spin></icon>
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
    name: 'newspublicationentry',
    components: {
        vueDropzone: vue2Dropzone
    },    
    props: ['type'],
    data() {
        return {
            entryMode: 'Add',
            showEntry: false, //if true show entry
            forms: {
                newspublication : {
                    isSaving: false,
                    fields: {
                        news_id: null,
                        news_title: null,
                        news_description: null,
                        news_publish_date: null,
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
                height: '325px'
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
        onNewsPublicationEntry () {
            if(this.type == 'reference'){
                if(this.entryMode == 'Add'){
                    this.$parent.createEntityRef('newspublication', false, 'newspublications', 'newspublicationentry')
                }
                else{
                    this.$parent.updateEntityRef('newspublication', 'news_id', false, this.row, 'newspublicationentry')
                }
            }
            else{
                this.$parent.createOptionsEntityRef('newspublication', 'showModalEntry', 'newspublications', this.type, 'news_id', 'newspublicationentry')
            }
        },
        setUpdate(data){
            this.row = data.item
            this.fillEntityForm('newspublication', data.item.news_id, 'showEntry')
            this.entryMode='Edit'
        },
        fieldChange(e){

            let attachment = e.target.files[0]
            let path = 'uploads/gallery'

            this.image.append('file', attachment)
            this.image.append('path', path)
            this.image.append('id', this.forms.newspublication.fields.id)

            this.$http.post('/api/gallery/upload', this.image, {
                headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token'),
                      'Content-Type' : 'multipart/form-data'
                  }
            })
            .then((response) => {
                this.forms.newspublication.fields.gallery_file_path = response.data.path
            })
            .catch(error => {
              if (!error.response) return
              console.log(error)
            })
        },
        setEntry(){ 
            this.clearFields('newspublication')
            this.entryMode='Add'
            this.showEntry = true
            this.forms.newspublication.fields.gallery_file_path = 'uploads/gallery/default.jpg'
        }
    },
    watch: {
        showEntry: function (showEntry) {
            if(showEntry){
                let self = this
                Vue.nextTick(function(){
                    self.focusElement('news_title')
                })
            }
        },
    },
}
</script>