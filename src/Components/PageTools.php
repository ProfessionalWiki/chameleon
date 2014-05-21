<?php

namespace Skins\Chameleon\Components;

use MWNamespace;
use Skins\Chameleon\ChameleonTemplate;
use Skins\Chameleon\IdRegistry;

/**
 * File holding the PageTools class
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki extension Chameleon.
 * The Chameleon extension is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Chameleon extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup   Skins
 */

/**
 * The PageTools class.
 *
 * A unordered list containing content navigation links (Page, Discussion, Edit, History, Move, ...)
 *
 * The tab list is a list of lists: '<ul id="p-contentnavigation">
 *
 * @ingroup Skins
 */
class PageTools extends Component {

	private $mFlat = false;

	public function __construct( ChameleonTemplate $template, \DOMElement $domElement = null, $indent = 0 ) {

		parent::__construct( $template, $domElement, $indent );

		// add classes for the normal case where the page tools are displayed as a first class element;
		// these classes should be removed if the page tools are part of another element, e.g. nav bar
		$this->addClasses( 'list-inline text-center' );
	}

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$navigation = $this->getSkinTemplate()->data[ 'content_navigation' ];

		$hideSelectedNameSpace = false;
		if ( $this->getDomElement() !== null ) {
			$hideSelectedNameSpace = filter_var( $this->getDomElement()->getAttribute( 'hideSelectedNameSpace' ), FILTER_VALIDATE_BOOLEAN );
		}

		if ( $hideSelectedNameSpace ) {
			$namespacekey = $this->getNamespaceKey();
			unset( $navigation['namespaces'][ $namespacekey ] );
		}

		$ret = '';

		$this->indent( 2 );
		foreach ( $navigation as $category => $tabs ) {

			// TODO: visually group all links of one category (e.g. some space between categories)

			if ( empty( $tabs ) ) {
				continue;
			}

			$ret .= $this->indent() . '<!-- ' . $category . ' -->';

			if ( !$this->mFlat ) {
				// output the name of the current category (e.g. 'namespaces', 'views', ...)
				$ret .= $this->indent() .
					\Html::openElement( 'li', array( 'id' => IdRegistry::getRegistry()->getId( 'p-' . $category ) ) ) .
					$this->indent( 1 ) . '<ul class="list-inline" >';

				$this->indent( 1 );
			}

			foreach ( $tabs as $key => $tab ) {

				// skip redundant links (i.e. the 'view' link)
				// TODO: make this dependent on an option
				if ( array_key_exists( 'redundant', $tab ) && $tab[ 'redundant' ] === true ) {
					continue;
				}

				// apply a link class if specified, e.g. for the currently active namespace
				$options = array();
				if ( array_key_exists( 'class', $tab ) ) {
					$options[ 'link-class' ] = $tab[ 'class' ];
				}

				$ret .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $tab, $options );

			}

			if ( !$this->mFlat ) {
				$ret .= $this->indent( -1 ) . '</ul>' .
						$this->indent( -1 ) . '</li>';
			}
		}
		$this->indent( -2 );

		if ( $ret !== '' ){
		$ret = $this->indent( 1 ) . '<!-- Content navigation -->' .
			$this->indent() .
			\Html::openElement( 'ul',
				array(
					'class' => 'p-contentnavigation ' . $this->getClassString(),
					'id' => IdRegistry::getRegistry()->getId( 'p-contentnavigation' ),
				) ) .
			$ret .
			$this->indent() . '</ul>';
		}

		return $ret;
	}

	/**
	 * Set the page tool menu to have submenus or not
	 *
	 * @param $flat
	 */
	public function setFlat( $flat ) {
		$this->mFlat = $flat;
	}

	/**
	 * Generate strings used for xml 'id' names in tabs
	 *
	 * Stolen from MW's Title::getNamespaceKey()
	 *
	 * Difference: This function here reports the actual namespace while the one in Title reports the subject namespace,
	 * i.e. no talk namespaces
	 *
	 * @return mixed|string
	 */
	public function getNamespaceKey() {
		global $wgContLang;

		// Gets the subject namespace if this title
		$namespace = $this->getSkinTemplate()->getSkin()->getTitle()->getNamespace();

		// Checks if canonical namespace name exists for namespace
		if ( MWNamespace::exists( $this->getSkinTemplate()->getSkin()->getTitle()->getNamespace() ) ) {
			// Uses canonical namespace name
			$namespaceKey = MWNamespace::getCanonicalName( $namespace );
		} else {
			// Uses text of namespace
			$namespaceKey = $this->getSkinTemplate()->getSkin()->getTitle()->getNsText();
		}

		// Makes namespace key lowercase
		$namespaceKey = $wgContLang->lc( $namespaceKey );
		// Uses main
		if ( $namespaceKey == '' ) {
			$namespaceKey = 'main';
		}
		// Changes file to image for backwards compatibility
		if ( $namespaceKey == 'file' ) {
			$namespaceKey = 'image';
		}
		return $namespaceKey;
	}


}
