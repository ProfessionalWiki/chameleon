<?php
/**
 * File holding the Message class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2023, Morne Alberts
 * @license   GPL-3.0-or-later
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

/**
 * The Toc class.
 *
 * This component allows placing the TOC outside of the main content.
 *
 * @author Morne Alberts
 * @since 3.5
 * @ingroup Skins
 */
class Toc extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {
		$html = str_replace( ' class="toc"', '', $this->extractTocHtml() );

		return '<div id="chameleon-toc">' . $html . '</div>';
	}

	/**
	 * @return string[] the resource loader modules needed by this component
	 */
	public function getResourceLoaderModules() {
		$modules = parent::getResourceLoaderModules();
		$modules[] = 'skin.chameleon.toc';
		return $modules;
	}

	private function extractTocHtml(): string {
		preg_match( '|<div id="toc"[\s\S]*</div>[\s\S]*</ul>[\s]*</div>|s', $this->getSkin()->getOutput()->getHTML(), $matches );

		return $matches[0] ?? '';
	}

}
