<?php
/**
 * File holding the MainContent class
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
 * The NavbarHorizontal class.
 *
 * A horizontal navbar containing the sidebar items.
 * Does not include standard items (toolbox, search, language links). They need to be added to the page elsewhere
 *
 * The navbar is a list of lists wrapped in a nav element: <nav role="navigation" id="p-navbar" >
 *
 * @ingroup Skins
 */
class MainContent extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$skintemplate = $this->getSkinTemplate();

		$ret = $this->indent() . '<div id="mw-js-message" style="display:none;" ' . $skintemplate->get( 'userlangattributes' ) . '></div>' .
			   $this->indent() . '<!-- start the content area -->' .
			   $this->indent() . '<div id="content" class="mw-body ' . $this->getClass() . '">' .
			   $this->indent( 1 ) . '<div class ="contentHeader">' .
			   $this->indent( 1 ) . '<!-- title of the page -->' .
			   $this->indent() . '<h1 id="firstHeading" class="firstHeading">' . $skintemplate->get( 'title' ) . '</h1>' .
			   $this->indent() . '<!-- tagline; usually goes something like "From WikiName"	primary purpose of this seems to be for printing to identify the source of the content -->' .
			   $this->indent() . '<div id="siteSub" >' . $skintemplate->getMsg( 'tagline' ) . '</div>';

		if ( $skintemplate->data[ 'subtitle' ] ) {
			$ret .= $this->indent() . '<!-- subtitle line; used for various things like the subpage hierarchy -->' .
					$this->indent() . '<div id="contentSub" class="small">' . $skintemplate->get( 'subtitle' ) . '</div>';
		}

		if ( $skintemplate->data[ 'undelete' ] ) {
			$ret .= $this->indent() . '<!-- undelete message -->' . '<div id="contentSub2">' . $skintemplate->get( 'undelete' ) . '</div>';
		}

		$ret .= $this->indent( -1 ) . '</div>' .
				$this->indent() . '<!-- body text -->' . "\n" .
				$this->indent() . $skintemplate->get( 'bodytext' ) .
				$this->indent() . '<!-- category links -->' .
				$this->indent() . $skintemplate->get( 'catlinks' );

		if ( $skintemplate->data[ 'dataAfterContent' ] ) {
			$ret .= $this->indent() . '<!-- data blocks which should go somewhere after the body text, but not before the catlinks block-->' .
					$this->indent() . $skintemplate->get( 'dataAfterContent' );
		}

		$ret .= $this->indent( -1 ) . '</div>' . "\n";

		return $ret;
	}
}
