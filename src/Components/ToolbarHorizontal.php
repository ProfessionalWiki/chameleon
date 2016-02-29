<?php
/**
 * File containing the ToolbarHorizontal class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2016, Stephan Gambke
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

use Hooks;
use Linker;

/**
 * ToolbarHorizontal class
 *
 * A horizontal toolbar containing standard sidebar items (toolbox, language links).
 *
 * The toolbar is an unordered list in a nav element: <nav role="navigation" id="p-tb" >
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class ToolbarHorizontal extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$skinTemplate = $this->getSkinTemplate();

		$ret = $this->indent() . '<!-- ' . htmlspecialchars( $skinTemplate->getMsg( 'toolbox' )->text() ) . '-->' .
			   $this->indent() . '<nav class="navbar navbar-default p-tb ' . $this->getClassString() . '" id="p-tb" ' . Linker::tooltip( 'p-tb' ) . ' >' .
			   $this->indent( 1 ) . '<ul class="nav navbar-nav small">';

		$this->indent( 1 );

		// insert toolbox items
		if ( !$this->hideTools() ) {
			$ret .= $this->addTools( $skinTemplate );
		}

		// insert language links
		if ( !$this->hideLanguages() ) {
			$ret .= $this->addLanguageLinks( $skinTemplate );
		}

		$ret .= $this->indent( -1 ) . '</ul>' .
				$this->indent( -1 ) . '</nav>' . "\n";

		return $ret;
	}

	/**
	 * @param $skinTemplate
	 * @return string
	 * @throws \FatalError
	 * @throws \MWException
	 */
	private function addTools( $skinTemplate ) {

		$ret = '';

		// TODO: Do we need to care of dropdown menus here? E.g. RSS feeds? See SkinTemplateToolboxEnd.php:1485
		foreach ( $skinTemplate->getToolbox() as $key => $tbitem ) {
			$ret .= $this->indent() . $skinTemplate->makeListItem( $key, $tbitem );
		}

		ob_start();
		// We pass an extra 'true' at the end so extensions using BaseTemplateToolbox
		// can abort and avoid outputting double toolbox links
		Hooks::run( 'SkinTemplateToolboxEnd', array( &$skinTemplate, true ) );
		$ret .= $this->indent() . ob_get_contents();
		ob_end_clean();
		return $ret;
	}

	/**
	 * @param $skinTemplate
	 * @return string
	 * @throws \MWException
	 */
	private function addLanguageLinks( $skinTemplate ) {

		$ret = '';

		if ( array_key_exists( 'language_urls', $skinTemplate->data ) && $skinTemplate->data[ 'language_urls' ] ) {

			$ret .= $this->indent() . '<li class="dropdown dropup p-lang" id="p-lang" ' . Linker::tooltip( 'p-lang' ) . ' >' .
					$this->indent( 1 ) . '<a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">' .
					htmlspecialchars( $skinTemplate->getMsg( 'otherlanguages' )->text() ) . ' <b class="caret"></b>' . '</a>' .
					$this->indent() . '<ul class="dropdown-menu" >';

			$this->indent( 1 );
			foreach ( $skinTemplate->data[ 'language_urls' ] as $key => $langlink ) {
				$ret .= $this->indent() . $skinTemplate->makeListItem( $key, $langlink, array( 'link-class' => 'small' ) );
			}

			$ret .= $this->indent( -1 ) . '</ul>' .
					$this->indent( -1 ) . '</li>';
		}

		return $ret;
	}

	/**
	 * @return bool
	 */
	private function hideTools() {
		return $this->getDomElement() !== null && filter_var( $this->getDomElement()->getAttribute( 'hideTools' ), FILTER_VALIDATE_BOOLEAN );
	}

	/**
	 * @return bool
	 */
	private function hideLanguages() {
		return $this->getDomElement() !== null && filter_var( $this->getDomElement()->getAttribute( 'hideLanguages' ), FILTER_VALIDATE_BOOLEAN );
	}

}
