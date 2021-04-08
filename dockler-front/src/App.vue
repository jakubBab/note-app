<template>
  <div id="app">
    <TaskPage v-on:create_task="createTask" :tasks="tasks"/>
  </div>
</template>

<script>
import TaskPage from './components/TaskPage.vue'

export default {
  name: 'App',
  components: {
    TaskPage
  },
  data() {
    return {
      tasks: []
    }
  },

  mounted() {
    let that = this
    this.tasksHttp.allTasks().then(response => {
      if (false === response) {
        that.alert('error', 'Unexpected error occurred');
        return null;
      }
      that.tasks = response
    })
  },
  methods: {
    createTask(taskDescription) {

      let that = this

      this.tasksHttp.addTask(taskDescription).then(response => {
        if (false === response) {
          that.alert('error', 'Unexpected error occurred');
          return null;
        }
        that.tasks.push(response)
        this.eventBus.$emit('task_created')
      });

    }
  }

}
</script>

<style>
html, body {
  margin: 0;
  padding: 0;
  border: 0;
  font-size: 100%;
}

/* body */
body {
  background: #4d244e;
  font-family: sans-serif;
  border-top: 5px solid #aa8e8d;
}
</style>
