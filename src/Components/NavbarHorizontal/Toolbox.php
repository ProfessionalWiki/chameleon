<?php
/**
 * File containing the Toolbox class
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

use Hooks;
use Linker;
use Skins\Chameleon\Components\Component;
use Skins\Chameleon\IdRegistry;

/**
 *
 * NavbarHorizontal\ToolbarHorizontal class
 *
 * Provides the toolbox to be included in the NavbarHorizontal.
 *
 * @author Stephan Gambke
 * @since 2.0
 * @ingroup Skins
 */
class Toolbox extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {
		$introComment = $this->indent() . '<!-- toolbox -->';

		if ( filter_var( $this->getAttribute( 'flatten' ), FILTER_VALIDATE_BOOLEAN ) ) {
			$this->addClasses( 'navbar-nav' );
			$linkList = implode( $this->getLinkListItems() );
		} else {
			// $this->addClasses( 'dropdown-menu' );
			$linkList = $this->wrapDropdownMenu( 'toolbox', implode( $this->getLinkListItems( 2 ) ) );
		}

		return $introComment . $linkList;
	}

	/**
	 * @param int $indent
	 *
	 * @return string[]
	 * @throws \FatalError
	 * @throws \MWException
	 */
	private function getLinkListItems( $indent = 0 ) {
		$this->indent( $indent );

		$skinTemplate = $this->getSkinTemplate();

		$listItems = [];
		$toolbox = $skinTemplate->get( 'sidebar' )[ 'TOOLBOX' ] ?? array();

		// FIXME: Do we need to care of dropdown menus here? E.g. RSS feeds?
		foreach ( $toolbox as $key => $linkItem ) {
			if ( isset( $linkItem[ 'class' ] ) ) {
				$linkItem[ 'class' ] .= ' nav-item';
			} else {
				$linkItem[ 'class' ] = 'nav-item';
			}
			// Add missing id for legacy links
			if ( !isset( $linkItem[ 'id' ] ) ) {
				$linkItem[ 'id' ] = 't-' . $key;
			}
			$listItems[] = $this->indent() . $skinTemplate->makeListItem( $key, $linkItem,
				[ 'link-class' => 'nav-link ' . $linkItem[ 'id' ], 'tag' => 'div' ] );
		}

		$this->indent( -$indent );

		return $listItems;
	}

	/**
	 * @param string $labelMsg
	 * @param string $contents
	 *
	 * @return string
	 * @throws \MWException
	 */
	private function wrapDropdownMenu( $labelMsg, $contents ) {
		$trigger = $this->indent( 1 ) . IdRegistry::getRegistry()->element(
				'a',
				[ 'href' => '#', 'class' => 'nav-link dropdown-toggle p-tb-toggle',
                  'data-toggle' => 'dropdown', 'data-boundary' => 'viewport',
                  'title' => Linker::titleAttrib( 'p-tb' ), ],
				$this->getSkinTemplate()->getMsg( $labelMsg )->escaped()
			);

		$liElement = IdRegistry::getRegistry()->element( 'div', [ 'class' => 'dropdown-menu' ], $contents,
			$this->indent() );
		$ulElement = IdRegistry::getRegistry()->element( 'div',
			[ 'class' => 'nav-item p-tb-dropdown ' . $this->getClassString() ], $trigger . $liElement,
			$this->indent( -1 ) );

		return $ulElement;
	}

}
