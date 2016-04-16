  var Filter = (function(){
    data = arguments[0];
    activities = arguments[0];

    function initSliderFilter() {

      $('div#slider3').html('');
      dateFormat = d3.time.format('%Y-%m-%d %H:%M:%S');
      numberFormat = d3.format('0');

      activities.forEach(function (d) {
        d.dd = dateFormat.parse(d.marker.db_data.date);
        d.year = d3.time.year(d.dd).getFullYear();
      });

      dispatch = d3.dispatch('filter');
      accessor = function(d){return d.year;};
      range = d3.extent(activities, accessor);

      if(Activities.yearRangeBuffer === null) {

        var today = new Date()
        today = today.getFullYear();
        //range[0] = today
        d3.select("div#slider3")
          .call(d3.slider().axis(true).min(range[0]).max(range[1]).value([today, range[1]])
          .on("slide",function(evt, value, activities){
              dispatch.filter(value);
              hasRun = 1; //!!!!!
        }));
      } else {

        d3.select("div#slider3")
          .call(d3.slider().axis(true).min(range[0]).max(range[1]).value(range)
          .on("slide",function(evt, value, activities){
              dispatch.filter(value);
              hasRun = 1;
        }));
      }
      dispatch.on('filter',function(value){
        Activities.filterActivities(value);
        Activities.is_filtered_bySlider = true;
        Activities.yearRangeBuffer = value;

      });


      dc.renderAll()
    }

    // How many activities are in my app?
    function countFacts() {
      num = facts.groupAll().reduceCount().value();
      return num;
    }

    function contains(needle) {

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

    function initCategoryFilters(){

        checkboxes = Filter.category_filters.category_NodeList;
        RECORDS = Filter.category_filters.category_entity;

        var filters = [];
        /*
        var checkAll = checkboxes[0];

        checkAll.addEventListener('click', function(evt){
           evt.stopPropagation();
           evt.stopImmediatePropagation();

           if(this.checked === false) {
              for ( var i = 1; i < checkboxes.length; i++ ){
                 checkboxes[i].checked = false;
              }
           }

           if(this.checked === true){
             for ( var i = 1; i < checkboxes.length; i++ ){
                checkboxes[i].checked = true;
                //EVT.emit('clickEmmit');
             }
           }

        });
        */
        //console.log(filters.length)
        for ( var i = 1; i < checkboxes.length; i++ ){
          /*
            if(checkboxes[i].checked === false) {

                filters.pop(parseInt(checkboxes[i].dataset.id));
            } else if(checkboxes[i].checked === true) {
                filters.push(parseInt(checkboxes[i].dataset.id));
            }
            */
            checkboxes[i].addEventListener('click', function(evt) {
              //hasRun = 1;
              //run = 'true';
              evt.stopPropagation();
              evt.stopImmediatePropagation();
                if(this.checked === false) {

                    filters.pop(parseInt(this.dataset.id));
                    Activities.setActivitiesVisibility(Activities.current_polygon, filters)
                } else if(this.checked === true) {
                    filters.push(parseInt(this.dataset.id));
                    Activities.setActivitiesVisibility(Activities.current_polygon, filters)
                    //evt.target.checked =false;
                }
            });
        }
    }

    function filterByCategory(filters, RECORDS) {


      /*
        if ($.inArray(evt.target.dataset.id, Activities.categoryIdArr) === -1) {
            Activities.categoryIdArr.push(evt.target.dataset.id);
        } else {
            Activities.categoryIdArr.pop(Activities.categoryIdArr[evt.target.dataset.id]);
        }
          //Activities.makeCatFiltering(Activities.categoryIdArr);
        Activities.setActivitiesVisibility(Activities.current_polygon, Activities.categoryIdArr);

      console.log(activities);
      var Arr = [];
      var Brr = [];
      var found = 0;
      for (var i = 0; i < activities.length; i += 1 ) {
        for (var z = 0; z < filters.length; z += 1 ) {
          if(activities[i].marker.db_data.category_id === filters[z] ){
            //Activities.setActivitiesVisibility(Activities.current_polygon );
            //console.log(activities[i].marker.db_data.category_id)
            Activites.filterActivities(Activities.yearRangeBuffer, filters);
          }
        }
      }*/


    }

    var accesor, range, activities, category_filters, input_filters = [], hasRun = 0;
    //EVT.on('init-filter', setupFilter);

    return {
      initSliderFilter :initSliderFilter,
      initCategoryFilters :initCategoryFilters,
      count : countFacts,
      filterByCategory : filterByCategory,
      activities,
      category_filters,
      input_filters,
      hasRun
    }

})
