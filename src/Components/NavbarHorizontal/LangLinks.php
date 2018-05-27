<?php
/**
 * File containing the NavbarHorizontal\LangLinks class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2018, Stephan Gambke
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

namespace Skins\Chameleon\Components\NavbarHorizontal;

use Skins\Chameleon\Components\Component;
use Skins\Chameleon\IdRegistry;

/**
 * NavbarHorizontal\LangLinks class
 *
 * Provides language links to be included in the NavbarHorizontal.
 *
 * @author Stephan Gambke
 * @since 2.0
 * @ingroup Skins
 */
class LangLinks extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {

		if ( !$this->hasLangLinks() ) {
			return '';
		}

		$introComment = $this->indent() . '<!-- languages -->';

		if ( filter_var( $this->getAttribute( 'flatten' ),FILTER_VALIDATE_BOOLEAN ) ) {
			$languageLinks = $this->getLinkList( 'navbar-nav ' . $this->getClassString() );
		} else {
			$languageLinks = $this->wrapDropdownMenu( 'otherlanguages', $this->getLinkList( 'dropdown-menu', 2 ) );
		}

		return $introComment . $languageLinks;
	}

	/**
	 * @return bool
	 */
	private function hasLangLinks() {
		return array_key_exists( 'language_urls', $this->getSkinTemplate()->data ) && ( $this->getSkinTemplate()->data[ 'language_urls' ] );
	}

	/**
	 *
	 * @return string
	 * @throws \MWException
	 */
	private function getLinkList( $class = '', $indent = 0 ) {

		$this->indent( $indent );
		$linkList = IdRegistry::getRegistry()->element( 'ul', [ 'class' => $class, 'id' => 'p-lang' ], implode( $this->getLinkListItems() ), $this->indent() );
		$this->indent( -$indent );

		return $linkList;
	}

	/**
	 * @return string[]
	 * @throws \MWException
	 */
	private function getLinkListItems() {

		$this->indent( 1 );

		$skinTemplate = $this->getSkinTemplate();

		$listItems = [];
		foreach ( $skinTemplate->data[ 'language_urls' ] as $key => $linkItem ) {
			$listItems[] = $this->indent() . $skinTemplate->makeListItem( $key, $linkItem, [ 'link-class' => 'nav-link' ] );
		}

		$this->indent( -1 );

		return $listItems;
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	private function wrapDropdownMenu( $labelMsg, $list ) {

		$trigger = $this->indent( 2 ) . IdRegistry::getRegistry()->element( 'a', [ 'href' => '#', 'class' => 'nav-link dropdown-toggle', 'data-toggle' => 'dropdown' ], $this->getSkinTemplate()->getMsg( $labelMsg )->escaped() );

		$liElement = IdRegistry::getRegistry()->element( 'li', [ 'class' => '' ], $trigger . $list, $this->indent( -1 ) );
		$ulElement = IdRegistry::getRegistry()->element( 'ul', [ 'class' => 'navbar-nav ' . $this->getClassString() ], $liElement, $this->indent( -1 ) );

		return $ulElement;
	}

}
