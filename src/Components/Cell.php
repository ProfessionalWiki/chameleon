<?php
/**
 * File holding the Cell class
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
 * @file
 * @ingroup Skins
 */

namespace MediaWiki\Skins\Chameleon\Components;

use MediaWiki\Skins\Chameleon\ChameleonTemplate;

/**
 * The Cell class.
 *
 * @ingroup Skins
 */
class Cell extends Container {

	public function __construct( ChameleonTemplate $template, \DOMElement $domElement = null, $indent = 0 ) {

		// FIXME: A single "span" attribute was probably misguided for multiple screen sizes. Better approach?

		//if ( !is_null( $domElement ) ) {
		//
		//	$span = $domElement->getAttribute( 'span' );
		//
		//	if ( ( !is_int( $span ) && !ctype_digit( $span ) ) || ( $span < 1 ) || ( $span > 12 ) ) {
		//		$span = '12'; // FIXME: If the span attribute is not (properly) specified, just add class "col"
		//	}
		//
		//} else {
		//	$span = '12'; // FIXME: If no DOM element is given, just add class "col"
		//}

		parent::__construct( $template, $domElement, $indent );

		//$this->addClasses( "col-lg-$span" );
		$this->addClasses( "col" );
	}

}
