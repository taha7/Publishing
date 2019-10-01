<template>
   <div>
      <div v-for="(reply, index) in items" :key="reply.id">
         <reply :data="reply" @deleted="deleteItem(index)"></reply>
      </div>

      <paginator :dataSet="dataSet" @changed="fetch"></paginator>

      <new-reply @created="addItem"></new-reply>
   </div>
</template>

<script>
import Reply from './Reply'
import NewReply from './NewReply'
import collection from '../mixins/collection' ;


export default {
   components: {
      Reply,
      NewReply
   },

   mixins: [collection],

   created () {
      this.fetch();
   },

   data () {
      return {
         dataSet: false
      }
   },

   methods: {
      /** url for requesting paginated replies */
      url (page) {
         if(!page) {
            // get the page from the url
            let query = location.search.match(/page=(\d+)/)
            page = query ? query[1] : 1;
         }
         return `${location.pathname}/replies?page=${page}`
      },
      fetch (page) {
         axios(this.url(page)).then(this.refresh)
      },
      refresh({ data }) {
         this.dataSet = data;
         this.items = data.data
      },
   }
}
</script>