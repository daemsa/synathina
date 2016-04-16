window.EVT = new EventEmitter2();

$(document).ready(function(){

  myEmbed = Embed()
  myEmbed.init();
  renderFileUploaders();
  myForm = FormClone;
  myForm.init();
  myDiary = Diary();
  myDiary.init();

  register = Register;
  register.init();

  var myEmbed, myForm, myDiary;
})

var Main = (function(global){
   // init App on window load
   $(global).load(function(){
      EVT.emit('init');
   });
})(window);

var Gallery = (function(global) {
   //galleryContainer = document.querySelector(".gallery--multirow[rel=js-start-gallery]");
   var galleryThumb = $('.gallery--multirow[rel=js-start-gallery]');

   $.each(galleryThumb, function(index, el){
      $(el).slick({
            dots: true,
            customPaging : function(slider, i) {
              var txt = $(slider.$slides[i]).data('id');
              $(txt).css('text-align', 'center');
              return '<a>'+txt+'</a>';
           },
      });
   })

   var galleryThumb = $('.gallery--thumbnail[rel=js-start-gallery]');

   $.each(galleryThumb, function(index, el){

      $(el).slick({
            dots: true,
            customPaging : function(slider, i) {
             console.log(arguments);
              var txt = $(slider.$slides[i]).data('id');
              var txt2 = slider.$slides.size();

              return '<a>'+txt+'/'+txt2+'</a>';
           },
           slidesToShow: 4,
           slidesToScroll: 4,
           responsive: [
             {
               breakpoint: 1024,
               settings: {
                 slidesToShow: 3,
                 slidesToScroll: 3,
                 infinite: true,
                 dots: true
               }
             },
             {
               breakpoint: 600,
               settings: {
                 slidesToShow: 2,
                 slidesToScroll: 2
               }
             },
             {
               breakpoint: 480,
               settings: {
                 slidesToShow: 1,
                 slidesToScroll: 1
               }
             }
           ]
      });

   })
   var gallery;
})(window);

var DateP = (function(global){
   //function init(){
   var datepickerFrom = $('[rel="js-datepicker-from"]');
   var datepickerTo = $('[rel="js-datepicker-to"]');

   $(datepickerFrom).datepicker();
   $(datepickerTo).datepicker();

   //}
   //var datepickerFrom, datepickerTo;
})(window)

var Popup = (function(global){
   $('.gallery-item').magnificPopup({
     delegate: 'a', // child items selector, by clicking on it popup will open
     type: 'image',
     // other options
     gallery: {
       enabled: true
     },
   });
})(window);

var jsScrollpane = function(global){

  $('.scroll-pane').jScrollPane();

  $(window).resize(function(){
    $('.scroll-pane').jScrollPane();
  });

}(window);

var Diary = function(global){
  state = {
    currentTab : 0,
    currentLabel: 0,
    nextTab : 1,
    prevTab : null
  }
  function init(){
    dates = $('.diary-labels').children();
    diary = $('.c-diary');
    btn_left = diary.find('[rel=js-left]');
    btn_right = diary.find('[rel=js-right]');
    container = diary.find('[rel=js-container]');
    items = diary.find('.tab');
    items_length = items.length -1;
    dates_length = dates.length -1;

    // add events
    btn_left.on('click', showPrev);
    btn_right.on('click', showNext);

  }
  function showNext(){
    if(state.currentTab < items_length) {
      items.removeClass('active');
      dates.removeClass('active');
      state.currentTab += 1;
      state.currentLabel -=1;
      $(items[state.currentTab]).addClass('active');
      $(dates[state.currentTab]).addClass('active');
    }
  }

  function showPrev(){
    if(state.currentTab > 0 ) {
      items.removeClass('active');
      dates.removeClass('active');
      state.currentTab -= 1;
      state.currentLabel -=1;
      $(items[state.currentTab]).addClass('active');
      $(dates[state.currentTab]).addClass('active');
    }

  }


  var btn_left, btn_right, container, diary, state, items_length, dates;

  return {
    init: init
  }
}

var Popup = (function(){
  $('.js-open-popup').magnificPopup({
    items: {
        src: '<div class="white-popup">Hello World!</div>',
        type: 'inline'
    }
  });
})();

