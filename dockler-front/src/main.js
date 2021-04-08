import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'
import {alert} from './components/notification/alert'
import {task} from './components/http/tasksHttp'

require('dotenv').config()

const axiosConfig = {
    baseURL: process.env.VUE_APP_HOST,
    timeout: 30000,
};
let axiosInstance = axios.create(axiosConfig);
Vue.prototype.axios = axiosInstance
Vue.config.productionTip = false

Vue.prototype.eventBus = new Vue()
Vue.prototype.alert = alert


/**
 * This module is for recruimtnet purposes only. Please do not use it in production env
 * For production please implement refresh token and do not store user password in the app state
 * @type {task}
 */

let taskHttp = new task(axiosInstance)
taskHttp.currentUser('user@dockler.com', 'Johny123@!#');
Vue.prototype.tasksHttp = taskHttp


new Vue({
    render: h => h(App),
}).$mount('#app')
