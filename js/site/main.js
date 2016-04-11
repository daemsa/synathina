window.EVT = new EventEmitter2();
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
      // /console.log(el)
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
             // You can unslick at a given breakpoint now by adding:
             // settings: "unslick"
             // instead of a settings object
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


$(document).ready(function() {
  myDiary = Diary();
  myDiary.init();    
});



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

    console.log('in');

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
        videos[i].style.backgroundImage = 'url(http://i.ytimg.com/vi/' + videos[i].id + '/sddefault.jpg)';
 
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

$(document).ready(function(){
  var myEmbed = Embed()
  myEmbed.init();
})