$('.magnifying').magnificPopup({
  type: 'image'
  // other options
});
$('.magnifying-gallery').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: ''
		}
});
$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
	disableOn: 700,
	type: 'iframe',
	mainClass: 'mfp-fade',
	removalDelay: 160,
	preloader: false,

	fixedContentPos: false
});

//registration form validations
$( "#member-registration" ).submit(function( event ) {
  //alert( "Handler for .submit() called." );
	$('#jform_username').val($('#jform_email1').val());
	if($('#box1').is(':checked')||$('#box2').is(':checked')){
	}else{
		alert('Συμπληρώστε εάν θέλετε να διοργανώσετε ή/και να υποστηρίξετε δράσεις');
		return false;
	}	
	if($('#box3').is(':checked')||$('#box4').is(':checked')||$('#box41').is(':checked')){
	}else{
		alert('Συμπληρώστε τύπο ομάδας');
		return false;
	}
	if($('#box2').is(':checked')){
		var donations=0;
		$('input', $('.registration-donations')).each(function () {
			//console.log($(this)); //log every element found to console output
			if($(this).is(':checked')){
				donations=1;
			}
		});

		if(donations==0){
			alert('Συμπληρώστε τουλαχιστον μία προσφορά');
			return false;
		}
	}
	if($('#box8').is(':checked')||$('#box9').is(':checked')){
	}else{
		alert('Συμπληρώστε εάν έχετε νομική μορφή');
		return false;
	}	
	if($('#box8').is(':checked')){	
		if($('#box10').is(':checked')||$('#box11').is(':checked')){
			if($('#box10').is(':checked')){
				if($('#box-type-12').is(':checked')||$('#box-type-13').is(':checked')||$('#box-type-14').is(':checked')||$('#box150').val()!=''){
				}else{
					alert('Συμπληρώστε τη μη κερδοσκοπική νομική μορφή');
					return false;					
				}
			}
		}else{
			alert('Συμπληρώστε εάν έχετε κερδοσκοπική νομική μορφή');
			return false;
		}
	}
	var activities=0;
	$('input', $('.registration-activities')).each(function () {
		//console.log($(this)); //log every element found to console output
		if($(this).is(':checked')){
			activities=1;
		}
	});

	if(activities==0){
		alert('Συμπληρώστε τουλαχιστον μία δραστηριότητα');
		return false;
	}
	
	//return false;
	return;
  //event.preventDefault();
});






