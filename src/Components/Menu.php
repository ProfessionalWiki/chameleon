<?php
/**
 * File holding the Menu component class
 *
 * @copyright (C) 2014, Stephan Gambke
 * @license       http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
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
 * @ingroup       Skins
 */

namespace Skins\Chameleon\Components;

use Skins\Chameleon\Menu\MenuFactory;

/**
 * Class Menu
 *
 * @package Skins\Chameleon\Components
 */
class Menu extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$element = $this->getDomElement();
		$msgKey = $element->getAttribute( 'message' );

		$menuFactory = new MenuFactory();

		if ( empty( $msgKey ) ) {
			$text = $element->textContent;
			$menu = $menuFactory->getMenuFromMessageText( $text );
		} else {
			$menu = $menuFactory->getMenuFromMessage( $msgKey );

		}

		$menu->setMenuItemFormatter(
			function ( $href, $text, $depth, $subitems ) {
				$href = \Sanitizer::cleanUrl( $href );
				$text = htmlspecialchars( $text );
				if ( $depth === 1 && !empty( $subitems ) ) {
					return "<li class=\"dropdown\"><a class=\"dropdown-toggle\" href=\"#\"  data-toggle=\"dropdown\">$text<b class=\"caret\"></b></a>$subitems</li>";
				} else {
					return "<li><a href=\"$href\">$text</a>$subitems</li>";
				}
			}
		);

		$menu->setItemListFormatter(
			function ( $rawItemsHtml, $depth ) {
				if ( $depth === 0 ) {
					return $rawItemsHtml;
				} elseif ( $depth === 1 ) {
					return "<ul class=\"dropdown-menu\">$rawItemsHtml</ul>";
				} else {
					return "<ul>$rawItemsHtml</ul>";
				}

			}
		);

		return $menu->getHtml();
	}
}
