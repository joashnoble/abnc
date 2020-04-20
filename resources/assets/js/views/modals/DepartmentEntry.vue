<template>
    <div> <!-- modal div -->
        <b-modal 
            v-model="showModalEntry"
            :noCloseOnEsc="true"
            :noCloseOnBackdrop="true"
            @shown="focusElement('department_code')"
        >
        
            <div slot="modal-title"> <!-- modal title -->
                Department Entry - {{entryMode}}
            </div> <!-- modal title -->

            <b-col lg=12> <!-- modal body -->
                <b-form @keydown="resetFieldStates('department')" autocomplete="off">
                    <b-form-group>
                        <label class="required" for="department_code">Department Code</label>
                        <b-form-input
                            id="department_code"
                            v-model="forms.department.fields.department_code"
                            debounce="250"
                            type="text"
                            placeholder="Department Code"
                            ref="department_code">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group>
                        <label class="required">Department Desc</label>
                        <b-form-input
                            ref="department_desc"
                            id="department_desc"
                            v-model="forms.department.fields.department_desc"
                            debounce="250"
                            type="text"
                            placeholder="Department Description">
                        </b-form-input>
                    </b-form-group>
                </b-form>
            </b-col> <!-- modal body -->

            <div slot="modal-footer"><!-- modal footer buttons -->
                <b-button :disabled="forms.department.isSaving" variant="success" @click="onDepartmentEntry">
                    <icon v-if="forms.department.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Save
                </b-button>
                <b-button variant="danger" @click="showModalEntry=false">Close</b-button>
            </div> <!-- modal footer buttons -->

        </b-modal>
    </div> <!-- modal div -->
</template>
<script>
export default {
    name: 'departmententry',
    props: ['type'],
    data() {
        return {
            entryMode: 'Add',
            showModalEntry: false,
            forms:{
                department : {
                    isSaving: false,
                    fields: {
                        department_id: null,
                        department_code: null,
                        department_desc: null,
                        signatory_1: null,
                        signatory_1_position: null,
                        signatory_2: null,
                        signatory_2_position: null,
                        signatory_3: null,
                        signatory_3_position: null,
                        start_day: 1,
                        end_day: 1,
                        is_same: 0,
                        cut_off_day: 1,
                        department_address: null
                    }
                }
            },
            row: []
        }
    },
    methods:{
        onDepartmentEntry () {
            if(this.type == 'reference'){
                if(this.entryMode == 'Add'){
                    this.$parent.createEntityRef('department', true, 'departments', 'departmententry')
                }
                else{
                    this.$parent.updateEntityRef('department', 'department_id', true, this.row, 'departmententry')
                }
            }
            else{
                this.$parent.createOptionsEntityRef('department', 'showModalEntry', 'departments', this.type, 'department_id', 'departmententry')
            }
        },
        setCreate(){
            this.entryMode='Add'
            this.clearFields('department')
            this.forms.department.fields.start_day = 1
            this.forms.department.fields.end_day = 1
            this.forms.department.fields.cut_off_day = 1
            this.forms.department.fields.is_same = 1
            this.showModalEntry = true
        },
        setUpdate(data){
            this.row = data.item
            this.resetFieldStates('department')
            this.fillEntityForm('department', data.item.department_id, 'showModalEntry')
            this.entryMode='Edit'
        }
    },
}
</script>