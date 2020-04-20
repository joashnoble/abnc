<template>
    <b-modal 
        v-model="showModalEntry"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('team_desc')"
    >
        <div slot="modal-title">
            Team Entry - {{entryMode}}
        </div>
        <b-col lg=12>
            <b-form @keydown="resetFieldStates('team')" autocomplete="off">
                <b-form-group>
                    <label class="required">Department</label>
                    <select2
                        ref="department_id"
                        :allowClear="false"
                        :placeholder="'Select Department'"
                        v-model="forms.team.fields.department_id"
                        :reference="'department'"
                        @input="isOptionCreating">
                            <!-- <option value="-1">Create New Department</option> -->
                            <option v-for="departments in options.departments.items" :key="departments.department_id" :value="departments.department_id">{{departments.department_desc}}</option>
                    </select2>
                </b-form-group>
                <b-form-group>
                    <label class="required" for="team_desc">Description</label>
                    <b-form-textarea
                        tab="0"
                        ref="team_desc"
                        id="team_desc"
                        v-model="forms.team.fields.team_desc"
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
                                <b-img :src="forms.team.fields.gallery_file_path" v-model="forms.team.fields.gallery_file_path" 
                        ref="gallery_file_path"
                        id="gallery_file_path" style="width:100%" height="250px"/>
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
                            <b-btn variant="danger" style="width:100%" @click="$refs.file.reset(), forms.team.fields.gallery_file_path = 'uploads/gallery/default.jpg'">
                                <i class="fa fa-times"></i> Remove
                            </b-btn>
                        </b-col>
                    </b-row>
                </b-form-group>
            </b-form>
        </b-col>
        <div slot="modal-footer">
            <b-button :disabled="forms.team.isSaving" variant="success" @click="onTeamEntry">
                <icon v-if="forms.team.isSaving" name="sync" spin></icon>
                <i class="fa fa-check"></i>
                Save
            </b-button>
            <b-button variant="danger" @click="showModalEntry=false">Close</b-button>            
        </div>
    </b-modal>
    <!-- <departmententry type="reference" ref="departmententry"></departmententry> -->
</template>
<script>
import departmententry from '../modals/DepartmentEntry'
export default {
    name: 'teamentry',
    components: {
        departmententry
    },    
    props: ['type'],
    data() {
        return {
            entryMode: 'Add',
            showModalEntry: false, //if true show modal
            options: {
                departments: {
                    items: []
                },             
            },            
            forms: {
                team : {
                    isSaving: false,
                    fields: {
                        team_id: null,
                        team_desc: null,
                        department_id : 0,
                        gallery_file_path: null,
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
        onTeamEntry () {
            if(this.type == 'reference'){
                if(this.entryMode == 'Add'){
                    this.$parent.createEntityRef('team', true, 'teams', 'teamentry')
                }
                else{
                    this.$parent.updateEntityRef('team', 'team_id', true, this.row, 'teamentry')
                }
            }
            else{
                this.$parent.createOptionsEntityRef('team', 'showModalEntry', 'teams', this.type, 'team_id', 'teamentry')
            }
        },
        setUpdate(data){
            this.row = data.item
            this.fillEntityForm('team', data.item.team_id, 'showModalEntry')
            this.entryMode='Edit'
        },
        fieldChange(e){

            let attachment = e.target.files[0]
            let path = 'uploads/gallery'

            this.image.append('file', attachment)
            this.image.append('path', path)
            this.image.append('id', this.forms.team.fields.id)

            this.$http.post('/api/gallery/upload', this.image, {
                headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token'),
                      'Content-Type' : 'multipart/form-data'
                  }
            })
            .then((response) => {
                this.forms.team.fields.gallery_file_path = response.data.path
            })
            .catch(error => {
              if (!error.response) return
              console.log(error)
            })
        },
        isOptionCreating: function(value, data, reference){
            if(value == -1){
                if(reference == 'department'){
                    this.$refs.departmententry.showModalEntry = true
                    this.$refs.departmententry.clearFields('department')
                    this.forms.contract.fields.department_id = 'null'
                }
            }
        },        
    },
    created(){
        this.fillOptionsList('departments')
    } 
}
</script>