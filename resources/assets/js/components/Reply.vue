<template>
    <div :id="`reply-${id}`" class="panel panel-warning">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a 
                    :href="`/profiles/${data.owner.name}`" 
                    v-text="data.owner.name"></a> 
                    <!-- TODO: format me -->
                    said {{ data.created_at }} ...
                </h5>
                <!-- Reply favourite -->
                <div v-if="signedIn">
                    <favourite :reply="data"></favourite>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <div v-if="canUpdate" class="panel-footer level">
            <button class="btn btn-xs mr-1" @click="editing = true;">Edit</button>
            <button class="btn btn-xs mr-1 btn-danger" @click="destroy">Delete</button>
        </div>
    </div>

</template>

<script>
import Favourite from "./Favourite";
export default {
   props: ["data"],
   components: {
      Favourite
   },
   data() {
      return {
         editing: false,
         body: this.data.body,
         id: this.data.id,
      };
   },
   methods: {
      update() {
         axios.patch(`/replies/${this.data.id}`, {
            body: this.body
         });

         this.editing = false;

         flash("Updated!");
      },
      destroy() {
         axios.delete(`/replies/${this.data.id}`);

         this.$emit('deleted', this.id);

        //  $(this.$el).fadeOut(300, () => {
        //     flash("Your reply has been deleted");
        //  });
      }
   },

   computed: {
       signedIn() {
          return window.App.signedIn
       }, 
       canUpdate () {
           return this.authorize(user => this.data.user_id == user.id)
       } 
   }
};
</script>