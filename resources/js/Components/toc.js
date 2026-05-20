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
			targetLink.parents( '.nav.collapse' ).each( function () {
				bootstrap.Collapse.getOrCreateInstance( this ).show();
			} );
			goToLink( targetLink );
		}
	}

	function rearrangeToggleButtons() {
		// Move toggle buttons after collapsible nav for styling purposes.
		$( '.chameleon-toc .btn.toggle' ).each( function() {
			$( this ).insertAfter( $( this ).nextAll ( '.nav' ) );
		} );
	}

	function getScrollspyOffset() {
		var offset = parseFloat( $( '.chameleon-toc-wrapper' ).css( '--scrollspy-offset' ) );

		// TODO: re-test when using Sticky Modification.
		// var stickyNavbar = $( '.p-navbar[style*="position"]' );
		// if ( stickyNavbar.length > 0 ) {
		// 	offset += stickyNavbar.outerHeight();
		// }

		return isNaN( offset ) ? 0 : offset;
	}

	function getScrollspyTargets() {
		// Resolve each TOC nav link to its heading, sorted top-to-bottom.
		// The Top link (href "#") is excluded; it is handled explicitly as the
		// "above the first section" state.
		var targets = [];

		$( '.chameleon-toc a.nav-link' ).each( function () {
			var href = $( this ).attr( 'href' );

			if ( !href || href === '#' || href.indexOf( '#' ) === -1 ) {
				return;
			}

			var id = decodeURIComponent( href.substr( href.indexOf( '#' ) + 1 ) );
			var el = id ? document.getElementById( id ) : null;

			if ( el ) {
				targets.push( {
					link: this,
					top: el.getBoundingClientRect().top + window.pageYOffset
				} );
			}
		} );

		targets.sort( function ( a, b ) {
			return a.top - b.top;
		} );

		return targets;
	}

	function enableScrollspy() {
		// BS5's ScrollSpy is IntersectionObserver-based and has no `offset`
		// option. Reimplement the historical scroll-threshold behaviour:
		// the active section is the last heading whose top is at or above
		// `scrollTop + --scrollspy-offset`, and stays active until the next
		// heading crosses that line.
		var offset = getScrollspyOffset();

		function updateActiveSection() {
			var targets = getScrollspyTargets();

			if ( targets.length === 0 ) {
				return;
			}

			var threshold = window.pageYOffset + offset;
			var maxScroll = Math.max(
				document.documentElement.scrollHeight - window.innerHeight,
				0
			);
			var current = null;

			for ( var i = 0; i < targets.length; i++ ) {
				if ( targets[ i ].top <= threshold ) {
					current = targets[ i ].link;
				} else {
					break;
				}
			}

			// At the bottom the last heading can no longer cross the threshold;
			// pin it active.
			if ( window.pageYOffset >= maxScroll - 2 ) {
				current = targets[ targets.length - 1 ].link;
			}

			if ( current ) {
				goToLink( $( current ) );
			} else {
				goToLink( $( '.chameleon-toc a.top' ) );
			}
		}

		$( window ).on( 'scroll.chameleonToc resize.chameleonToc', updateActiveSection );
		updateActiveSection();
	}

	function addScrollspyEvent() {
		// Highlight and scroll to value in TOC when scrolling in body.
		$( window ).on( 'activate.bs.scrollspy', function ( e, obj ) {
			var clickedLink = $( '.chameleon-toc .clicked' );

			if ( clickedLink.length === 0 ) {
				return;
			}

			goToLink( clickedLink );
		});
	}

	function addWindowScrollEvent() {
		$( window ).on( 'scroll', function() {
			$( '.chameleon-toc a.clicked' ).removeClass( 'clicked' );

			var activeLink = $( '.chameleon-toc a.active' );

			if ( activeLink.length !== 0 ) {
				return;
			}

			goToLink( $( '.chameleon-toc a.top' ) );
		} );
	}

	function addTocLinkClickEvent() {
		$( '.chameleon-toc ul li a').on( 'click', function () {
			var href = $( this ).attr( 'href' );
			var anchor = href.substr( href.indexOf( '#' ) );

			// Trigger hashchange event when hash is the same (for sticky navbar).
			if ( window.location.hash === anchor ) {
				window.dispatchEvent( new HashChangeEvent( 'hashchange' ) );
			}

			$( '.chameleon-toc ul li a').removeClass( 'clicked' );
			$( this ).addClass( 'clicked' );

			goToLink( $( this ) );
		} );
	}

	function addToggleButtonClickEvent() {
		$( '.toclevel-1 .toggle' ).click( function () {
			$( this ).siblings( 'ul' ).each( function () {
				bootstrap.Collapse.getOrCreateInstance( this ).toggle();
			} );
		} );
	}

	$( function () {
		if ( window.outerWidth < 768 ) {
			$( '.chameleon-toc' ).remove();
			return;
		}

		$( '#bodyContent #toc' ).remove();

		rearrangeToggleButtons();
		enableScrollspy();
		addScrollspyEvent();
		addWindowScrollEvent();
		addTocLinkClickEvent();
		addToggleButtonClickEvent();
		setInitialLink();
	} );

}(window, document, jQuery, mediaWiki) );
