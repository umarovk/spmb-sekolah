document.addEventListener('DOMContentLoaded', function() {
    // Initialize all popovers with improved options
    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => {
        const popover = new bootstrap.Popover(popoverTriggerEl, {
            sanitize: false,
            container: 'body'
        });

        // Add click event listener after popover is shown
        popoverTriggerEl.addEventListener('shown.bs.popover', function() {
            const dismissButtons = document.querySelectorAll('.dismiss-popover');
            dismissButtons.forEach(button => {
                button.addEventListener('click', function() {
                    popover.hide();
                });
            });

            // Close popover when clicking outside
            document.addEventListener('click', function(event) {
                if (!popoverTriggerEl.contains(event.target) &&
                    !document.querySelector('.popover')?.contains(event.target)) {
                    popover.hide();
                }
            });
        });

        return popover;
    });

    // Add a subtle animation to the table rows for a more modern feel
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        setTimeout(() => {
            row.style.opacity = '1';
        }, 50 * index);
    });
}); 