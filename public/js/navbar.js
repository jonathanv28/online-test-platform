document.addEventListener('DOMContentLoaded', function() {
    const drawerOverlay = document.getElementById('drawer-overlay');
    const drawerNavigation = document.getElementById('drawer-navigation');
    const showButton = document.querySelector('[data-drawer-show="drawer-navigation"]');
    const hideButton = document.querySelector('[data-drawer-hide="drawer-navigation"]');

    // Function to show drawer and overlay
    function showDrawer() {
        drawerOverlay.classList.remove('hidden');
        drawerNavigation.classList.remove('-translate-x-full');
    }

    // Function to hide drawer and overlay
    function hideDrawer() {
        drawerOverlay.classList.add('hidden');
        drawerNavigation.classList.add('-translate-x-full');
    }

    // Event listener for showing drawer and overlay
    showButton.addEventListener('click', () => {
        showDrawer();
    });

    // Event listener for hiding drawer and overlay
    hideButton.addEventListener('click', () => {
        hideDrawer();
    });

    // Event listener for clicking anywhere outside the drawer to hide drawer and overlay
    document.addEventListener('click', (event) => {
        const isDrawer = drawerNavigation.contains(event.target);
        const isShowButton = event.target === showButton;
        const isSvgChild = event.target.closest('svg'); // Check if clicked element is inside an SVG
        if (!isDrawer && !isShowButton && !isSvgChild) {
            hideDrawer();
        }
    });
});
