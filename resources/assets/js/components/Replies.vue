<template>
   <div>
      <div v-for="(reply, index) in items" :key="reply.id">
         <reply :data="reply" @deleted="deleteReply(index)"></reply>
      </div>
   </div>
</template>

<script>
import Reply from './Reply'
export default {
   props: ['data'], 

   components: {
      Reply
   },

   data () {
      return {
         items: this.data
      }
   },

   methods: {
      deleteReply (index) {
         this.items.splice(index, 1);
         this.$emit('removed');
         flash("Your reply has been deleted");
      }
   }
}
</script>