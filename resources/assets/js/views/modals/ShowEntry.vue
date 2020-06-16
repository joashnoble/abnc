<template>
    <div>
        <b-modal 
            v-model="showModalVisible"
            :noCloseOnEsc="true"
            :noCloseOnBackdrop="true"
        >
            <div slot="modal-title">
                <i class="{{ icon }}" style="color: red;"></i> {{capitalize(type)}} {{capitalize(entity)}}
            </div>
            <b-col lg=12>
                Are you sure you want to {{type.toLowerCase()}} this {{entity.toLowerCase()}}?
            </b-col>
            <div slot="modal-footer">
                <b-button :disabled="isSaving" variant="success" @click="onVisibleEntry">
                    <icon v-if="isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Accept
                </b-button>
                <b-button variant="danger" @click="showModalVisible=false">Close</b-button>            
            </div>
        </b-modal>
    </div>
</template>
<script>
export default {
    name: 'showentry',
    props: ['entity','primary_key','table'],
    data() {
        return {
            showModalVisible: false,
            isSaving: false,
            ref_id: null,
            icon: null
        }
    },
    methods: {
        onVisibleEntry(){
            this.$parent.archiveEntityRef(this.entity.split(" ").join("").toLowerCase(), this.ref_id, true, this.table, this.primary_key, 'archiveentry', this.is_active, this.type)
        },
        setVisible(id,status){
            this.ref_id = id
            this.status = status
            if(status == true){
                this.icon = "fa fa-eye"
            }else{
                this.icon = "fa fa-eye-slash"
            }

            this.showModalVisible = true
        },
    }
}
</script>