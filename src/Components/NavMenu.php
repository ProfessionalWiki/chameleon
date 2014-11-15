<?php
/**
 * File holding the NavMenu class
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
 * @ingroup Skins
 */

namespace Skins\Chameleon\Components;

use Linker;
use Skins\Chameleon\IdRegistry;

/**
 * The NavMenu class.
 *
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class NavMenu extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$ret = '';

		$sidebar = $this->getSkinTemplate()->getSidebar( array(
				'search' => false, 'toolbox' => false, 'languages' => false
			)
		);

		$msg = \Message::newFromKey( 'skin-chameleon-navmenu-flatten' );

		if ( $msg->exists() ) {
			$flatten = array_map( 'trim', explode( ';', $msg->plain() ) );
		} elseif ( $this->getDomElement() !== null ) {
			$flatten = array_map( 'trim', explode( ';', $this->getDomElement()->getAttribute( 'flatten' ) ) );
		} else {
			$flatten = array();
		}

		// create a dropdown for each sidebar box
		foreach ( $sidebar as $boxName => $box ) {

			$ret .= $this->getDropdownForNavMenu( $boxName, $box, array_search( $boxName, $flatten ) !== false );
		}

		return $ret;
	}

	/**
	 * Create a single dropdown
	 *
	 * @param string $boxName
	 * @param array  $box
	 * @param bool   $flatten
	 *
	 * @return string
	 */
	protected function getDropdownForNavMenu( $boxName, $box, $flatten = false ) {

		// open list item containing the dropdown
		$ret = $this->indent() . '<!-- ' . $boxName . ' -->';

		if ( $flatten ) {

			$ret .= $this->buildMenuItemsForDropdownMenu( $box );

		} elseif ( !$this->hasSubmenuItems( $box ) ) {

			$ret .= $this->buildDropdownMenuStub( $box, $ret );

		} else {

			$ret .= $this->buildDropdownOpeningTags( $box, $ret )
				. $this->buildMenuItemsForDropdownMenu( $box, 2 )
				. $this->buildDropdownClosingTags();


		}

		return $ret;
	}

	/**
	 * @param $box
	 * @return string
	 */
	protected function buildMenuItemsForDropdownMenu( $box, $indent = 0 ) {

		// build the list of submenu items
		if ( $this->hasSubmenuItems( $box ) ) {

			$menuitems = '';
			$this->indent( $indent );

			foreach ( $box[ 'content' ] as $key => $item ) {
				$menuitems .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item );
			}

			$this->indent( -$indent );
			return $menuitems;

		} else {
			return $this->indent() . '<!-- empty -->';
		}
	}

	/**
	 * @param $box
	 *
	 * @return bool
	 */
	protected function hasSubmenuItems( $box ) {
		return is_array( $box[ 'content' ] ) && count( $box[ 'content' ] ) > 0;
	}

	/**
	 * @param $box
	 *
	 * @return string
	 */
	protected function buildDropdownOpeningTags( $box ) {
		// open list item containing the dropdown
		$ret = $this->indent() . \Html::openElement( 'li',
				array(
					'class' => 'dropdown',
					'title' => Linker::titleAttrib( $box[ 'id' ] )
				)
			);

		// add the dropdown toggle
		$ret .= $this->indent( 1 ) . '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' .
			htmlspecialchars( $box[ 'header' ] ) . ' <b class="caret"></b></a>';

		// open list of dropdown menu items
		$ret .= $this->indent() .
			$this->indent() . \Html::openElement( 'ul',
				array(
					'class' => 'dropdown-menu ' . $box[ 'id' ],
					'id'    => IdRegistry::getRegistry()->getId( $box[ 'id' ] ),
				)
			);
		return $ret;
	}

	/**
	 * @return string
	 */
	protected function buildDropdownClosingTags() {
		return
			$this->indent() . '</ul>' .
			$this->indent( -1 ) . '</li>';
	}

	/**
	 * @param $box
	 * @return string
	 */
	protected function buildDropdownMenuStub( $box ) {
		return
			$this->indent() . \Html::rawElement( 'li',
				array(
					'class' => '',
					'title' => Linker::titleAttrib( $box[ 'id' ] )
				),
				'<a href="#">' . htmlspecialchars( $box[ 'header' ] ) . '</a>'
			);
	}

}
