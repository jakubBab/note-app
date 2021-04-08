export class auth {
    constructor(client) {
        this.client = client
    }

    async token(name, password) {
        return await this.client.post('login_check', {
            "username": name,
            "password": password
        })
            .then(response => {
                return response.data.token
            }).catch(() => {
                return false
            })
    }

}