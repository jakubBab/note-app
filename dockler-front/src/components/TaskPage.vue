<template>
  <div class="tasks">


    <h1>Tasks for today</h1>

    <input id='text-label' v-model="task" class="text-label" placeholder="Add new task" type='text'/>
    <span :class="[processing ? 'after-text-processing' : task ? 'after-text' : 'after-text-unavailable']"
          @click="addTask"> </span>
    <hr>
    <div v-for="(task, index) in tasks " v-bind:key="index">
      <input :id='"label-"+index' type='checkbox' :checked="task.completed" @click="changeState(tasks[index])"/>
      <label :for='"label-"+index'>
        <h3>{{ task.description }}
        </h3>
      </label>
    </div>
  </div>
</template>

<script>

export default {
  name: 'taskPage',
  props: {
    tasks: Array
  },
  data() {
    return {
      task: null,
      processing: false

    }
  },
  mounted() {
    let that = this
    this.eventBus.$on('task_created', function () {
      that.processing = false
      that.task = null
    })
  },
  methods: {

    addTask() {
      if (this.task) {
        this.processing = true
        this.$emit('create_task', this.task)
      }
    },

    changeState(taskProp) {
      let newState = taskProp.completed = !taskProp.completed;
      let that = this
      this.tasksHttp.changeState(taskProp.uuid, newState).then(response => {
        if (response === false || response.status !== 204) {
          that.alert('error', 'Unexpected error occurred');
        }
      });

    }
  }
}
</script>

<style scoped>

h1 {
  color: whitesmoke;
  text-align: center;
  font-size: 32px;
  font-weight: 900;
}

/* tasks */
.tasks {
  width: 300px;
  height: 405px;
  position: absolute;
  top: 10%;
  left: 0px;
  right: 0px;
  margin: 0px auto;
}

input[type=checkbox] {
  display: none;
}

.text-label {
  color: white;
}

.text-label::placeholder {
  color: white
}

label, .text-label {
  background: #ae5f75;
  height: 69px;
  width: 100%;
  display: block;
  border-bottom: 1px solid #2C3E50;
  color: #fff;
  text-transform: capitalize;
  font-weight: 900;
  font-size: 11px;
  letter-spacing: 1px;
  text-indent: 20px;
  cursor: pointer;
  transition: all 0.7s ease;
  position: relative;
  padding: 5px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
}

.text-label {
  cursor: default;
}

label h2 span {
  display: block;
  font-size: 12px;
  text-transform: capitalize;
  font-weight: normal;
  color: #fff;
}

label:before {
  content: "";
  width: 20px;
  height: 20px;
  background: #fff;
  display: block;
  position: absolute;
  border-radius: 100%;
  right: 20px;
  top: 30%;
  transition: border 0.7s ease
}

.after-text:after {
  content: "";
  width: 20px;
  height: 20px;
  background: greenyellow;
  display: block;
  position: absolute;
  border-radius: 100%;
  right: 20px;
  top: 26%;
  transition: border 0.7s ease
}

.after-text-processing:after {
  content: "";
  width: 20px;
  height: 20px;
  background: orange;
  display: block;
  position: absolute;
  border-radius: 100%;
  right: 20px;
  top: 26%;
  transition: border 0.7s ease
}

.after-text-unavailable:after {
  content: "";
  width: 20px;
  height: 20px;
  background: grey;
  display: block;
  position: absolute;
  border-radius: 100%;
  right: 20px;
  top: 26%;
  transition: border 0.7s ease
}

.after-text:hover {
  cursor: pointer;
}

[id^='label-']:checked {
  background: #6d335c;
  border-bottom: 1px solid #34495E;
  color: #d37b79;
  display: none;
}

[id^='label-']:checked ~ label[for^="label-"] {
  background: #6d335c;
  border-bottom: 1px solid #34495E;
  color: #d37b79;
}


[id^='label-']:checked ~ label[for^="label-"]:before {
  background: url("https://i.imgur.com/eoPQ05r.png") no-repeat center center;
}

</style>
