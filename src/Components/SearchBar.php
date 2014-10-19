<?php
/**
 * File holding the SearchBar class
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

use \Linker;
use Skins\Chameleon\IdRegistry;

/**
 * The SearchBar class.
 *
 * The search form wrapped in a div: <div id="p-search" role="search" >
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class SearchBar extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return string
	 */
	public function getHtml() {

		$ret = $this->indent() . '<!-- search form -->' .

			$this->indent() . '<div ' . \Html::expandAttributes( array(
					'id'    => IdRegistry::getRegistry()->getId( 'p-search' ),
					'class' => 'p-search ' . $this->getClassString(),
					'role'  => 'search',
				)
			) . Linker::tooltip( 'p-search' ) . '>' .

			$this->indent( 1 ) . '<form ' . \Html::expandAttributes( array(
					'id'    => IdRegistry::getRegistry()->getId( 'searchform' ),
					'class' => 'mw-search form-inline',
				)
			) . ' action="' . $this->getSkinTemplate()->data[ 'wgScript' ] . '">' .

			$this->indent( 1 ) . '<input type="hidden" name="title" value="' . $this->getSkinTemplate()->data[ 'searchtitle' ] . '" />' .
			$this->indent() . '<div class="input-group">' .
			$this->indent( 1 ) . $this->getSkinTemplate()->makeSearchInput( array( 'id' => IdRegistry::getRegistry()->getId( 'searchInput' ), 'type' => 'text', 'class' => 'form-control' ) ) .
			$this->indent() . '<div class="input-group-btn">' .
			$this->indent( 1 ) . $this->getSearchButton( 'go' ) . $this->getSearchButton( 'fulltext' ) .
			$this->indent( -1 ) . '</div>' .
			$this->indent( -1 ) . '</div>' .
			$this->indent( -1 ) . '</form>' .
			$this->indent( -1 ) . '</div>' . "\n";

		return $ret;
	}

	/**
	 * This method basically replicates SkinTemplate::makeSearchButton, but uses buttons instead of inputs to ensure
	 * proper styling by Bootstrap
	 *
	 * @param string $mode 'go' or 'fulltext', optional, default='fulltext'
	 *
	 * @return string
	 */
	private function getSearchButton( $mode = 'fulltext' ) {

		if ( $mode === 'go' ) {

			$buttonAttrs = array(
				'value' => $this->getSkinTemplate()->translator->translate( 'searcharticle' ),
				'id'    => IdRegistry::getRegistry()->getId( 'searchGoButton' ),
				'name'  => 'go',
			);

			$glyphicon = 'share-alt';

		} else {

			$buttonAttrs = array(
				'value' => $this->getSkinTemplate()->translator->translate( 'searchbutton' ),
				'id'    => IdRegistry::getRegistry()->getId( 'mw-searchButton' ),
				'name'  => 'fulltext',
			);

			$glyphicon = 'search';
		}

		$buttonAttrs = array_merge(
			$buttonAttrs,
			Linker::tooltipAndAccesskeyAttribs( "search-$mode" ),
			array(
				 'type'  => 'submit',
				 'class' => $buttonAttrs[ 'id' ] . ' btn btn-default'
			)
		);

		return \Html::rawElement( 'button', $buttonAttrs, '<span class="glyphicon glyphicon-' . $glyphicon . '"></span>' );
	}

}
