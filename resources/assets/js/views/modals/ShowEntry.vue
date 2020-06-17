<template>
    <div>
        <b-modal 
            v-model="showModalVisible"
            :noCloseOnEsc="true"
            :noCloseOnBackdrop="true"
        >
            <div slot="modal-title">
                <i :class="icon"></i> {{capitalize(content)}}
            </div>
            <b-col lg=12>
                Are you sure you want to {{type}} this {{content}}?
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
            icon: null,
            type: null,
            content: null,
            active: null,
            row: [],
        }
    },
    methods: {
        onVisibleEntry(){
            this.$parent.activateEntityRef(this.entity.split(" ").join("").toLowerCase(), this.ref_id, true, this.table, this.primary_key, 'showentry', this.status, this.type, this.row)
        },
        setVisible(data,id,status,type,content){
            this.ref_id = id
            this.status = status
            this.type = type
            this.content = content
            this.row = data.item

            if(status == 1){
                this.icon = "fa fa-eye"
            }else{
                this.icon = "fa fa-eye-slash"
            }

            this.showModalVisible = true
        },
    }
}
</script>