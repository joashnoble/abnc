<template>
  <!--<b-animated fade-in>  main container -->
  <div>
    <notifications group="notification" />
    <div class="animated fadeIn">
      <b-row>
        <b-col sm="12">
          <b-card class="card-accent-dark">
            <h5 slot="header">
              <span>
                Archived News Publication
                <small class="font-italic">List of all archived news and publications.</small></span>
            </h5>
            <b-row class="mb-2">
              <b-col  sm=4 offset-sm=8>
                <b-input-group prepend-html='<i class="fa fa-search"></i> &nbsp; Search'>
                  <b-form-input 
                    v-model="filters.newspublication.criteria"
                    type="text" 
                    debounce="250">
                  </b-form-input>
                </b-input-group>
              </b-col>
            </b-row>
            <b-row>
              <b-col sm="12">
                <b-table 
                  v-if="checkAction"
                  responsive
                  :filter="filters.newspublication.criteria"
                  :fields="tables.newspublications.fields"
                  :items.sync="tables.newspublications.items"
                  :current-page="paginations.newspublications.currentPage"
                  :per-page="paginations.newspublications.perPage"
                  @filtered="onFiltered($event,'services')"
                  striped hover small show-empty
                >
                  <template v-slot:cell(gallery_file_path)="{ value }">
                    <img :src="value" alt="image" width="100%" draggable="false">
                  </template>
                  <template v-slot:cell(action)="data">
                    <b-btn v-if="checkRights('5-20')" :size="'sm'" variant="warning" @click="$refs.archiveentry.setArchive(data.item.news_id, 1)">
                      <i class="fa fa-arrow-up"></i>
                    </b-btn>
                    <b-btn v-if="checkRights('5-20')" :size="'sm'" variant="danger" @click="$refs.deleteentry.setDelete(data.item.news_id)">
                      <i class="fa fa-trash"></i>
                    </b-btn>
                  </template> 
                </b-table>
              </b-col>
            </b-row>

            <template v-slot:footer>
              <b-row >  <!-- Pagination -->
                <b-col sm="12" class="my-1 ">
                  <b-pagination size="sm" align="right" :total-rows="paginations.newspublications.totalRows" :per-page="paginations.newspublications.perPage" v-model="paginations.newspublications.currentPage"
                    class="my-0" />
                </b-col>
              </b-row> <!-- Pagination -->
            </template>

          </b-card>
        </b-col>
      </b-row>
    </div>
    <DeleteEntry 
      entity="News Publication" 
      table="newspublications" 
      primary_key="news_id" 
      ref="deleteentry"
      :check_for_foreign_key="false" />
    <ArchiveEntry 
      type="unarchive" 
      entity="News Publication" 
      table="newspublications" 
      primary_key="news_id" 
      ref="archiveentry"
      :check_for_foreign_key="false"/>
  </div>
</template>

<script>
import DeleteEntry from '../modals/DeleteEntry'
import ArchiveEntry from '../modals/ArchiveEntry'

export default {
  name: 'newspublications',
    components: {
        ArchiveEntry,
        DeleteEntry,
    },
    data() {
      return {
        tables: {
          newspublications: {
            fields: [
              {
                key:'gallery_file_path',
                label: 'Cover Image',
                thStyle: {width: '15%'},
                tdClass: 'align-middle'
              },                        
              {
                key:'news_title',
                label: 'Title',
                thStyle: {width: '25%'},
                tdClass: 'align-middle ellipsis',
                sortable: true
              },
              {
                key:'news_publish_date',
                label: 'Publication Date',
                thStyle: {width: '20%'},
                tdClass: 'align-middle',
                sortable: true
              },   
              {
                key:'publisher',
                label: 'Published by',
                thStyle: {width: '15%'},
                tdClass: 'align-middle',
                sortable: true
              },
              {
                key:'action',
                label:'Action',
                thStyle: {width: '15%', "text-align":"center"},
                tdClass: 'text-center align-middle',
              }         
            ],
            items: []
          },
        },
        filters: {
          newspublication: {
            criteria: null
          }
        },
        paginations: {
          newspublications: {
            totalRows: 0,
            currentPage: 1,
            perPage: 10
          }
        },
      }  
    },
    methods: {
      checkAction() {
        //load user rights settings
      }
    },
    created() {
      //console.log('created')
      this.archiveFillTableList('newspublications', 0)
    },
}
</script>

<style scoped>
  img {
    height: 5rem;
  }
</style>