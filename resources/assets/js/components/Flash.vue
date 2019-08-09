<template>
   <div class="alert alert-success alert-flash" role="alert" v-show="show">
      <strong>Success!</strong>
      {{ body }}
   </div>
</template>

<script>
export default {
   props: ["message"],

   data() {
      return {
         body: this.message,
         show: false
      };
   },
   created() {
      if (this.message) {
         this.flash(this.message);

         // events is a vue instance
         window.events.$on("flash", message => {
            this.flash(message);
         });
      }
   },
   methods: {
      flash(message) {
         this.body = message;
         this.show = true;

         //hide me after 3 secs
         this.hide();
      },
      hide() {
         setTimeout(() => {
            this.show = false;
         }, 4000);
      }
   }
};
</script>


<style>
.alert-flash {
   position: fixed;
   right: 25px;
   top: 60px;
   z-index: 99999;
   opacity: 0.9;
}
</style>
