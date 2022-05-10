export class CheckSum {
    constructor(message) {
        this.ip = this.getIp()
        this.newMessage = this.ip + "" + message
        this.sum = this.checksum(this.newMessage)
        this.newMessage += this.sum
    }
    checksum(message) {
        let sum = 0
        console.log(message)
        for (let i = 0; i < message.length; i++)
            sum += (i * message.charCodeAt(i))
        return sum
    }
    getNewMessage() {
        return this.newMessage
    }
    getIp() {
        // let response = await $.getJSON('http://www.geoplugin.net/json.gp', function(data) {
        //     return (JSON.stringify(data, null, 2));
        //   });
        // let ip = response.geoplugin_request + ":8080  "
        let ip = window.location.hostname
        let port = window.location.port
        let data = ip + ":" + port
        if(data.length < 20)
            for(let i = data.length; i < 20; i++) 
                data += " "
        return data 
    }
}