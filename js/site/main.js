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
