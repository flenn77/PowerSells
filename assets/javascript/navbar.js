document.addEventListener('DOMContentLoaded', function() {
    let path = window.location.pathname;

    if (path.includes('login')){
        document.getElementById('navbar').style.display = "none";
    }
});