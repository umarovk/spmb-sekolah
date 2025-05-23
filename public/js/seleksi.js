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

    // Handle status updates
    document.querySelectorAll('.update-status').forEach(button => {
        button.addEventListener('click', async function() {
            const siswaId = this.dataset.siswaId;
            const statusSelect = document.querySelector(
                `.status-select[data-siswa-id="${siswaId}"]`);
            const newStatus = statusSelect.value;
            const currentDate = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format

            // Show loading state
            button.disabled = true;
            button.innerHTML =
                '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';

            try {
                const response = await fetch(`/seleksi/${siswaId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        status: newStatus,
                        tanggal_seleksi: currentDate
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Update the badge immediately
                    const badgeColor = {
                        'diterima': 'bg-success',
                        'ditolak': 'bg-danger',
                        'dipertimbangkan': 'bg-warning',
                        'pending': 'bg-secondary'
                    }[newStatus];

                    const badge = statusSelect.previousElementSibling;
                    badge.className = `badge ${badgeColor}`;

                    // Update badge text with current date
                    let badgeText = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                    if (newStatus !== 'pending') {
                        const formattedDate = new Date().toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                        badgeText += ` (${formattedDate})`;
                    }
                    badge.textContent = badgeText;

                    // Show success toast
                    const toast = document.createElement('div');
                    toast.className = 'toast position-fixed bottom-0 end-0 m-3';
                    toast.innerHTML = `
                        <div class="toast-body bg-success text-white">
                            Status berhasil diupdate
                        </div>
                    `;
                    document.body.appendChild(toast);
                    new bootstrap.Toast(toast).show();
                } else {
                    throw new Error(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            } finally {
                button.disabled = false;
                button.innerHTML = '<i class="bi bi-save me-1"></i> Simpan';
            }
        });
    });
}); 