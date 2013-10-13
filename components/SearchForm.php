<?php
/**
 * File holding the SearchForm class
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

use \Linker;

/**
 * The SearchForm class.
 *
 * The search form wrapped in a div: <div id="p-search" role="search" >
 *
 * @ingroup Skins
 */
class SearchForm extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return string
	 */
	public function getHtml() {

		$ret = $this->indent() . '<!-- search form -->' .
			   $this->indent() . '<div id="p-search" class="pull-right p-search" ' . Linker::tooltip( 'p-search' ) . ' role="search" >' .
			   $this->indent( 1 ) . '<form id="searchform" class="mw-search form-inline" action="' .
			   $this->getSkinTemplate()->data[ 'wgScript' ] . '">' .
			   $this->indent( 1 ) . '<input type="hidden" name="title" value="' .
			   $this->getSkinTemplate()->data[ 'searchtitle' ] . '" />' .
			   $this->indent() . '<div class="form-group">' .
			   $this->indent( 1 ) .
			   $this->getSkinTemplate()->makeSearchInput( array( 'id' => 'searchInput', 'type' => 'text', 'class' => 'form-control' ) ) .
			   $this->indent( -1 ) . '</div>' .
			   $this->getGoButton() .
			   $this->getSearchButton() .
			   $this->indent( -1 ) . '</form>' .
			   $this->indent( -1 ) . '</div>' . "\n";

		return $ret;
	}

	private function getGoButton() {

		// For an image button use something like
		// $this->makeSearchButton( 'image', array( 'id' => 'searchButton', 'src' => $this->getSkin()->getSkinStylePath( 'images/searchbutton.png') );
		return $this->indent() . '<!-- The "Go" button -->' .
			   $this->indent() . $this->getSkinTemplate()->makeSearchButton( 'go', array( 'id' => 'searchGoButton', 'class' => 'searchButton btn btn-default' ) );
	}

	private function getSearchButton() {

		return $this->indent() . '<!-- The "Search" button -->' .
			   $this->indent() . $this->getSkinTemplate()->makeSearchButton( 'fulltext', array( 'id' => 'mw-searchButton', 'class' => 'searchButton btn btn-default' ) );
	}

}
