<?php
/**
 * File containing the NavbarHorizontal\LangLinks class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke
 * @license   GPL-3.0-or-later
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

		if ( filter_var( $this->getAttribute( 'flatten' ), FILTER_VALIDATE_BOOLEAN ) ) {
			$languageLinks = implode( $this->getLinkListItems() );
		} else {
			$languageLinks = $this->wrapDropdownMenu( 'otherlanguages',
				implode( $this->getLinkListItems() ) );
		}

		return $introComment . $languageLinks;
	}

	/**
	 * @return bool
	 */
	private function hasLangLinks() {
		return array_key_exists( 'language_urls', $this->getSkinTemplate()->data ) &&
			( $this->getSkinTemplate()->data[ 'language_urls' ] );
	}

	/**
	 * @return string[]
	 * @throws \MWException
	 */
	private function getLinkListItems() {
		$this->indent( 2 );

		$skinTemplate = $this->getSkinTemplate();

		$listItems = [];
		foreach ( $skinTemplate->data[ 'language_urls' ] as $key => $linkItem ) {
			if ( isset( $linkItem['class'] ) ) {
				$linkItem['class'] .= ' nav-item';
			} else {
				$linkItem['class'] = 'nav-item';
			}
			$listItems[] = $this->indent() . $skinTemplate->makeListItem( $key, $linkItem,
				[ 'link-class' => 'nav-link ' , 'tag' => 'div' ] );
		}

		$this->indent( -2 );

		return $listItems;
	}

	/**
	 * @param string $labelMsg
	 * @param string $contents
	 * @return string
	 * @throws \MWException
	 */
	private function wrapDropdownMenu( $labelMsg, $contents ) {
		$trigger = $this->indent( 1 ) . IdRegistry::getRegistry()->element(
				'a',
				[
					'href' => '#',
					'class' => 'nav-link dropdown-toggle p-lang-toggle',
					'data-toggle' => 'dropdown',
					'data-boundary' => 'viewport'
				],
				$this->getSkinTemplate()->getMsg( $labelMsg )->escaped()
			);

		$liElement = IdRegistry::getRegistry()->element( 'div', [ 'class' => 'dropdown-menu' ], $contents,
			$this->indent() );
		$ulElement = IdRegistry::getRegistry()->element( 'div',
			[ 'class' => 'nav-item p-lang-dropdown ' . $this->getClassString() ],
			$trigger . $liElement, $this->indent( -1 ) );

		return $ulElement;
	}

}
