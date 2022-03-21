export class Validate {
    constructor(agency, account, operation, cpf) {
        let errors = []

        if (!this.isCpfValid(cpf)) {
            errors.push([{ "cpf": "tamaho inválido" }])
        }
        if (!this.isCodeAccountValid(account)) {
            errors.push([{ "conta": "formato inválida" }])
        }

        if (!this.isCodeAgencyValid(agency)) {
            errors.push([{ "agencia": "formato inválido" }])
        }

        if (!this.isOperationValid(operation)) {
            errors.push([{ "operacao": "operacao inválida" }])
        }
        return errors
    }
    isCpfValid(data) {
        return data.length == 11 ? true : false
    }
    isOperationValid(data) {
        console.log(data.length)
        data.length == 15 ? true : false
    }
    isCodeAgencyValid(data) {
        return data.length == 4 ? true : false
    }
    isCodeAccountValid(data) {
        return data.length == 6 ? true : false
    }
}