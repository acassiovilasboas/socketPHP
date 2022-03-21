import { Validate } from './Validate.js'
import { CheckSum } from './CheckSum.js'

let response = document.getElementById('response');
const socket = new WebSocket('ws://localhost:9980/echo');

// Ao estabelecer a conexão enviamos uma mensagem pro servidor
socket.addEventListener('open', function () {
    // socket.send('Conexão estabelecida.');
});

// Callback disparado sempre que o servidor retornar uma mensagem
socket.addEventListener('message', function (event) {
    response.insertAdjacentHTML('beforeend', "<p><b>Servidor diz: </b>" + event.data + "</p>");
});

document.querySelector("#button").addEventListener('click', function (event) {   
    let imputs = document.querySelectorAll(".inputData")

    let operation = document.querySelector("#operation") ?? ""
    let agency = document.querySelector("#agency") ?? ""
    let account = document.querySelector("#account") ?? ""
    let cpf = document.querySelector("#cpf") ?? ""

    let message = operation[operation.selectedIndex].value

    imputs.forEach((item) => {
        console.log(item.id)
        message += item.value
    })

    let errors = new Validate(
        agency.value,
        account.value,
        operation[operation.selectedIndex].value,
        cpf.value
    )

    if (errors.length > 0) {
        errors.forEach((item) => {
            console.log(item)
        })
        let checksum = new CheckSum(message).getNewMessage()
        socket.send(checksum)
    } else {
        let checksum = new CheckSum(message).getNewMessage()
        // socket.send(checksum);
    }
});
