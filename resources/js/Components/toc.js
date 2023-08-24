/**
 * This file integrates the hc-sticky plugin with the Chameleon skin
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2023, Morne Alberts
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
 * @author Morne Alberts
 * @since 3.5
 * @ingroup Skins
 */


/*global window, document, jQuery, mediaWiki */

;( function (window, document, $, mw, undefined) {

    'use strict';

	$( function () {
		if ( window.outerWidth < 768 ) {
			$( '.chameleon-toc' ).remove();
			return;
		}

		$( '#bodyContent #toc' ).remove();

		var offset = 30;
		var stickyNavbar = $( '.p-navbar[style*="position' );
		if ( stickyNavbar.length > 0 ) {
			offset += stickyNavbar.outerHeight();
		}

		$( 'body' ).scrollspy( { target: '.chameleon-toc', offset: offset } );

		// Trigger hashchange event when hash is the same.
		$( '#toc ul li a').on( 'click', function ( e ) {
			const href = $( this ).attr( 'href' );
			const anchor = href.substr( href.indexOf( '#' ) );

			if ( window.location.hash === anchor ) {
				window.dispatchEvent( new HashChangeEvent( 'hashchange' ) );
			}
		} );
	} );


}(window, document, jQuery, mediaWiki) );
