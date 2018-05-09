const _  = require('lodash');
const siblings = require('siblings');

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
        IEcheck(document);
        mobileMenu(this);
        featuredArticles(this);
        featuredSlider(global, stateInstance);
        checkIfMobile() && createFooterMenu(global);
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

function createFooterMenu (window) {
    const { document } = window;
    const container = document.querySelector('[rel=js-create-footer-menu]');

    if (!container ) return false;

    const button = container.querySelector('[rel=js-toggle-footer-drown]');
    const nodes = siblings(container, '[rel=js-footer-menu-item]');
    const dropdown = container.querySelector('.dropdown');
    const menu = dropdown.querySelector('.menu');

    function closeDropDown (evt) {
        const elemNoMatch = evt.target.id != 'footer-dropdown-menu' && ( !evt.target.closest('.l-footer__menus') || evt.target.closest('.l-footer__menus').length == 0);

        if (elemNoMatch) {
            document.body.removeEventListener('click', closeDropDown, false);
            dropdown.classList.remove('dropdown--open');
        }
    }

    if (!button, !nodes, !dropdown, !menu ) return false;

    nodes.forEach(function(node) {
        node.classList.remove('nav-site-com');
        const li = document.createElement('li');
        li.appendChild(node);
        menu.appendChild(li);
    });

    dropdown.classList.add('dropdown--inverted');
    container.classList.remove('hidden');

    document.addEventListener('click', closeDropDown, false);

    button.addEventListener('click', function () {
        document.addEventListener('click', closeDropDown, false);
        dropdown.classList.toggle('dropdown--open');
    });
}

function IEcheck (context) {
    if (navigator.userAgent.indexOf('MSIE')!==-1 || navigator.appVersion.indexOf('Trident/') > 0) {
        var message = context.querySelector('[rel=js-browser-message]');
        if (!message) return false;
        message.classList.add('browser-message--open');

        return false;
    }
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
        EVT.emit('hide-cross');
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

    $(gallery).on('init', function(event, slick) {
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

