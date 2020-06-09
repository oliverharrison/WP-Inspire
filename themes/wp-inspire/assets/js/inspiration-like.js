/**
 * Inspiration Like functionality
 *
 * @author Oliver Harrison
 */
window.inspirationLike = {};
( function( window, $, app ) {

	// Constructor
	app.init = function() {
		app.cache();

		if ( app.meetsRequirements() ) {
			app.bindEvents();
		}
	};

	// Cache all the things
	app.cache = function() {
		app.$c = {
			window: $( window ),
			html: $( 'html' ),
			likeButton: $( '.like-this' )
		};
	};

	// Combine all events
	app.bindEvents = function() {
		app.$c.likeButton.on( 'click', app.updateLikes );
	};

	// Update the likes
	app.updateLikes = function( e ) {

		// Hit the endpoint
		$.ajax({
			type: 'POST',
			url: '/wp-json/inspire/v1/like/' + $( this ).data( 'id' ),
		}).done(function( data ) {
			// Get the new value and update the frontend
			$( e.currentTarget ).find( '.inspiration-likes' ).text( data );
			$( e.currentTarget ).find( '.icon-fill' ).css( 'opacity', (data/255).toFixed(2) );
			$( e.currentTarget ).find( '.icon' ).addClass( 'heartbeat' );
			setTimeout( function() {
				$( e.currentTarget ).find( '.icon' ).removeClass( 'heartbeat' );
			}, 400 );
		});
	};

	// Do we meet the requirements?
	app.meetsRequirements = function() {
		return app.$c.likeButton.length;
	};

	// Engage
	app.init();

} ( window, jQuery, window.inspirationLike ) );
