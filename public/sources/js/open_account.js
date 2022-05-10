let response = document.getElementById('response');
const socket = new WebSocket('ws://localhost:9980/echo');
// socket.onopen = function () {
//     socket.send('new-connection');
// }

// Ao estabelecer a conexão enviamos uma mensagem pro servidor
// socket.addEventListener('open', function () {
//     socket.send('new-connection');
// });

const button = document.getElementById("button");
button.addEventListener('click', () => {
    let cpf = document.getElementById("cpf");
    let agency = document.getElementById("agency");
    let account = document.getElementById("account");

    cpf.value = "11122233344"
    agency.value = "1234"
    account.value = "123456"

    const transaction = {
        cpf: cpf.value,
        agency: agency.value,
        account: account.value,
        operation: "open_account"
    }
    // socket.send(JSON.stringify(data));
    let errors = validate(transaction)
    if (errors.length > 0) {
        errors.forEach((error) => {
            error.forEach((item) => {
                Object.keys(item).forEach(key => {
                    document.getElementById(key).classList.add("error");
                    // document.getElementById(key).append(document.createElement("span")).innerHTML = item[key]
                  });
            })
        })
    } else {
        cpf.value = ""
        agency.value = ""
        account.value = ""
        socket.send(prepar(transaction))
    }
})

socket.addEventListener('message', function (event) {
    const data = event.data
    response.innerHTML += data
});

function clearErros() 
{
    document.querySelectorAll(".error").forEach((element) => {
        element.classList.remove("error");
    })
}

function validate(transaction) {
    let errors = []
    clearErros()

    if (!isCpfValid(transaction.cpf)) {
        errors.push([{ "cpf": "tamaho inválido" }])
    }
    if (!isCodeAccountValid(transaction.account)) {
        errors.push([{ "account": "formato inválida" }])
    }

    if (!isCodeAgencyValid(transaction.agency)) {
        errors.push([{ "agency": "formato inválido" }])
    }
    return errors
}

function isCpfValid(data) {
    return data.length == 11 ? true : false
}
function isOperationValid(data) {
    data.length == 15 ? true : false
}
function isCodeAgencyValid(data) {
    return data.length == 4 ? true : false
}
function isCodeAccountValid(data) {
    return data.length == 6 ? true : false
}

function prepar(data) {
    let ip = getIp()
    let operation = addSpace(data.operation, 15)
    let message = data.agency + data.account + data.cpf
    message = addSpace(message, 50)
    let allData = ip + operation + message
    let sum = checksum(allData)
    return allData += sum
}

function checksum(message) {
    let utf8Encode = new TextEncoder().encode(message)
    let xor = 0
    utf8Encode.map((item) => {
        xor ^= item  
    })
    return xor
}

function getIp() {
    // let response = await $.getJSON('http://www.geoplugin.net/json.gp', function(data) {
    //     return (JSON.stringify(data, null, 2));
    //   });
    // let ip = response.geoplugin_request + ":8080  "
    let ip = window.location.hostname
    let port = window.location.port
    let ipPort = ip + ":" + port
    let ipPrepar = addSpace(ipPort, 20)
    return ipPrepar
}

function addSpace(text, maxLength) {
    let data = ""
    if (text.length < maxLength)
        for (let i = text.length; i < maxLength; i++)
            data += " "
    data += text
    return data
}