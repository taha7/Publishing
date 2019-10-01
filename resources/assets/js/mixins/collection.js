export default {
   data () {
      return {
         items: []
      }
   },

   methods: {
      addItem (item) {
         this.items.push(item)
         this.$emit('added')
      },
      deleteItem (index) {
         this.items.splice(index, 1);
         this.$emit('removed');
         flash("Your item has been deleted");
      } 
   },
}