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
    let agencyOrigin = document.getElementById("agencyOrigin");
    let accountOrigin = document.getElementById("accountOrigin");
    let agencyDestiny = document.getElementById("agencyDestiny");
    let accountDestiny = document.getElementById("accountDestiny");
    let value = document.getElementById("value");

    agencyOrigin.value = "2222"
    accountOrigin.value = "333333"
    agencyDestiny.value = "7777"
    accountDestiny.value = "888888"
    value.value = "1009"

    const transaction = {
        value: value.value,
        agencyOrigin: agencyOrigin.value,
        accountOrigin: accountOrigin.value,
        agencyDestiny: agencyDestiny.value,
        accountDestiny: accountDestiny.value,
        operation: "transfer"
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

        agencyOrigin.value = ""
        accountOrigin.value = ""
        agencyDestiny.value = ""
        accountDestiny.value = ""
        value.value = ""
        socket.send(prepar(transaction))
    }
})

socket.addEventListener('message', function (event) {
    const data = event.data
    response.innerHTML += data
});

function clearErros() {
    document.querySelectorAll(".error").forEach((element) => {
        element.classList.remove("error");
    })
}

function validate(transaction) {
    let errors = []
    clearErros()

    if (!isCodeAccountValid(transaction.accountDestiny)) {
        errors.push([{ "accountDestiny": "formato inválida" }])
    }

    if (!isCodeAccountValid(transaction.accountOrigin)) {
        errors.push([{ "accountOrigin": "formato inválida" }])
    }

    if (!isCodeAgencyValid(transaction.agencyOrigin)) {
        errors.push([{ "agencyOrigin": "formato inválido" }])
    }

    if (!isCodeAgencyValid(transaction.agencyDestiny)) {
        errors.push([{ "agencyDestiny": "formato inválido" }])
    }

    return errors
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
    let message = data.agencyOrigin + data.accountOrigin + data.agencyDestiny + data.accountDestiny + data.value
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