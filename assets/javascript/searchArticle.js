document.addEventListener('DOMContentLoaded', function () {
    const searchInputActive = document.getElementById('search-input-active');
    const tableRowsActive = document.querySelectorAll('#datatableAllArticlesActive tbody tr');

    searchInputActive.addEventListener('input', function () {
        const searchTerm = searchInputActive.value.toLowerCase();

        tableRowsActive.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowContent = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
            const isVisible = rowContent.includes(searchTerm);
            row.style.display = isVisible ? '' : 'none';
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const searchInputInactive = document.getElementById('search-input-inactive');
    const tableRowsInactive = document.querySelectorAll('#datatableAllArticlesInactive tbody tr');

    searchInputInactive.addEventListener('input', function () {
        const searchTerm = searchInputInactive.value.toLowerCase();

        tableRowsInactive.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowContent = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
            const isVisible = rowContent.includes(searchTerm);
            row.style.display = isVisible ? '' : 'none';
        });
    });
});

function actualiserLaPage() {
    location.reload();
}