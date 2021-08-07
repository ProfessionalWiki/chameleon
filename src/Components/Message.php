<?php
/**
 * File holding the Message class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2021, Morne Alberts
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
 * The Message class.
 *
 * This component allows insertion of system messages into the page.
 *
 * @author Morne Alberts
 * @since 3.4
 * @ingroup Skins
 */
class Message extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {
		$name = $this->getAttribute( 'name' );
		if ( !empty( $name ) ) {
			return $this->getSkinTemplate()->getMsg( $name )->parse();
		}
		return '';
	}

}
