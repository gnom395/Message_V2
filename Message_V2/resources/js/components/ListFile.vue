<template>
  <div>

        <ListFileItem

          v-for="(todo, index) in this.todos"
          v-bind:key="todo.id"
          v-bind:id="todo.id"
          v-bind:title="todo.title"
          @remove="remove(index)"
          >
        </ListFileItem>



</div>
</template>

<script>
import ListFileItem from '../components/ListFileItem';

  export default {
    components: {
      ListFileItem
    },

    data() {
      return {
        newTodoText: '',
        todos: [],
        nextTodoId: 1,
        attachfile: ''
      }
    },

    mounted() {

  /// слушаем ответ от чата
      this.$root.$on('AddFileList', (filename,idfile) => {
          this.addNewTodo(filename,idfile)
      })
      this.$root.$on('ListFileClean', () => {
          this.todos = []
      })
    },
    methods: {
      remove(index){
        //alert()
        this.todos.splice(index, 1)

        this.$emit('sendfiles',this.todos)
      },
      addNewTodo(filename,idfile) {
        this.todos.push({
          //id: this.nextTodoId++,
          id: idfile,
          title: filename
        })

        this.$emit('sendfiles',this.todos)
      }
    }
  }
</script>

<style scoped>

</style>
