var Activities = (function(global) {

  function uniqueCategory(cat) {
      var catNew = [];
      var counter=0;

      for(var i=0; i<cat.length; i++){
         var found=false;
         for(var j=0; j<catNew.length; j++){
            if(cat[i].category_id==catNew[j].category_id){
               found=true;
               break;
            }
         }
         if(!found){
            catNew[counter++]=cat[i];
         }

      }

      return catNew.sort(function(a, b){
         return parseInt(a.category_id) - parseInt(b.category_id);
      });

      //return catNew;
  }
  function contains2(needle) {
    // Per spec, the way to identify NaN is that it is not equal to itself
    var findNaN = needle !== needle;
    var indexOf;

    if(!findNaN && typeof Array.prototype.indexOf === 'function') {
        indexOf = Array.prototype.indexOf;
    } else {
        indexOf = function(needle) {
            var i = -1, index = -1;

            for(i = 0; i < this.length; i++) {
                var item = this[i];

                if((findNaN && item !== item) || item === needle) {
                    index = i;
                    break;
                }
            }

            return index;
        };
    }

    return indexOf.call(this, needle) > -1;
};
   function checkActivityDate(a_date){
      var today = new Date();
      var a_day = new Date(a_date);
      var state;
      if(today.getFullYear() > a_day.getFullYear()){
         state = 'past';
      } else if(today.getFullYear() <= a_day.getFullYear()){
         state = 'future';
      }

      return state;
   }

   function Activity(map, myLatLng, data) {
      /**
       * [marker description]
       * @type {google}
       * @param {obj} [db_content] [data records that came from server's database]
       */
      var state = null;
      var src = '';
      state = checkActivityDate(data.date);
      if (state === 'future') {
         src = icons.future.icon;
      }
      if (state === 'past') {
         src = icons.past.icon;
      }
      var marker = new google.maps.Marker({
         position: myLatLng,
         map: map,
         db_data : {
            title: data.title,
            date : new Date(data.date),
            address : data.address,
            team_name : data.team_name,
            id: data.id,
            is_featured: data.is_featured,
            slug: data.slug,
            category_id: data.category_id,
            category_name : data.category_name,
            team_id: data.team_id,
            team_name: data.team_name,
            team_members: data.team_members,
            sponsor_title: data.sponsor_title,
            date: data.date,
            title: data.title,
            content: data.content,
            content_img: data.content_img,
            logo: data.log,
            logo_sponsor: data.logo_sponsor,
            logo_team: data.logo_team,
            url : 'http://steficon-demo.eu/synathina'
         },
         icon : src
      });
     // TEMPLATE  INFO WINDOW
     var contentString = '<div class="info"> <div class="info-title info-title--address">'+data.title+'</div> <div class="info-meta"><span class="info-address">'+data.address+'</span>, <span class="info-date">'+data.date+'</span></div> <div class="info-source">'+data.team_name+'</div> <div class="info-img"><img src="'+data.content_img+'""></div> <div class="info-description">'+data.content+'<a href="'+data.url+'">/περισσότερα</a> </div> <div class="info-badge"> <div class="info-badge-item info-badge-item--sponsor-logo"> <i class="fill"></i> </div> <div class="info-badge-item info-badge-item--team-logo"> <i class="fill"></i> </div> <div class="info-badge-item info-badge-item--team-power"> <i class="fill"></i> </div> </div> </div>';

      this.marker = marker;

      this.marker.addListener('click', function() {
         map.infoWindow.setContent(contentString)
         map.infoWindow.open(map, this);
      });

        //cachedMarkers.push(marker);
        //var markerCluster = new MarkerClusterer(map, cachedMarkers);
   }
   function showActivities(polygon) {
      myMap = polygon.getMap();
      console.log(myMap);
   }
   function populateActivities(data) {

      try {
         dat = JSON.parse(data.response);
         //dat = data.response;
      } catch(e) {
          //JSON parse error, this is not json
          //alert('JSON parse error : '+e);
          console.log(e)
          return false;
      }

      collection = JSON.parse(data.response);
      console.log(collection.length);
      //setTimeout(func, delay)
      Categories.init(collection);


      coordinatesArray = createMarkersArray(collection);

      for( var i = 0; i < coordinatesArray.length; i += 1) {
         var point = new google.maps.LatLng(coordinatesArray[i].lat, coordinatesArray[i].lng);
         // create activities with marker object as property
         
         activities[i] = new Activity(map, coordinatesArray[i], collection.features[i]);
         activities[i].marker.setVisible(false);
      }

      //markerClusterer = new MarkerClusterer(map, cachedMarkers, {});
      //markerClusterer.clearMarkers();

   }

   function refreshMap(markers) {
      if (markerClusterer) {
         markerClusterer.clearMarkers();
      }
      markerClusterer = new MarkerClusterer(map, markers, {});
   }

   function setActivitiesVisibility (){

      Activities.current_polygon = arguments[0];
      polygon = arguments[0];
      cat_filter = arguments[1];
      //Clusterer
      if(window.clusterer !== undefined){
        console.log('in')
        window.category.length=0;
        window.clusterer.clearMarkers();
      }

      window.category = [];
      window.clusterer = new MarkerClusterer(map, [], {
        gridSize : 50,
        maxZoom : 20
      });

      for (var i=0; i<arguments.length; i++){
        if (arguments[i] instanceof MarkerClusterer){
            //mc = arguments[i];
        }
      }

      /**
       * [if user clicks on polygon and already have used filtering, use the latter year ranges also for the next polygon]
       * @param  {[boolean]} Activities.is_filtered []
       */

      if (Activities.is_filtered_bySlider == true && Activities.yearRangeBuffer !== null && cat_filter === undefined) {
          for( var i = 0; i < coordinatesArray.length; i += 1) {
            activities[i].marker.setVisible(false)
          }
          filterActivities(Activities.yearRangeBuffer);

      } else {

        if(cat_filter !== undefined){
          Filter.run = true;

            for( var i = 0; i < coordinatesArray.length; i += 1) {
               var point = new google.maps.LatLng(coordinatesArray[i].lat, coordinatesArray[i].lng);
               if( polygon.Contains(point)) {

                  needle = parseInt(activities[i].marker.db_data.category_id);
                  index = contains2.call(cat_filter, needle); // true

                  if(index || cat_filter.length == 0){
                      activities[i].marker.setVisible(true);
                      category.push(activities[i].marker);
                  }else {
                     activities[i].marker.setVisible(false);
                  }
              }
            }
            // pushing markers to cluster
            clusterer.clearMarkers();
            clusterer.addMarkers(category);
            category.length=0;

        } else {

            for( var i = 0; i < coordinatesArray.length; i += 1) {
              var point = new google.maps.LatLng(coordinatesArray[i].lat, coordinatesArray[i].lng);
              if( polygon.Contains(point)) {
                 activities[i].marker.setVisible(true)
                 category.push(activities[i].marker);
              }
              else {
                 activities[i].marker.setVisible(false);
              }
            }

            clusterer.clearMarkers();
            clusterer.addMarkers(category);
            category.length=0;


        }

        // threading with Category
        Categories.createCategory();
        // threading with Filter
        saFilter = Filter(activities);
        saFilter.initSliderFilter();
        saFilter.initCategoryFilters();


      }
   }

   function filterActivities(dates, filter) {
     Filter.run = true;
      var date_from = Math.floor(dates[0]);
      var date_to = Math.floor(dates[1]);

      if(window.clusterer !== undefined){
        console.log('in')
        window.category.length=0;
        window.clusterer.clearMarkers();
      }

      window.category = [];
      window.clusterer = new MarkerClusterer(map, [], {
        gridSize : 50,
        maxZoom : 20
      });

      for( var i = 0; i < coordinatesArray.length; i += 1) {
         var point = new google.maps.LatLng(coordinatesArray[i].lat, coordinatesArray[i].lng);
         if( Activities.current_polygon.Contains(point)) {
             if( activities[i].year >= date_from && activities[i].year <= date_to){
                activities[i].marker.setVisible(true);
                category.push(activities[i].marker);
             } else {
                activities[i].marker.setVisible(false);
             }
          }
      }
      clusterer.clearMarkers();
      clusterer.addMarkers(category);
      category.length=0;

   }

   function createMarkersArray(){
      InputObj = arguments[0];

      for(var i = 0; i < InputObj.features.length; i += 1){
         markersArray.push({
            lat : InputObj.features[i].coordinates[0],
            lng : InputObj.features[i].coordinates[1],
         });
      }
      return markersArray;
   }



   function init() {
      //AjaxCall.get('js_collections/activities/array.json', populateActivities);
      AjaxCall.get('http://steficon-demo.eu/synathina/actions.php', populateActivities);
   }

   var res, collection, activities = [], markersArray = [], coordinatesArray, polygon, contentString, saFilter, saSlider, current_polygon, cachedMarkers = [], markerClusterer, categories;

   var iconBase = 'img/markers/';
   var icons = {
     past: {
       icon: iconBase + 'marker_grey.png'
     },
     future: {
       icon: iconBase + 'marker_orange.png'
     }
   };

   global.EVT.on('init', init);

   // threading with Area
   global.EVT.on('show-activities', setActivitiesVisibility);

   return {
      init : init,
      filterActivities : filterActivities,
      setActivitiesVisibility : setActivitiesVisibility,
      current_polygon : current_polygon,
      is_filtered_bySlider : false,
      yearRangeBuffer : null,
   }

})(window)
