<?php
/**
 * File holding the NavMenu class
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

namespace Skins\Chameleon\Components;

use Linker;
use Skins\Chameleon\IdRegistry;

/**
 * The NavMenu class.
 *
 * @author  Stephan Gambke
 * @since   1.0
 * @ingroup Skins
 */
class NavMenu extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return string the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {

		$ret = '';

		$sidebar = $this->getSkinTemplate()->getSidebar(
			[
				'search' => false,
				'toolbox' => false,
				'languages' => false,
			]
		);

		$flatten = $this->getMenusToBeFlattened();

		// create a dropdown for each sidebar box
		foreach ( $sidebar as $menuName => $menuDescription ) {
			$ret .= $this->getDropdownForNavMenu( $menuName, $menuDescription, array_search( $menuName, $flatten ) !== false );
		}

		return $ret;
	}

	/**
	 * Create a single dropdown
	 *
	 * @param string $menuName
	 * @param mixed[] $menuDescription
	 * @param bool $flatten
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function getDropdownForNavMenu( $menuName, $menuDescription, $flatten = false ) {

		// open list item containing the dropdown
		$ret = $this->indent() . '<!-- ' . $menuName . ' -->';

		if ( $flatten ) {

			$ret .= $this->buildMenuItemsForDropdownMenu( $menuDescription, $flatten );

		} elseif ( !$this->hasSubmenuItems( $menuDescription ) ) {

			$ret .= $this->buildDropdownMenuStub( $menuDescription );

		} else {

			$ret .= $this->buildDropdownOpeningTags( $menuDescription ) .
			        $this->buildMenuItemsForDropdownMenu( $menuDescription, $flatten, 1 ) .
			        $this->buildDropdownClosingTags();


		}

		return $ret;
	}

	/**
	 * @param mixed[] $menuDescription
	 * @param int $indent
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function buildMenuItemsForDropdownMenu( $menuDescription, $flatten = false, $indent = 0 ) {

		// build the list of submenu items
		if ( $this->hasSubmenuItems( $menuDescription ) ) {

			$menuitems = '';
			$this->indent( $indent );

			foreach ( $menuDescription['content'] as $key => $item ) {
				$menuitems .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item, [ 'tag' => 'div', 'class'=>'nav-item', 'link-class' => 'nav-link' ] );
			}

			$this->indent( - $indent );

			return $menuitems;

		} else {
			return $this->indent() . '<!-- empty -->';
		}
	}

	/**
	 * @param mixed[] $menuDescription
	 *
	 * @return bool
	 */
	protected function hasSubmenuItems( $menuDescription ) {
		return is_array( $menuDescription['content'] ) && count( $menuDescription['content'] ) > 0;
	}

	/**
	 * @param mixed[] $menuDescription
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function buildDropdownMenuStub( $menuDescription ) {
		return
			$this->indent() . \Html::rawElement( 'div',
				[
					'class' => 'nav-item',
					'title' => Linker::titleAttrib( $menuDescription[ 'id' ] )
				],
				'<a href="#" class="nav-link">' . htmlspecialchars( $menuDescription[ 'header' ] ) . '</a>'
			);
	}

	/**
	 * @param mixed[] $menuDescription
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function buildDropdownOpeningTags( $menuDescription ) {
		// open list item containing the dropdown
		$ret = $this->indent() . \Html::openElement( 'div',
				[
					'class' => 'nav-item dropdown',
					'title' => Linker::titleAttrib( $menuDescription['id'] ),
				] );

		// add the dropdown toggle
		$ret .= $this->indent( 1 ) . '<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" data-boundary="viewport">' .
		        htmlspecialchars( $menuDescription['header'] ) . '</a>';

		// open list of dropdown menu items
		$ret .=
			$this->indent() . \Html::openElement( 'div',
				[
					'class' => 'dropdown-menu ' . $menuDescription[ 'id' ],
					'id'    => IdRegistry::getRegistry()->getId( $menuDescription[ 'id' ] ),
				]
			);
		return $ret;
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildDropdownClosingTags() {
		return $this->indent() . '</div>' .
			$this->indent( - 1 ) . '</div>';
	}

	/**
	 * @return string[]
	 */
	public function getMenusToBeFlattened() {
		$msg = \Message::newFromKey( 'skin-chameleon-navmenu-flatten' );

		if ( $msg->exists() ) {
			$flatten = array_map( 'trim', explode( ',', $msg->plain() ) );
		} elseif ( $this->getDomElement() !== null ) {
			$flatten =
				array_map( 'trim',
					explode( ';', $this->getDomElement()->getAttribute( 'flatten' ) ) );
		} else {
			$flatten = [];
		}

		return $flatten;
	}

}
