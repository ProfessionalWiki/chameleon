<?php
/**
 * File holding the Menu component class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke
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

use Sanitizer;
use Skins\Chameleon\Menu\MenuFactory;

/**
 * Class Menu
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class Menu extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @param ChameleonTemplate $tpl
	 * @return String the HTML code
	 * @throws \MWException
	 */
	public function getHtml($tpl = null) {
      if ( !is_null( $tpl ) ) {
          $this->setSkinTemplate( $tpl );
      }
		if ( $this->getDomElement() === null ) {
			return '';
		}

		$menu = $this->getMenu();

		$menu->setMenuItemFormatter( function ( $href, $class, $text, $depth, $subitems ) {
			$href = Sanitizer::cleanUrl( $href );
			$text = htmlspecialchars( $text );

			// @codingStandardsIgnoreStart
			if ( $depth === 1 && !empty( $subitems ) ) {
				return "<div class=\"nav-item dropdown\"><a class=\"nav-link dropdown-toggle $class\" href=\"#\"  data-toggle=\"dropdown\"  data-boundary=\"viewport\">$text</a>$subitems</div>";
			} else {
				return "<div class=\"nav-item\"><a class=\"nav-link $class\"  href=\"$href\">$text</a>$subitems</div>";
			}
			// @codingStandardsIgnoreEnd
		} );

		$menu->setItemListFormatter( function ( $rawItemsHtml, $depth ) {
			if ( $depth === 0 ) {
				return $rawItemsHtml;
			} elseif ( $depth === 1 ) {
				return "<div class=\"dropdown-menu\">$rawItemsHtml</div>";
			} else {
				return "<div>$rawItemsHtml</div>";
			}
		} );

		return $menu->getHtml();
	}

	/**
	 * @return \Skins\Chameleon\Menu\Menu
	 * @throws \MWException
	 */
	public function getMenu() {
		$domElement = $this->getDomElement();
		$msgKey = $domElement->getAttribute( 'message' );

		$menuFactory = new MenuFactory();

		if ( empty( $msgKey ) ) {
			return $menuFactory->getMenuFromMessageText( $domElement->textContent );
		} else {
			return $menuFactory->getMenuFromMessage( $msgKey );

		}
	}
}
