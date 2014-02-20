<?php
/**
 * File holding the TabList class
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

/**
 * The TabList class.
 *
 * A unordered list containing content navigation links (Page, Discussion, Edit, History, Move, ...)
 *
 * The tab list is a list of lists: '<ul id="p-contentnavigation">
 *
 * @ingroup Skins
 */
class TabList extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$ret = $this->indent() . '<!-- Content navigation -->' .
			   $this->indent() . '<ul class="list-inline p-contentnavigation text-center ' . $this->getClass() . '" id="p-contentnavigation">';

		$navigation = $this->getSkinTemplate()->data[ 'content_navigation' ];

		$this->indent( 1 );
		foreach ( $navigation as $category => $tabs ) {

			// TODO: visually group all links of one category (e.g. some space between categories)

			if ( empty( $tabs ) ) {
				continue;
			}

			// output the name of the current category (e.g. 'namespaces', 'views', ...)
			$ret .= $this->indent() . '<!-- ' . $category . ' -->' .
					$this->indent() . '<li id="p-' . $category . '" >' .
					$this->indent( 1 ) . '<ul class="list-inline" >';

			$this->indent( 1 );
			foreach ( $tabs as $key => $tab ) {

				// skip redundant links (i.e. the 'view' link)
				// TODO: make this dependent on an option
				if ( array_key_exists( 'redundant', $tab ) && $tab[ 'redundant' ] === true ) {
					continue;
				}

				// apply a link class if specified, e.g. for the currently active namespace
				$options = array();
				if ( array_key_exists( 'class', $tab ) ) {
					$options[ 'link-class' ] = $tab[ 'class' ];
				}

				$ret .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $tab, $options );

			}

			$ret .= $this->indent( -1 ) . '</ul>' .
					$this->indent( -1 ) . '</li>';
		}

		$ret .= $this->indent( -1 ) . '</ul>' . "\n";

		return $ret;
	}

}
