
const _  = require('lodash');

function SiteState () {
    this.state = {
        sliderInitialized: false
    };

    this.setState = function (newState) {
        this.state = Object.assign({}, this.state, newState);

        return this.state;
    };

    this.getState = function () {
        return this.state;
    };
}

(function(global) {
    const { document } = global;
    const stateInstance = new SiteState();

    document.addEventListener('DOMContentLoaded', function() {
        mobileMenu(this);
        featuredArticles(this);
        featuredSlider(global, stateInstance);
    });

    global.addEventListener('resize', _.debounce(function() {
        featuredSlider(global, stateInstance);
    }, 200));

})(window);

// optional for mobile device check
function checkIfMobile () {
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        return true;
    }

    return false;
}

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
    const map = context.querySelector('#map');

    if (!drawer || !toggleButton) return false;

    toggleButton.addEventListener('click', function() {
        drawer.classList.toggle('l-homepage__featured--up');
        map.classList.toggle('synathina-map--blur');
    });
}

function featuredSlider (window, state) {
    const { document } = window;
    const { sliderInitialized } = state.getState();
    const gallery = document.querySelector('[rel=js-mobile-gallery]');
    const hasMobileViewPort = window.innerWidth <= 768;
    const options = {
        arrows: false,
        dots: true
    };

    $(gallery).on('init', function(event, slick) {``
        state.setState({sliderInitialized: true});
    });

    $(gallery).on('destroy', function(event, slick) {
        state.setState({sliderInitialized: false});
    });

    if (!hasMobileViewPort && !sliderInitialized) {
        return false;
    }

    if (!hasMobileViewPort && sliderInitialized) {
        return $(gallery).slick('unslick');
    }

    $(gallery).slick(options);
}

function updateSiteState(state, newState) {
    return Object.assign({}, state, newState);
}
