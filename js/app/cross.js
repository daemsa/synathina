var Cross = ( function(global){

   function showCross() {
      cross = document.querySelector("[rel='js-cross']");
      classie.addClass(cross, 'shown');
   }
   function hideCross() {
      cross = document.querySelector("[rel='js-cross']");
      classie.removeClass(cross, 'shown');
   }
   function getData() {
      details = arguments[0];
      renderData(details);
   }
   function renderData(details) {
      content_population = document.querySelector("[rel='js-population']");
      content_teams = document.querySelector("[rel='js-teams']");
      content_activities = document.querySelector("[rel='js-activities']");

      content_population.innerHTML = details.population;
      content_teams.innerHTML = details.teams;
      content_activities.innerHTML = details.activities;
   }
   var cross, details, content_population, content_teams, content_activities

   EVT.on( 'show-cross', showCross );
   EVT.on( 'hide-cross', hideCross );
   EVT.on('send-polygon-details', getData);

   return {
      showCross : showCross,
      hideCross : hideCross,
      getData : getData
   }

})(window)