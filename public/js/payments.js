document.addEventListener('DOMContentLoaded', function() {
    // Add a subtle animation to the table rows for a more modern feel
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        setTimeout(() => {
            row.style.opacity = '1';
        }, 50 * index);
    });
}); 