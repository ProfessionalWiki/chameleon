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

		var offset = 179;
		var stickyNavbar = $( '.p-navbar[style*="position"]' );
		if ( stickyNavbar.length > 0 ) {
			offset += stickyNavbar.outerHeight();
		}

		$( 'body' ).scrollspy( { target: '.chameleon-toc', offset: offset } );

		function goToLink( $link ) {
			var $activeLink = $( '.chameleon-toc .active' );

			if ( $activeLink.last().is( $link ) ) {
				return;
			}

			$activeLink.removeClass( 'active' );

			$link.addClass( 'active' );
			$link.parents( '.nav' ).prev( '.nav-link'  + ", " +  '.list-group-item' ).addClass( 'active' );
			$link.parents( '.nav' ).prev( '.nav-item' ).children( '.nav-link' ).addClass( 'active' );
		}

		function getCurrentHash() {
			var hash = window.location.hash;
			return hash.substring( hash.indexOf( '#' ) )
		}

		function setInitialLink() {
			var hash = getCurrentHash();
			var activeLink = $('.chameleon-toc a.active');
			var targetLink;

			if ( hash === '' && activeLink.length === 0) {
				targetLink = $( '.chameleon-toc a.top' );
			} else {
				targetLink = $( '.chameleon-toc a[href="' + hash + '"]' );
			}
			if ( targetLink.length !== 0 ) {
				goToLink( targetLink );
			}
		}

		$( window ).on( 'scroll', function() {
			$( '.chameleon-toc a.clicked' ).removeClass( 'clicked' );

			var activeLink = $( '.chameleon-toc a.active' );

			if ( activeLink.length !== 0 ) {
				return;
			}

			goToLink( $( '.chameleon-toc a.top' ) );
		} );

		$( '.chameleon-toc ul li a').on( 'click', function () {
			const href = $( this ).attr( 'href' );
			const anchor = href.substr( href.indexOf( '#' ) );

			// Trigger hashchange event when hash is the same (for sticky navbar).
			if ( window.location.hash === anchor ) {
				window.dispatchEvent( new HashChangeEvent( 'hashchange' ) );
			}

			$( '.chameleon-toc ul li a').removeClass( 'clicked' );
			$( this ).addClass( 'clicked' );

			goToLink( $( this ) );
		} );

		// Highlight and scroll to value in TOC when scrolling in body.
		$( window ).on( 'activate.bs.scrollspy', function ( e, obj ) {
			var clickedLink = $( '.chameleon-toc .clicked' );

			if ( clickedLink.length === 0 ) {
				return;
			}

			goToLink( clickedLink );
		});

		setInitialLink();
	} );


}(window, document, jQuery, mediaWiki) );
