/**
 * File: inspirations-filter.js
 *
 * Filter Custom Query results from filter dropdowns.
 */
window.inspirationsFilters = {};
( function( window, $, app ) {

	// Constructor.
	app.init = function() {
		app.cache();

		if ( app.meetsRequirements() ) {
			app.bindEvents();
		}
	};

	// Cache all the things.
	app.cache = function() {
		app.$c = {
			window: $( window ),
			body: $( document.body ),
			inspirationsFilter: $( '.inspirations-filters' ),
			inspirationIndustryFilters: $( '.inspiration-industry-filters' ),
			inspirationStyleFilters: $( '.inspiration-style-filters' ),
			inspirationColorFilters: $( '.inspiration-color-filters' )
		};
	};

	// Combine all events.
	app.bindEvents = function() {
		app.$c.inspirationIndustryFilters.on( 'change', app.inspirationsFilter );
		app.$c.inspirationStyleFilters.on( 'change', app.inspirationsFilter );
		app.$c.inspirationColorFilters.on( 'change', app.inspirationsFilter );
	};

	// Do we meet the requirements?
	app.meetsRequirements = function() {
		return app.$c.inspirationsFilter.length;
	};

	// Reload page with updated URL.
	app.inspirationsFilter = function( event ) {
		event.preventDefault();

		const industryValue = app.$c.inspirationIndustryFilters.val();
		const styleValue = app.$c.inspirationStyleFilters.val();
		const colorValue = app.$c.inspirationColorFilters.val();
		let cleanURL = '';
		let paramString = '';
		let params = new URLSearchParams();

		if ( industryValue ) {
			params.append( 'filter_industry', industryValue );
		}

		if ( styleValue ) {
			params.append( 'filter_style', styleValue );
		}

		if ( colorValue ) {
			params.append( 'filter_color', colorValue );
		}

		if ( params.toString() ) {
			paramString = '?' + params.toString();
		}

		// Adjust the URL if there's pagination going on.
		let regex = /page\/[0-9]*\//;
		cleanURL = window.location.pathname.indexOf( '/page/' ) ? window.location.href.replace( regex, '' ) : window.location.href;

		// Reload the page (reload) with new values.
		$( location ).attr( 'href', cleanURL.split( '?' )[0] + paramString );
	};

	// Engage!
	$( app.init );

}( window, jQuery, window.inspirationsFilters ) );
