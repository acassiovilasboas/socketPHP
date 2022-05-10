
function route(from) {
    const origin = window.location.origin
    from = origin + "/public/views/" + from + ".html";
    window.location.href = from
}

function index() {
    const origin = window.location.origin
    from = origin + "/index.html";
    window.location.href = from
}