<?php
/**
 * File containing the Toolbox class
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

namespace Skins\Chameleon\Components\NavbarHorizontal;

use Hooks;
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
			//$this->addClasses( 'dropdown-menu' );
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
		// FIXME: Do we need to care of dropdown menus here? E.g. RSS feeds?
		foreach ( $skinTemplate->getToolbox() as $key => $linkItem ) {
			if ( isset( $linkItem[ 'class' ] ) ) {
				$linkItem[ 'class' ] .= ' nav-item';
			} else {
				$linkItem[ 'class' ] = 'nav-item';
			}
			$listItems[] = $this->indent() . $skinTemplate->makeListItem( $key, $linkItem, [ 'link-class' => 'nav-link', 'tag' => 'div' ] );
		}

		ob_start();
		// We pass an extra 'true' at the end so extensions using BaseTemplateToolbox
		// can abort and avoid outputting double toolbox links
		// See BaseTemplate::getSideBar()
		Hooks::run( 'SkinTemplateToolboxEnd', [ &$skinTemplate, true ] );
		$contents = ob_get_contents();
		ob_end_clean();

		if ( trim( $contents ) ) {
			$listItems[] = $this->indent() . $contents;
		}

		$this->indent( -$indent );

		return $listItems;
	}

	/**
	 * @param $labelMsg
	 * @param $list
	 *
	 * @return string
	 * @throws \MWException
	 */
	private function wrapDropdownMenu( $labelMsg, $list ) {

		$trigger = $this->indent( 1 ) . IdRegistry::getRegistry()->element(
				'a',
				[ 'href' => '#', 'class' => 'nav-link dropdown-toggle p-tb-toggle', 'data-toggle' => 'dropdown', 'data-boundary' => 'viewport' ],
				$this->getSkinTemplate()->getMsg( $labelMsg )->escaped()
			);

		$liElement = IdRegistry::getRegistry()->element( 'div', [ 'class' => 'dropdown-menu' ], $list, $this->indent() );
		$ulElement = IdRegistry::getRegistry()->element( 'div', [ 'class' => 'nav-item p-tb-dropdown ' . $this->getClassString() ], $trigger . $liElement, $this->indent( -1 ) );

		return $ulElement;
	}

}
