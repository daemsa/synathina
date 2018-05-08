(function(global) {
    const { document } = global;

    document.addEventListener('DOMContentLoaded', function() {
        mobileMenu(this);
        featuredArticles(this);
    });
})(window);

function mobileMenu (context) {
    const openButton = context.querySelector('[rel=js-toggle-menu]');
    const closeButton = context.querySelector('[rel=js-mobile-menu-close]');
    const menu = context.querySelector('[rel=js-mobile-menu]');

    if (!openButton || !closeButton || !menu) {
        return false;
    }

    openButton.addEventListener('click', function() {
        menu.classList.add('mobile-menu--active');
    });

    closeButton.addEventListener('click', function() {
        menu.classList.remove('mobile-menu--active');
    });
}

function featuredArticles (context) {
    const drawer = context.querySelector('[rel=js-drawer]');
    const toggleButton = context.querySelector('[rel=js-toggle-drawer]');

    if (!drawer || !toggleButton) return false;

    toggleButton.addEventListener('click', function() {
        drawer.classList.toggle('l-homepage__featured--up');
    });
}