jQuery(document).ready(function() {

	// define our variables
	var fullHeightMinusHeader = 0;

	// create function to calculate ideal height values
	function calcHeights() {

		// set height of main columns
		fullHeightMinusHeader = jQuery(window).height() - jQuery("#head").outerHeight();
		jQuery("#container, #page").height(fullHeightMinusHeader);


	} // end calcHeights function

	// run on page load
	calcHeights();

	// run on window resize event
	jQuery(window).resize(function() {
		calcHeights();
	});

});
