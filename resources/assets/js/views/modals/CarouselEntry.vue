<template>
    <b-modal 
        v-model="showModalEntry"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('carousel_desc')"
    >
        <div slot="modal-title">
            Carousel Entry - {{entryMode}}
        </div>
        <b-col lg=12>
            <b-form @keydown="resetFieldStates('carousel')" autocomplete="off">
                <b-form-group>
                    <label class="required" for="carousel_desc">Description</label>
                    <b-form-textarea
                        tab="0"
                        ref="carousel_desc"
                        id="carousel_desc"
                        v-model="forms.carousel.fields.carousel_desc"
                        debounce="250"
                        type="text"
                        :rows="3"
                        placeholder="Description">
                    </b-form-textarea>
                </b-form-group>
                <b-form-group>
                    <label class="required">Upload Image</label>
                    <b-row>
                        <b-col lg=12>
                            <div class="border" style="height: 250px; width: 100%">
                                <b-img :src="forms.carousel.fields.carousel_image_path" v-model="forms.carousel.fields.carousel_image_path" 
                        ref="carousel_image_path"
                        id="carousel_image_path" style="width:100%" height="250px"/>
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
                            <b-btn variant="danger" style="width:100%" @click="$refs.file.reset(), forms.carousel.fields.carousel_image_path = 'uploads/gallery/default.jpg'">
                                <i class="fa fa-times"></i> Remove
                            </b-btn>
                        </b-col>
                    </b-row>
                </b-form-group>
            </b-form>
        </b-col>
        <div slot="modal-footer">
            <b-button :disabled="forms.carousel.isSaving" variant="success" @click="onCarouselEntry">
                <icon v-if="forms.carousel.isSaving" name="sync" spin></icon>
                <i class="fa fa-check"></i>
                Save
            </b-button>
            <b-button variant="danger" @click="showModalEntry=false">Close</b-button>            
        </div>
    </b-modal>
    <!-- <departmententry type="reference" ref="departmententry"></departmententry> -->
</template>
<script>
export default {
    name: 'carouselentry',
    props: ['type'],
    data() {
        return {
            entryMode: 'Add',
            showModalEntry: false, //if true show modal   
            forms: {
                carousel : {
                    isSaving: false,
                    fields: {
                        carousel_id: null,
                        carousel_desc: null,
                        carousel_image_path: null,
                        id: null
                    }
                }
            },
            image: new FormData,
            row: [],
            url: null,
        }
    },
    methods:{
        onCarouselEntry () {
            if(this.type == 'reference'){
                if(this.entryMode == 'Add'){
                    this.$parent.createEntityRef('carousel', true, 'carousels', 'carouselentry')
                }
                else{
                    this.$parent.updateEntityRef('carousel', 'carousel_id', true, this.row, 'carouselentry')
                }
            }
            else{
                this.$parent.createOptionsEntityRef('carousel', 'showModalEntry', 'carousels', this.type, 'carousel_id', 'carouselentry')
            }
        },
        setUpdate(data){
            this.row = data.item
            this.fillEntityForm('carousel', data.item.carousel_id, 'showModalEntry')
            this.entryMode='Edit'
        },
        fieldChange(e){

            let attachment = e.target.files[0]
            let path = 'uploads/carousel'

            this.image.append('file', attachment)
            this.image.append('path', path)
            this.image.append('id', this.forms.carousel.fields.id)

            this.$http.post('/api/gallery/upload', this.image, {
                headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token'),
                      'Content-Type' : 'multipart/form-data'
                  }
            })
            .then((response) => {
                this.forms.carousel.fields.carousel_image_path = response.data.path
            })
            .catch(error => {
              if (!error.response) return
              console.log(error)
            })
        },      
    }
}
</script>