var Menu = (function(global) {

   function toggleMenu(evt) {
      evt.preventDefault()
      evt.stopPropagation();
      classie.toggleClass(body, 'is-oveflow-hidden');
      classie.toggleClass(menu, 'is-open');
      classie.toggleClass(evt.currentTarget, 'is-active');

      if(categories !== null){
         classie.toggleClass(categories, 'is-open');
      }
   };

   function init() {
      body = document.querySelector('body');
      menu = document.querySelector("[rel=js-nav]");
      button = document.querySelector("[rel=js-toggle-menu]");
      categories = document.querySelector("[rel*=js-toggle-categories]");

      button.addEventListener('click', toggleMenu);

   };

   var menu, button, body, categories;

   EVT.on('init', init);

   return {
      init : init,
      initMenu : init
   }

})(window);
