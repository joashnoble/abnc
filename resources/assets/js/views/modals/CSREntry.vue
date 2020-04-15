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
                <b-form-group>
                    <label class="required">Upload Cover Image</label>
                    <b-row>
                        <b-col lg=12>
                            <div class="border" style="height: 200px; width: 100%">
                                <b-img :src="forms.csr.fields.gallery_file_path" v-model="forms.csr.fields.gallery_file_path" 
                        ref="gallery_file_path"
                        id="gallery_file_path" style="width:100%" height="200px"/>
                            </div>
                            <br>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col lg=6>
                            <b-form-file @change="fieldChange" ref="file" accept=".jpg, .png, .gif" plain style="display: none;"></b-form-file>
                            <b-btn variant="success" style="width:100%" @click="$refs.file.$el.click()">
                                <i class="fa fa-file-image-o"></i> Browse
                            </b-btn>
                        </b-col>
                        <b-col lg=6>
                            <b-btn variant="danger" style="width:100%" @click="$refs.file.reset(), forms.csr.fields.gallery_file_path = 'uploads/gallery/default.jpg'">
                                <i class="fa fa-times"></i> Remove
                            </b-btn>
                        </b-col>
                    </b-row>
                    <br>
                    <b-row>
                        <b-col lg=12>
                            <vue-dropzone ref="myVueDropzone" id="dropzone" v-model="forms.csr.fields.gallery_file_paths" :options="dropzoneOptions"></vue-dropzone>
                        </b-col>
                    </b-row>
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

import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    name: 'csrentry',
    components: {
        vueDropzone: vue2Dropzone
    },        
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
                        csr_text: null,
                        gallery_file_path: null,
                        gallery_file_paths: null,
                        id: null
                    }
                }
            },
            image: new FormData,
            row: [],
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
        },
        fieldChange(e){

            let attachment = e.target.files[0]
            let path = 'uploads/gallery'

            this.image.append('file', attachment)
            this.image.append('path', path)
            this.image.append('id', this.forms.csr.fields.id)

            this.$http.post('/api/gallery/upload', this.image, {
                headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token'),
                      'Content-Type' : 'multipart/form-data'
                  }
            })
            .then((response) => {
                this.forms.csr.fields.gallery_file_path = response.data.path
            })
            .catch(error => {
              if (!error.response) return
              console.log(error)
            })
        }
    },
}
</script>