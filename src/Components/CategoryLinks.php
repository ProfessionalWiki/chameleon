<?php
/**
 * File holding the CategoryLinks class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2022, Morne Alberts
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
 * The CategoryLinks class.
 *
 * This component allows insertion of category links into the page.
 *
 * @author Morne Alberts
 * @since 4.0
 * @ingroup Skins
 */
class CategoryLinks extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {
		return $this->indent() . '<!-- category links -->' .
			$this->indent() . $this->getSkinTemplate()->get( 'catlinks' );
	}

}
