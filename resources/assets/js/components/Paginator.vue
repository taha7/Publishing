<template>
   <ul class="pagination" v-if="shouldPaginate">
      <li v-if="prevUrl">
         <a href="#" aria-label="Previous" rel="prev" @click.prevent="page--">
         <span aria-hidden="true">&laquo; Previous</span>
         </a>
      </li>
      <!-- TODO: here was the data -->
      <!-- <li><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">4</a></li>
      <li><a href="#">5</a></li> -->
      
      <li v-if="nextUrl">
         <a href="#" aria-label="Next" ref="next" @click.prevent="page++">
         <span aria-hidden="true">Next &raquo;</span>
         </a>
      </li>
   </ul>
</template>

<script>
export default {
   props: ['dataSet'],

   data() {
      return {
         nextUrl: false,
         page: 1,
         prevUrl: false,
      }
   },

   methods: {
      broadcast() {
         return this.$emit('changed', this.page)
      },
      updateUrl () {
         history.pushState(null, null, "?page=" + this.page)
      }
   },

   computed: {
      shouldPaginate () {
         return !! this.nextUrl || !! this.prevUrl
      }
   },

   watch: {
      dataSet () {
         this.page = this.dataSet.current_page
         this.nextUrl = this.dataSet.next_page_url
         this.prevUrl = this.dataSet.prev_page_url
      }, 

      page() {
         this.broadcast().updateUrl()
      }
   }
}
</script>

<style>

</style>