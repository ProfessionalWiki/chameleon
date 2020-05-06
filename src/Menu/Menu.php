<?php
/**
 * File holding the abstract Menu class
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
 * @ingroup   Skins
 */

namespace Skins\Chameleon\Menu;

use Sanitizer;

/**
 * Class Menu
 *
 * @author  Stephan Gambke
 * @since   1.0
 * @ingroup Skins
 */
abstract class Menu {

	private $menuItemFormatter = null;
	private $itemListFormatter = null;

	/**
	 * @return string
	 */
	abstract public function getHtml();

	/**
	 * @param string $href
	 * @param string $class
	 * @param string $text
	 * @param int $depth
	 * @param string $subitems
	 *
	 * @return string
	 */
	protected function getHtmlForMenuItem( $href, $class, $text, $depth, $subitems ) {
		return call_user_func( $this->getMenuItemFormatter(), $href, $class, $text, $depth, $subitems );
	}

	/**
	 * @return callable
	 */
	public function getMenuItemFormatter() {
		if ( $this->menuItemFormatter === null ) {

			$this->setMenuItemFormatter( function ( $href, $class, $text, $depth, $subitems ) {
				$href = Sanitizer::cleanUrl( $href );
				$text = htmlspecialchars( $text );
				$class = htmlspecialchars( $class );
				$indent = str_repeat( "\t", 2 * $depth );

				if ( $subitems !== '' ) {
					// @codingStandardsIgnoreStart
					return "$indent<li>\n$indent\t<a href=\"$href\" class=\"$class\">$text</a>\n$subitems$indent</li>\n";
					// @codingStandardsIgnoreEnd
				} else {
					return "$indent<li><a href=\"$href\" class=\"$class\">$text</a></li>\n";
				}
			} );

		}

		return $this->menuItemFormatter;
	}

	/**
	 * @param callable $menuItemFormatter
	 */
	public function setMenuItemFormatter( $menuItemFormatter ) {
		$this->menuItemFormatter = $menuItemFormatter;
	}

	/**
	 * @param string $rawItemsHtml
	 * @param int $depth
	 *
	 * @return string
	 */
	protected function getHtmlForMenuItemList( $rawItemsHtml, $depth ) {
		return call_user_func( $this->getItemListFormatter(), $rawItemsHtml, $depth );
	}

	/**
	 * @return callable
	 */
	public function getItemListFormatter() {
		if ( $this->itemListFormatter === null ) {

			$this->setItemListFormatter( function ( $rawItemsHtml, $depth ) {
				$indent = str_repeat( "\t", 2 * $depth + 1 );
				return "$indent<ul>\n$rawItemsHtml$indent</ul>\n";
			} );
		}

		return $this->itemListFormatter;
	}

	/**
	 * @param callable $itemListFormatter
	 */
	public function setItemListFormatter( $itemListFormatter ) {
		$this->itemListFormatter = $itemListFormatter;
	}

}
