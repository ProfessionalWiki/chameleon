<?php

namespace Skins\Chameleon\Components;

use Linker;
use Skins\Chameleon\IdRegistry;

/**
 * File holding the NavMenu class
 *
 * @copyright (C) 2014, Stephan Gambke
 * @license       http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
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
 * @ingroup       Skins
 */

/**
 * The NavMenu class.
 *
 *
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
			$flatten = array_map( trim, explode( ';', $msg->plain() ) );
		} elseif ( $this->getDomElement() !== null ) {
			$flatten = array_map( trim, explode( ';', $this->getDomElement()->getAttribute( 'flatten' ) ) );
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

		$menuitems = '';

		// build the list of submenu items
		if ( is_array( $box[ 'content' ] ) && count( $box[ 'content' ] ) > 0 ) {

			$this->indent( $flatten ? 0 : 2 );

			foreach ( $box[ 'content' ] as $key => $item ) {
				$menuitems .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item );
			}

			$this->indent( $flatten ? 0 : -2 );

		} else {
			$menuitems .= $this->indent() . '<!-- empty -->';
		}

		if ( $flatten ) {
			// if the menu is to be flattened, just return the introducing comment and the list of menu items as is

			$ret .= $menuitems;

		} elseif ( !is_array( $box[ 'content' ] ) || count( $box[ 'content' ] ) === 0 ) {
			//if the menu is not to be flattened, but is empty, return an inert link

			$ret .= $this->indent() . \Html::rawElement( 'li',
					array(
						'class' => '',
						'title' => Linker::titleAttrib( $box[ 'id' ] )
					),
					'<a href="#">' . htmlspecialchars( $box[ 'header' ] ) . '</a>'
				);

		} else {

			// open list item containing the dropdown
			$ret .= $this->indent() . \Html::openElement( 'li',
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

			// add list of menu items
			$ret .= $menuitems;

			// close list of dropdown menu items and the list item containing the dropdown
			$ret .=
				$this->indent() . '</ul>' .
				$this->indent( -1 ) . '</li>';
		}

		return $ret;
	}

}
