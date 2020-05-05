<?php
/**
 * File holding the NavbarHorizontal class
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
 * @ingroup   Skins
 */

namespace MediaWiki\Skins\Chameleon\Components;

use DOMElement;
use MediaWiki\Skins\Chameleon\IdRegistry;

/**
 * The NavbarHorizontal class.
 *
 * A horizontal navbar containing the sidebar items.
 * Does not include standard items (toolbox, search, language links). They need
 * to be added to the page elsewhere
 *
 * The navbar is a list of lists wrapped in a nav element: <nav
 * role="navigation" id="p-navbar" >
 *
 * @author  Stephan Gambke
 * @since   1.0
 * @ingroup Skins
 */
class NavbarHorizontal extends Component {

	private $mHtml = null;
	private $htmlId = null;

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {

		if ( $this->mHtml === null ) {
			$this->buildHtml();
		}

		return $this->mHtml;
	}

	/**
	 * @throws \MWException
	 */
	protected function buildHtml() {

		if ( $this->getDomElement() === null ) {
			$this->mHtml = '';
			return;
		}

		$this->mHtml =
			$this->buildNavBarOpeningTags() .
			$this->buildNavBarComponents() .
			$this->buildNavBarClosingTags();
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildNavBarOpeningTags() {
		if ( $this->isCollapsible() ) {
			$class = 'collapsible ';
		} else {
			$class = 'not-collapsible ';
		}

		$class = ' p-navbar ' . $class . $this->getClassString();

		$openingTags =
			$this->indent() . '<!-- navigation bar -->' .
			$this->indent() . \Html::openElement( 'nav', [
					'class' => $class,
					'role'  => 'navigation',
					'id'    => $this->getHtmlId() // FIXME: ID to be repeated in classes
				]
			);

		$this->indent( 1 );

		return $openingTags;
	}

	/**
	 * @return string
	 */
	private function getHtmlId() {
		if ( $this->htmlId === null ) {
			$this->htmlId = IdRegistry::getRegistry()->getId( 'mw-navigation' );
		}
		return $this->htmlId;
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildNavBarComponents() {

		$elements = $this->buildNavBarElementsFromDomTree();

		$head = $this->buildHead( $elements[ 'head' ] );

		if ( $this->isCollapsible() ) {
			$tail = $this->wrapDropdownMenu( $this->buildTail( $elements[ 'left' ], $elements[ 'right' ], 1 ) );
		} else {
			$tail = $this->buildTail( $elements[ 'left' ], $elements[ 'right' ] );
		}

		return $head . $tail;
	}

	/**
	 * @return string[][]
	 * @throws \MWException
	 */
	protected function buildNavBarElementsFromDomTree() {

		$elements = [
			'head'  => [],
			'left'  => [],
			'right' => [],
		];

		/** @var DOMElement[] $children */
		$children = $this->getDomElement()->hasChildNodes() ? $this->getDomElement()->childNodes : [];

		// add components
		foreach ( $children as $node ) {
			$this->buildAndCollectNavBarElementFromDomElement( $node, $elements );
		}
		return $elements;
	}

	/**
	 * @param DOMElement $node
	 * @param $elements
	 *
	 * @throws \MWException
	 */
	protected function buildAndCollectNavBarElementFromDomElement( $node, &$elements ) {

		if ( $node instanceof DOMElement && $node->tagName === 'component' && $node->hasAttribute( 'type' ) ) {

			$position = $node->getAttribute( 'position' );

			if ( !array_key_exists( $position, $elements ) ) {
				$position = 'left';
			}

			$indentation = 0;

			if ( $position !== 'head' && $this->isCollapsible() ) {
				$indentation++;
			}

			if ( $position === 'right' ) {
				$indentation++;
			}

			$this->indent( $indentation );
			$html = $this->buildNavBarElementFromDomElement( $node );
			$this->indent( -$indentation );

			$elements[ $position ][] = $html;

		// } else {
			// TODO: Warning? Error?
		}
	}

	/**
	 * @param \DomElement $node
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function buildNavBarElementFromDomElement( $node ) {
		return $this->getSkin()->getComponentFactory()->getComponent( $node, $this->getIndent() )->getHtml();
	}

	/**
	 * @param string[] $headElements
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function buildHead( $headElements ) {

		return implode( '', $headElements );
	}

	/**
	 * @param string[] $leftElements
	 * @param string[] $rightElements
	 * @param int $indent
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function buildTail( $leftElements = [], $rightElements = [], $indent = 0 ) {

		$this->indent( $indent );

		$tail = '';

		if ( $leftElements ) {
			$tail .= IdRegistry::getRegistry()->element( 'div', [ 'class' => 'navbar-nav' ], implode( '', $leftElements ), $this->indent() );
		}

		if ( $rightElements ) {
			$tail .= IdRegistry::getRegistry()->element( 'div', [ 'class' => 'navbar-nav right' ], implode( '', $rightElements ), $this->indent() );
		}

		$this->indent( -$indent );

		return $tail;

	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildNavBarClosingTags() {
		return
			$this->indent( -1 ) . '</nav>';
	}

	/**
	 * @param $tail
	 *
	 * @return string
	 * @throws \MWException
	 */
	private function wrapDropdownMenu( $tail ) {

		$id = IdRegistry::getRegistry()->getId();

		return
			$this->indent() . '<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#' . $id . '"></button>' .
			IdRegistry::getRegistry()->element( 'div', ['class'=>'collapse navbar-collapse', 'id'=> $id ], $tail, $this->indent() );
	}

	/**
	 * @return mixed
	 */
	protected function isCollapsible() {
		return filter_var( $this->getAttribute( 'collapsible', true ), FILTER_VALIDATE_BOOLEAN );
	}

}
