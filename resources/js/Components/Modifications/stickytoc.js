;( function ( window, document, $, mw, undefined ) {
	var $toc = $( '#toc' ),
		float = mw.config.get( 'egChameleonStickyTOCFloat' ),
		forceSticky = mw.config.get( 'egChameleonStickyTOCNavbar' ),
		replaceTitle = mw.config.get( 'egChameleonStickyTOCReplaceTitle' ),
		articleTitle = mw.config.get( 'wgTitle' ),
		$wrapper,
		$parent;

	if ( $toc.length ) {

		if ( replaceTitle && articleTitle ) {
			$toc.find( '#mw-toc-heading' ).text( articleTitle );
		}

		$toc.insertBefore( '#content' );
		$wrapper = $( '<div/>' )
			.addClass( 'sticky-top' )
			.addClass( 'stickytoc' )
			.addClass( 'stickytoc-pull-' + float );
		if ( float === 'aside' ) {
			$parent = $toc.parent();
			$parent.addClass( 'stickytoc-parent' );
		}
		if ( forceSticky ) {
			$wrapper.addClass( 'force-sticky' );
		}
		$toc.wrap( $wrapper );
	}
}( window, document, jQuery, mediaWiki ) );
