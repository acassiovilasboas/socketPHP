

let response = document.getElementById('response');
const socket = new WebSocket('ws://localhost:9980/echo');

// Ao estabelecer a conexão enviamos uma mensagem pro servidor
socket.addEventListener('open', function () {
    socket.send('new-connection');
});

const button = document.getElementById("button");
button.addEventListener('click', () => {
    let cpf = document.querySelector("#cpf");
    const data = {
        origin: "client",
        data: {
            cpf: cpf.value
        }
    }
    socket.send(JSON.stringify(data));
    cpf.value = ""
})

const divResponseNotHasAccount = document.getElementById("noHasAccount");
const divResponseHasAccount = document.getElementById("hasAccount");

socket.addEventListener('message', function (event) {
    const data = JSON.parse(event.data)
    const accounts = data[0]["accounts"]

    if( accounts.length > 0) {
        document.getElementById("text").style.display = "none"
        divResponseHasAccount.style.display = "initial";
        let lines = `
        <div class="row">
        <div class="col-md-12">
            <div class="h4 mb-3">${accounts.length} contas encontradas.</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Agencia</th>
                            <th>Conta</th>
                            <th>CPF</th>
                            <th center>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
        `

        accounts.forEach((account) => {
            lines += populateAccounts(account)
        })
        lines += `</tbody></table></div></div>`
        divResponseHasAccount.innerHTML = lines
    }
});

function populateAccounts(data) {    
    let table = `
    <tr>
        <td>${data.agency}</td>
        <td>${data.account}</td>
        <td>${data.cpf}</td>
        <td>
            <p>Editar</p>
        </td>
    </tr>
    `
    return table
}
