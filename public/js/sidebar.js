// Sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggler = document.getElementById('sidebarToggler');
    const sidebarTogglerDesktop = document.getElementById('sidebarTogglerDesktop');
    const appWrapper = document.querySelector('.app-wrapper');
    
    if (!sidebar) return;

    // Create overlay element
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);

    // Toggle sidebar function for mobile
    function toggleMobileSidebar() {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }
    
    // Toggle sidebar function for desktop
    function toggleDesktopSidebar() {
        appWrapper.classList.toggle('sidebar-collapsed');
        // Save preference to localStorage
        localStorage.setItem('sidebarCollapsed', appWrapper.classList.contains('sidebar-collapsed'));
    }
    
    // Check for saved preference
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        appWrapper.classList.add('sidebar-collapsed');
    }

    // Event listeners
    if (sidebarToggler) {
        sidebarToggler.addEventListener('click', toggleMobileSidebar);
    }
    
    if (sidebarTogglerDesktop) {
        sidebarTogglerDesktop.addEventListener('click', toggleDesktopSidebar);
    }
    
    overlay.addEventListener('click', toggleMobileSidebar);