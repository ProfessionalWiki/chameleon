<?php
/**
 * File holding the abstract Menu class
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

namespace Skins\Chameleon\Menu;

/**
 * Class Menu
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
abstract class Menu {

	abstract public function getHtml();

	private $menuItemFormatter = null;
	private $itemListFormatter = null;

	/**
	 * @return string
	 */
	public function getItemListFormatter() {

		if ( $this->itemListFormatter === null ) {
			$this->setItemListFormatter( function ( $rawItemsHtml, $depth ) {
				return "<ul>$rawItemsHtml</ul>";
			} );
		}

		return $this->itemListFormatter;
	}

	/**
	 * @param string $itemListFormatter
	 */
	public function setItemListFormatter( $itemListFormatter ) {
		$this->itemListFormatter = $itemListFormatter;
	}

	/**
	 * @return callable
	 */
	public function getMenuItemFormatter() {

		if ( $this->menuItemFormatter === null ) {

			$this->setMenuItemFormatter( function ( $href, $text, $depth, $subitems ) {
				$href = \Sanitizer::cleanUrl( $href );
				$text = htmlspecialchars( $text );

				return "<li><a href=\"$href\">$text</a>$subitems</li>";
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
	 * @param $href
	 * @param $text
	 * @param $depth
	 * @param $subitems
	 *
	 * @return mixed|string
	 */
	protected function getHtmlForMenuItem( $href, $text, $depth, $subitems ) {
		return call_user_func( $this->getMenuItemFormatter(), $href, $text, $depth, $subitems );
	}

	/**
	 * @param $rawItemsHtml
	 * @param $depth
	 *
	 * @return mixed|string
	 */
	protected function getHtmlForMenuItemList( $rawItemsHtml, $depth ) {
		return call_user_func( $this->getItemListFormatter(), $rawItemsHtml, $depth );
	}

}
