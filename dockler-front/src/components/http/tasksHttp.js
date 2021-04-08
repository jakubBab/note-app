import {auth} from './tokenHttp'

export class task {
    constructor(client) {
        this.client = client;
    }

    currentUser(email, password) {
        this.email = email;
        this.password = password;
    }

    async allTasks() {

        let authHttp = new auth(this.client)
        return await authHttp.token(this.email, this.password).then(token => {
            const config = {
                headers: {Authorization: `Bearer ${token}`}
            };
            return this.client.get('task/find', config).then(response => {
                return response.data
            })
        }).catch(function () {
            return false
        })

    }

    async changeState(taskUuid, completed) {

        let authHttp = new auth(this.client)
        return await authHttp.token(this.email, this.password).then(token => {
            const config = {
                headers: {Authorization: `Bearer ${token}`}
            };
            return this.client.patch('task/state',
                {
                    "completed": completed,
                    "taskUuid": taskUuid
                }
                , config).then(response => {
                return response
            })

        }).catch(function () {
            return false
        })


    }

    async addTask(task) {

        let authHttp = new auth(this.client)
        return await authHttp.token(this.email, this.password).then(token => {
            const config = {
                headers: {Authorization: `Bearer ${token}`}
            };
            return this.client.post('task/create',
                {"description": task,}, config).then(response => {
                return response.data
            }).catch(function () {
                return false
            })

        }).catch(function () {
            return false
        })


    }

}