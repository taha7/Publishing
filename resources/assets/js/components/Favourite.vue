<template>
   <button type="submit" :class="classes" @click="toggle">
      <span class="glyphicon glyphicon-heart"></span>
      <span v-text="favouritesCount"></span>
   </button>
</template>

<script>
export default {
   props: ["reply"],
   data() {
      return {
         favouritesCount: this.reply.favouritesCount,
         isFavourited: this.reply.isFavourited
      };
   },
   computed: {
      classes() {
         return ["btn", this.isFavourited ? "btn-primary" : "btn-default"];
      },
      endpoint() {
         return `/replies/${this.reply.id}/favourites`;
      }
   },
   methods: {
      toggle() {
         this.isFavourited ? this.unfavourite() : this.favourite();
      },
      favourite() {
         axios.post(this.endpoint);

         this.isFavourited = true;
         this.favouritesCount++;
      },
      unfavourite() {
         axios.delete(this.endpoint);

         this.isFavourited = false;
         this.favouritesCount--;
      }
   }
};
</script>