var Embed = function(){

  function doEmbed(){

    if (!document.getElementsByClassName) {
        // If IE8
        var getElementsByClassName = function(node, classname) {
            var a = [];
            var re = new RegExp('(^| )'+classname+'( |$)');
            var els = node.getElementsByTagName("*");
            for(var i=0,j=els.length; i<j; i++)
                if(re.test(els[i].className))a.push(els[i]);
            return a;
        }
        var videos = getElementsByClassName(document.body,"youtube");
    } else {
        var videos = document.getElementsByClassName("youtube");
    }

    var nb_videos = videos.length;

    for (var i=0; i<nb_videos; i++) {
        // Finf youtube video thumbnail id
        videos[i].style.backgroundImage = 'url(http://img.youtube.com/vi/' + videos[i].id + '/0.jpg)';

        // Custom Play icon
        var play = document.createElement("div");
        play.setAttribute("class","play");
        videos[i].appendChild(play);

        videos[i].onclick = function() {
            // Create iframe with autoplaytrue
            var iframe = document.createElement("iframe");
            var iframe_url = "https://www.youtube.com/embed/" + this.id + "?autoplay=1&autohide=1";
            if (this.getAttribute("data-params")) iframe_url+='&'+this.getAttribute("data-params");
            iframe.setAttribute("src",iframe_url);
            iframe.setAttribute("frameborder",'0');

            // The height and width of the iFrame should be the same as parent
            iframe.style.width  = this.style.width;
            iframe.style.height = this.style.height;

            // Replace the YouTube thumbnail with YouTube Player
            this.parentNode.replaceChild(iframe, this);
        }
    }
  }
  function init(){
    doEmbed();
  }
  return {
    init : init
  }
}

var renderFileUploaders = function(){
   var browsers = document.querySelectorAll('.file-browser');
   var uploaders = [];
   for( i=0; i < browsers.length; i++ ) {
      uploaders[i] = new FileChooser(browsers[i], {});
   }
};
var FileChooser = function () {
    function FileChooser(element, settings) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }
        this.settings = FileChooser.getSettings(settings);
        this.originalInput = element;
        this.wrapper = FileChooser.createWrapper();
        this.input = FileChooser.createInput(this.settings.placeholder);
        this.clearButton = FileChooser.createClearButton();
        this.appendElements();
        this.attachListeners();
    }
    FileChooser.prototype.setText = function setText(text) {
        this.input.value = text;
    };
    FileChooser.prototype.reset = function reset() {
        this.wrapper.reset();
    };
    FileChooser.prototype.open = function open() {
        this.originalInput.click();
    };
    FileChooser.prototype.attachListeners = function attachListeners() {
        var _this = this;
        this.wrapper.addEventListener('click', function (ev) {
            ev.preventDefault();
            _this.open();
        });
        this.wrapper.addEventListener('submit', function (ev) {
            return ev.preventDefault();
        });
        this.clearButton.addEventListener('click', function (ev) {
            ev.stopPropagation();
            _this.reset();
        });
        this.originalInput.addEventListener('click', function (ev) {
            return ev.stopPropagation();
        });
        this.originalInput.addEventListener('change', function (ev) {
           console.log(ev.target.files)
           var str = '';
           for (var i = 0; i < ev.target.files.length; i += 1) {
             str += ev.target.files[i].name+ ', ';
           }
           str = str.slice(0, -2);
           _this.setText(str);
        });
    };
    FileChooser.prototype.appendElements = function appendElements() {
        var parent = this.originalInput.parentNode;
        //console.log(parent)
        this.originalInput.classList.add('file-chooser-hidden');
        this.wrapper.appendChild(this.input);
        this.wrapper.appendChild(this.clearButton);
        parent.insertBefore(this.wrapper, this.originalInput);
        this.wrapper.appendChild(this.originalInput);
    };
    FileChooser.getDefaults = function getDefaults() {
        return {
            buttonText: 'ανέβασμα',
            placeholder: 'Παρακαλώ επιλέξτε αρχείο'
        };
    };
    FileChooser.getSettings = function getSettings(settings) {
        return _extends({}, FileChooser.getDefaults(), settings);
    };
    FileChooser.createWrapper = function createWrapper() {
        var wrapper = document.createElement('form');
        wrapper.classList.add('file-chooser');
        return wrapper;
    };
    FileChooser.createInput = function createInput(placeholder) {
        var input = document.createElement('input');
        input.setAttribute('readonly', true);
        input.setAttribute('placeholder', placeholder);
        input.setAttribute('multiple', 'multilple');
        input.classList.add('file-chooser-input');
        return input;
    };
    FileChooser.createClearButton = function createClearButton() {
        var clearButton = document.createElement('button');
        clearButton.classList.add('file-chooser-clear');
        return clearButton;
    };
    return FileChooser;
}();

