<template>
    <div>
        <b-modal 
            v-model="showModalArchive"
            :noCloseOnEsc="true"
            :noCloseOnBackdrop="true"
        >
            <div slot="modal-title">
                <i class="fa fa-archive" style="color: red;"></i> {{capitalize(type)}} {{capitalize(entity)}}
            </div>
            <b-col lg=12>
                Are you sure you want to {{type.toLowerCase()}} this {{entity.toLowerCase()}}?
            </b-col>
            <div slot="modal-footer">
                <b-button :disabled="isSaving" variant="success" @click="onArchiveEntry">
                    <icon v-if="isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Accept
                </b-button>
                <b-button variant="danger" @click="showModalArchive=false">Close</b-button>            
            </div>
        </b-modal>
    </div>
</template>
<script>
export default {
    name: 'archiveentry',
     props: {
      entity: {
        type: String
      },
      primary_key: {
        type: String
      },
      table: {
        type: String
      },
      type: {
        type: String
      },
      check_for_foreign_key: {
        //check if needed to check relationship to other tables
        type: Boolean,
        default: true 
      }
    },
    data() {
      return {
        showModalArchive: false,
        isSaving: false,
        ref_id: null,
        is_active: null
      }
    },
    methods: {
      onArchiveEntry(){
        this.$parent.archiveEntityRef(this.entity.split(" ").join("").toLowerCase(), this.ref_id, true, this.table, this.primary_key, 'archiveentry', this.is_active, this.type)
      },
      async setArchive(id,active){
        if (this.check_for_foreign_key) {
          if(await this.checkIfUsed(this.entity.split(" ").join("").toLowerCase(), id) == true){
            this.$notify({
              type: 'error',
              group: 'notification',
              title: 'Error!',
              text: "Unable to archive, this record is being used by other transactions."
            })
            return
          }
        }
        
        this.ref_id = id
        this.is_active = active
        this.showModalArchive = true
      },
    }
}
</script>