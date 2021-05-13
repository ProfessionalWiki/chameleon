/**
 * This file integrates the hc-sticky plugin with the Chameleon skin
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke
 * @license   GNU General Public License, version 3 (or any later version)
 *
 * The Chameleon skin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */


/*global window, document, jQuery, mediaWiki */

;( function (window, document, $, mw, undefined) {

    'use strict';

    mw.loader.using('skin.chameleon.sticky', function () {
		$('.sticky').hcSticky( {
			onStart: function ( e ) {
				// The hcSticky does not have any callbacks that we could use
				// as an indicator of the sticky block being fully attached
				// so add a little timeout before starting to calculate element height
				setTimeout( function( e ) {
					adjustScroll();
				}, 50 );
			}
		} );

		// Reposition sticky if the page is loaded with a URI fragment.
	    if ( $( location ).attr( 'hash' ) != '' ) {
		    $( '.sticky' ).hcSticky( 'refresh' );
	    }
    });

	/* Fixes sticky header overlaps the sections headers on anchor links */
	$( function () {
		$( window ).on( 'hashchange', function ( e ) {
			adjustScroll();
		} );
	} );

	function adjustScroll() {
		var $header = $( 'nav.p-navbar.sticky' ),
			headerHeight = $header.height() + 20,
			hash = window.location.hash.replace( '#', '' ),
			$target = $( '[id="' + hash + '"]' );

		if ( !$header.length || !hash || !$target.length ) {
			return;
		}

		$( 'html,body' ).animate( {
			scrollTop: $target.offset().top - headerHeight
		}, 250 );
	}

}(window, document, jQuery, mediaWiki) );
