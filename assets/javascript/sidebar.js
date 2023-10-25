document.addEventListener('DOMContentLoaded', function() {
    let path = window.location.pathname;

    let linkSelected = document.getElementById('linkSelected');
    let linkNotSelected = document.getElementById('linkNotSelected');

    if (path.includes('inventory')) {
        linkSelected.id = 'linkNotSelected';
        linkNotSelected.id = 'linkSelected';
    }
});