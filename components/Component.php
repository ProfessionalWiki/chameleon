<?php
/**
 * File containing the Component class
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki skin Chameleon.
 * The Chameleon skin is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful,
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

use skins\chameleon\ChameleonTemplate;

/**
 * Component class
 *
 * @ingroup Chameleon
 */
abstract class Component {

	private $mSkinTemplate;
	private $mIndent = 0;

	public function __construct( ChameleonTemplate $template, $indent = 0 ) {

		$this->mSkinTemplate = $template;
		$this->mIndent       = $indent;
	}

	/**
	 * @return ChameleonTemplate
	 */
	public function getSkinTemplate() {

		return $this->mSkinTemplate;
	}

	/**
	 * Returns the current indentation level
	 *
	 * @return int
	 */
	public function getIndent() {

		return $this->mIndent;
	}

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	abstract public function getHtml();

	/**
	 * Adds $indent to (or subtracts from if negative) the current indentation level.
	 * Inserts a new line and a number of tabs according to the new indentation level.
	 *
	 * @param int $indent
	 *
	 * @return string
	 */
	protected function indent( $indent = 0 ) {

		$this->mIndent += $indent;

		return "\n" . str_repeat( "\t", $this->mIndent );
	}

}
