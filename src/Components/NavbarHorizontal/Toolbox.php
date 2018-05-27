<?php
/**
 * File containing the Toolbox class
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
	 * @throws \FatalError
	 * @throws \MWException
	 */
	public function getHtml() {

		$introComment = $this->indent() . '<!-- toolbox -->';

		if ( filter_var( $this->getAttribute( 'flatten' ),FILTER_VALIDATE_BOOLEAN ) ) {
			$this->addClasses( 'navbar-nav' );
			$linkList = $this->getLinkList();
		} else {
			$this->addClasses( 'dropdown-menu' );
			$linkList = $this->wrapDropdownMenu( 'toolbox', $this->getLinkList( 2 ) );
		}

		return $introComment . $linkList;
	}

	/**
	 * @param string $class
	 * @param int $indent
	 *
	 * @return string
	 * @throws \MWException
	 */
	private function getLinkList( $indent = 0 ) {

		$this->indent( $indent );
		$linkList = IdRegistry::getRegistry()->element( 'ul', [ 'class' => $this->getClassString(), 'id' => 'p-tb' ], implode( $this->getLinkListItems() ), $this->indent() );
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
		// FIXME: Do we need to care of dropdown menus here? E.g. RSS feeds?
		foreach ( $skinTemplate->getToolbox() as $key => $linkItem ) {
			$listItems[] = $this->indent() . $skinTemplate->makeListItem( $key, $linkItem, [ 'link-class' => 'nav-link' ] );
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

		$this->indent( -1 );
		return $listItems;
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	private function wrapDropdownMenu( $labelMsg, $list ) {

		$icon = '<i></i>';
		$trigger = $this->indent( 2 ) . IdRegistry::getRegistry()->element( 'a', [ 'href' => '#', 'class' => 'nav-link dropdown-toggle', 'data-toggle' => 'dropdown' ], $icon . $this->getSkinTemplate()->getMsg( $labelMsg )->escaped() );

		$liElement = IdRegistry::getRegistry()->element( 'li', [], $trigger . $list, $this->indent( -1 ) );
		$ulElement = IdRegistry::getRegistry()->element( 'ul', [ 'class' => 'navbar-nav p-tb-dropdown' ], $liElement, $this->indent( -1 ) );

		return $ulElement;
	}

}
