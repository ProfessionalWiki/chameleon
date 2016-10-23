<?php
/**
 * File holding the PageTools class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2014, Stephan Gambke
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
 * @ingroup   Skins
 */

namespace Skins\Chameleon\Components;

use Action;
use MWNamespace;
use Skins\Chameleon\ChameleonTemplate;
use Skins\Chameleon\IdRegistry;

/**
 * The PageTools class.
 *
 * A unordered list containing content navigation links (Page, Discussion,
 * Edit, History, Move, ...)
 *
 * The tab list is a list of lists: '<ul id="p-contentnavigation">
 *
 * @author  Stephan Gambke
 * @since   1.0
 * @ingroup Skins
 */
class PageTools extends Component {

	private $mFlat = false;
	private $mPageToolsStructure = null;

	/**
	 * @param ChameleonTemplate $template
	 * @param \DOMElement|null $domElement
	 * @param int $indent
	 */
	public function __construct( ChameleonTemplate $template, \DOMElement $domElement = null, $indent = 0 ) {

		parent::__construct( $template, $domElement, $indent );

		// add classes for the normal case where the page tools are displayed as a first class element;
		// these classes should be removed if the page tools are part of another element, e.g. nav bar
		$this->addClasses( 'list-inline text-center' );
	}

	/**
	 * Builds the HTML code for this component
	 *
	 * @return string the HTML code
	 */
	public function getHtml() {

		$contentNavigation = $this->getPageToolsStructure();

		if ( $this->hideSelectedNamespace() ) {
			unset( $contentNavigation[ 'namespaces' ][ $this->getNamespaceKey() ] );
		}

		$ret = '';

		$this->indent( 2 );
		foreach ( $contentNavigation as $category => $tabsDescription ) {
			$ret .= $this->buildTabGroup( $category, $tabsDescription );
		}
		$this->indent( -2 );

		if ( $ret !== '' ) {
			$ret =
				$this->indent( 1 ) . '<!-- Content navigation -->' .
				$this->indent() . \Html::openElement( 'ul',
					array(
						'class' => 'p-contentnavigation ' . $this->getClassString(),
						'id'    => IdRegistry::getRegistry()->getId( 'p-contentnavigation' ),
					) ) .
				$ret .
				$this->indent() . '</ul>';
		}

		return $ret;
	}

	/**
	 * @return mixed
	 */
	public function &getPageToolsStructure() {
		if ( $this->mPageToolsStructure === null ) {
			$this->mPageToolsStructure = $this->getSkinTemplate()->get( 'content_navigation' , null );
		}
		return $this->mPageToolsStructure;
	}

	/**
	 * @return bool
	 */
	protected function hideSelectedNamespace() {
		return
			$this->getDomElement() !== null &&
			filter_var( $this->getDomElement()->getAttribute( 'hideSelectedNameSpace' ), FILTER_VALIDATE_BOOLEAN ) &&
			Action::getActionName( $this->getSkin() ) === 'view';
	}

	/**
	 * Generate strings used for xml 'id' names in tabs
	 *
	 * Stolen from MW's Title::getNamespaceKey()
	 *
	 * Difference: This function here reports the actual namespace while the
	 * one in Title reports the subject namespace, i.e. no talk namespaces
	 *
	 * @return string
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

	/**
	 * @param string $category
	 * @param mixed[][] $tabsDescription
	 *
	 * @return string
	 */
	protected function buildTabGroup( $category, $tabsDescription ) {
		// TODO: visually group all links of one category (e.g. some space between categories)

		if ( empty( $tabsDescription ) ) {
			return '';
		}

		$ret = $this->indent() . '<!-- ' . $category . ' -->';

		if ( !$this->mFlat ) {
			$ret .= $this->buildTabGroupOpeningTags( $category );

		}

		foreach ( $tabsDescription as $key => $tabDescription ) {
			$ret .= $this->buildTab( $tabDescription, $key );
		}

		if ( !$this->mFlat ) {
			$ret .= $this->buildTabGroupClosingTags();
		}
		return $ret;
	}

	/**
	 * @param string $category
	 *
	 * @return string
	 */
	protected function buildTabGroupOpeningTags( $category ) {
		// output the name of the current category (e.g. 'namespaces', 'views', ...)
		$ret = $this->indent() .
			\Html::openElement( 'li', array( 'id' => IdRegistry::getRegistry()->getId( 'p-' . $category ) ) ) .
			$this->indent( 1 ) . '<ul class="list-inline" >';

		$this->indent( 1 );
		return $ret;
	}

	/**
	 * @param mixed[] $tabDescription
	 * @param string $key
	 *
	 * @return string
	 */
	protected function buildTab( $tabDescription, $key ) {

		// skip redundant links (i.e. the 'view' link)
		// TODO: make this dependent on an option
		if ( array_key_exists( 'redundant', $tabDescription ) && $tabDescription[ 'redundant' ] === true ) {
			return '';
		}

		// apply a link class if specified, e.g. for the currently active namespace
		$options = array();
		if ( array_key_exists( 'class', $tabDescription ) ) {
			$options[ 'link-class' ] = $tabDescription[ 'class' ];
		}

		return $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $tabDescription, $options );

	}

	/**
	 * @return string
	 */
	protected function buildTabGroupClosingTags() {
		return $this->indent( -1 ) . '</ul>' .
		$this->indent( -1 ) . '</li>';
	}

	/**
	 * Set the page tool menu to have submenus or not
	 *
	 * @param boolean $flat
	 */
	public function setFlat( $flat ) {
		$this->mFlat = $flat;
	}

	/**
	 * Set the page tool menu to have submenus or not
	 *
	 * @param string|string[] $tools
	 */
	public function setRedundant( $tools ) {
		if ( is_string( $tools ) ) {
			$tools = array( $tools );
		}

		$pageToolsStructure = &$this->getPageToolsStructure();

		foreach ( $tools as $tool ) {
			foreach ( $pageToolsStructure as $group => $groupStructure ) {
				if ( array_key_exists( $tool, $groupStructure ) ) {
					$pageToolsStructure[ $group ][ $tool ][ 'redundant' ] = true;
				}
			}
		}
	}


}
