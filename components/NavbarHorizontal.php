<?php
/**
 * File holding the NavbarHorizontal class
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
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
 * @ingroup   Skins
 */

namespace skins\chameleon\components;

use Linker;
use Sanitizer;

/**
 * The NavbarHorizontal class.
 *
 * A horizontal navbar containing the sidebar items.
 * Does not include standard items (toolbox, search, language links). They need to be added to the page elsewhere
 *
 * The navbar is a list of lists wrapped in a nav element: <nav role="navigation" id="p-navbar" >
 *
 * @ingroup Skins
 */
class NavbarHorizontal extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$ret = $this->indent() . '<!-- navigation bar -->' .
			   $this->indent() . '<nav class="navbar navbar-default p-navbar ' . $this->getClass() . '" role="navigation" id="p-navbar" >' .
			   $this->indent( 1 ) . '<ul class="nav navbar-nav">';

		$this->indent( 1 );
		$sidebar = $this->getSkinTemplate()->getSidebar( array( 'search' => false, 'toolbox' => false, 'languages' => false ) );

		// create a dropdown for each sidebar box
		foreach ( $sidebar as $boxName => $box ) {

			$ret .= $this->getDropdown( $boxName, $box );
		}

		$ret .= $this->indent( -1 ) . '</ul>' .
				$this->indent( -1 ) . '</nav>' . "\n";

		return $ret;
	}

	/**
	 * Create a single dropdown
	 *
	 * @param $boxName
	 * @param $box
	 *
	 * @return string
	 */
	private function getDropdown( $boxName, $box ) {

		// open list item containing the dropdown
		$ret = $this->indent() . '<!-- ' . $boxName . ' -->' .
			   $this->indent() . \Html::openElement( 'li',
					array(
						 'class' => 'dropdown',
						 'id'    => Sanitizer::escapeId( $box[ 'id' ] ),
						 'title' => Linker::titleAttrib( $box[ 'id' ] )
					) );

		$this->indent( 1 );
		if ( is_array( $box[ 'content' ] ) && count( $box[ 'content' ] ) > 0 ) {

			// the dropdown toggle
			$ret .= $this->indent() . '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' .
					htmlspecialchars( $box[ 'header' ] ) . ' <b class="caret"></b></a>';

			// open list of dropdown menu items
			$ret .= $this->indent() . '<ul class="dropdown-menu">';

			// output dropdown menu items
			$this->indent( 1 );
			foreach ( $box[ 'content' ] as $key => $item ) {
				$ret .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item );
			}

			// close list of dropdown menu items
			$ret .= $this->indent( -1 ) . '</ul>';

		} else {
			$ret .= $this->indent() . '<a href="#">' . htmlspecialchars( $box[ 'header' ] ) . '</a>';
		}
		$this->indent( -1 );

		// close list item
		$ret .= $this->indent() . '</li>';

		return $ret;
	}

}