var FormClone = function(global){
   function remove(e){
      $(this).parents(".form-block").remove();
      cloneIndex--;
   }
   function clone(e) {
      e.preventDefault();

      $(this).parents(".form-block").clone()
      .insertAfter("#form-block"+(cloneIndex-1))
      .attr({
         "id" : "form-block" +  cloneIndex,
         'style' : 'height:0; opacity: 0; margin-top : 20px'
      }).animate({
         'height' : '100%',
         opacity : '1'
      }, 300)
      .find("*")
      .each(function() {
          var id = this.id || "";
          var match = id.match(regex) || [];
          if (match.length == 3) {
             this.id = match[1] + (cloneIndex)
          }
      });

      $("#form-block"+(cloneIndex)).find('.remove').removeClass('is-visuallyhidden');
      $("#form-block"+(cloneIndex)).on('click', 'button.clone', clone);
      $("#form-block"+(cloneIndex)).on('click', 'button.remove', remove);

      hiddenStatus.attr({
         'value' : cloneIndex
      });

      cloneIndex++;
   }

   function init(){
      hiddenStatus = $('[name="clones"]');
      adder = $('[rel="js-add-new-form-block"]');
      block = $('[rel="js-form-block"]');
      adder.on('click', clone);
   }
   var regex = /^(.+?)(\d+)$/i;
   var adder, block, hiddenStatus, cloneIndex = $('.form-block').length;

   return {
      init: init
   }

}(window);


var Register = (function(global){

    var LegalComponent = function() {

      function init(){
         container = $('[rel="js-choose-legal-type"]');
         inputs = container.find('input');
         target = $('[rel="js-show-legal-types"]');

         $.each(inputs, function(i, elem){
           $(elem).on('click', checkValue);
         });
      }

      function checkValue(evt){

         if(evt.currentTarget.value === 'yes'){
            $(target).removeClass('form-block--hidden');
            $(target).find('input').prop('disabled', false);

            state.is_legal_type = true;
         }
         if(evt.currentTarget.value === 'no'){

            $(target).addClass('form-block--hidden');
            $(target).find('input').prop('disabled', true);
            $(target).find('input').prop('checked', false);

            state.is_legal_type = false;
            profitComp.clearFields();
            profitComp.hideComp();
         }
      }

      var container, inputs, target;

      return {
         init : init
      }
   }();

   var ProfitComponent = function() {

      function init(){
         container = $('[rel="js-show-legal-types"]');
         inputs = container.find('input');
         target = $('[rel="js-show-profit-types"]');
         target_children = target.find('input');

         $.each(inputs, function(i, elem){
           $(elem).on('click', checkValue);
         });

         $.each(target_children, function(i, elem){
            $(elem).on('click', clearOtherOption.bind(this, target_children));
            $(elem).on('keyup', clearNonProfitRadios.bind(this, target_children));
         });
      }

      function checkValue(evt){

         if(evt.currentTarget.value === 'yes'){
            $(target).removeClass('form-block--hidden');
            $(target).find('input').prop('disabled', false);

            state.is_profit_type = true;
         }

         if(evt.currentTarget.value === 'no'){
            $(target).addClass('form-block--hidden');
            $(target).find('input').prop('disabled', true);
            $(target).find('input').prop('value', '');
            $(target).find('input').prop('checked', false);



            state.is_profit_type = false;
         }
      }

      function clearFields(){
         if(state.is_legal_type === false){
            $(target).find('input').prop('disabled', true);
            $(target).find('input').prop('value', '');
         }
      }
      function hideComp(){
         $(target).addClass('form-block--hidden');
      }

      function clearNonProfitRadios(){
         var inputs = arguments[0];
         $.each(inputs, function(i, elem){
            if(this.type === 'text'){
               $(this).on('keyup', function(e){
                  $.each(inputs, function(i, elem){
                     if(this.type === 'radio'){
                        $(elem).prop('checked', false);
                     }

                  })
               })
            }
         })
      }
      function clearOtherOption(){
         var inputs = arguments[0];
         $.each(inputs, function(i, elem){
            $(elem).prop('value', '');
         })

      }

      var container, inputs, target, target_children

      return {
         init: init,
         clearFields : clearFields,
         hideComp : hideComp
      }
   }();

   var ActionComponent = function() {
      function init(){
         container = $('[rel="js-choose-action-type"]');
         inputs = container.find('input');
         target = $('[rel="js-show-action-type"]');

         $.each(inputs, function(i, elem){
           $(elem).on('click', checkValue);
         });
      }
      function checkValue(evt){

         if(evt.currentTarget.value === 'supporter' && evt.currentTarget.checked === true){
            $(target).removeClass('form-block--hidden');
            $(target).find('input').prop('disabled', false);

            state.is_support_teams = true;

         } else if(evt.currentTarget.value === 'supporter' && evt.currentTarget.checked === false) {
            $(target).addClass('form-block--hidden');
            $(target).find('input').prop('disabled', true);
            $(target).find('input').prop('checked', false);

            state.is_support_teams = false;
         }

      }
      var container, inputs, target;
      return {
         init: init
      }
   }();

   function init(){
      legalComp = LegalComponent;
      profitComp = ProfitComponent;
      actionComp = ActionComponent;

      legalComp.init();
      profitComp.init();
      actionComp.init();

   }
   state = {
      is_legal_type : false,
      is_profit_type : false,
      is_support_teams : false
   }
   var state, legalComp, profitComp, actionComp

   return {
      init : init
   }

})(window)
