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
    let agency = document.getElementById("agency");
    let account = document.getElementById("account");
    let agencyDestiny = document.getElementById("agencyDestiny");
    let accountDestiny = document.getElementById("accountDestiny");
    let value = document.getElementById("value");

    agency.value = "0001"
    account.value = "989898"
    agencyDestiny.value = "7777"
    accountDestiny.value = "888888"
    value.value = "1009"

    const transaction = {
        value: value.value,
        agency: agency.value,
        account: account.value,
        agencyDestiny: agencyDestiny.value,
        accountDestiny: accountDestiny.value,
        operation: "loan"
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

    if (!isCodeAccountValid(transaction.account)) {
        errors.push([{ "account": "formato inválida" }])
    }

    if (!isCodeAgencyValid(transaction.agency)) {
        errors.push([{ "agency": "formato inválido" }])
    }

    if (!isCodeAgencyValid(transaction.agencyDestiny)) {
        errors.push([{ "agencyDestiny": "formato inválido" }])
    }

    if (!isCodeAccountValid(transaction.accountDestiny)) {
        errors.push([{ "accountDestiny": "formato inválida" }])
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
    let message = data.agency + data.account + data.agencyDestiny + data.accountDestiny + data.value
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