window.onload = function() {
    var cookies = document.cookie.split("; ");
    var idCookieExists = cookies.some(function(cookie) {
        return cookie.split('=')[0] === 'id';
    });

    if (!idCookieExists) {
        window.location.href = 'index.html';
    }
};