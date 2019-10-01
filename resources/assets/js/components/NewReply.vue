<template>
   <div>
      <div v-if="signedIn">
      <!-- <form method="POST" action="{{ $thread->path() . '/replies' }}"> -->
      <div class="form-goup" style="margin-bottom:20px">
         <textarea
            name="body"
            id="body"
            class="form-control"
            placeholder="Have something to say?"
            rows="5"
            v-model="body"
            required
         ></textarea>
      </div>
      <button @click="addReply" type="submit" class="btn btn-success">Post</button>
      </div>
      <!-- </form> -->

      <div v-else>
      <p class="text-center">Please <a href="/login">Sign in</a> to participate in this discussion.</p>-->
      </div>
   </div>
</template>

<script>
export default {
   computed: {
      signedIn() {
         return window.App.signedIn;
      } 
   },
   data() {
      return {
         body: '',
      }
   },
   methods: {
      addReply() {
         axios.post(location.pathname + "/replies", {body: this.body})
            .then(({data}) => {
               this.body = ''
               flash('Your reply has been posted.')
               this.$emit('created', data);
            })
      },
   }
};
</script>