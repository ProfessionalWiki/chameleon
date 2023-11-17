<?php
/**
 * File holding the NavMenu class
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

namespace Skins\Chameleon\Components;

use Linker;
use Sanitizer;
use Skins\Chameleon\IdRegistry;

/**
 * The NavMenu class.
 *
 * @author  Stephan Gambke
 * @since   1.0
 * @ingroup Skins
 */
class NavMenu extends Component {

	private const ATTR_INCLUDE = 'include';
	private const ATTR_EXCLUDE = 'exclude';

	/**
	 * Builds the HTML code for this component
	 *
	 * @return string the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {
		$ret = '';

		$sidebar = $this->getSkinTemplate()->getSidebar(
			[
				'search' => false,
				'toolbox' => false,
				'languages' => false,
			]
		);

		$include = $this->getAttribute( self::ATTR_INCLUDE, false );
		if ( $include !== false ) {
			$sidebar = array_intersect_key(
				$sidebar,
				// Split on ';', trim whitespace, remove empty strings,
				// and shove resulting tokens into an arrays as keys.
				array_fill_keys( preg_split('/\s*;+\s*/', $include,
						NULL, PREG_SPLIT_NO_EMPTY ), true ) );
		}

		$exclude = $this->getAttribute( self::ATTR_EXCLUDE, false );
		if ( $exclude !== false ) {
			$sidebar = array_diff_key(
				$sidebar,
				// Split on ';', trim whitespace, remove empty strings,
				// and shove resulting tokens into an arrays as keys.
				array_fill_keys( preg_split('/\s*;+\s*/', $exclude,
						NULL, PREG_SPLIT_NO_EMPTY ), true ) );
		}

		$flatten = $this->getMenusToBeFlattened();

		// create a dropdown for each sidebar box
		foreach ( $sidebar as $menuName => $menuDescription ) {
			// Ensure parent menu item has a valid id.
			$menuDescription['id'] = Sanitizer::escapeIdForAttribute(
				strtr( $menuDescription['id'], ' ', '-' )
			);
			/* @phan-suppress-next-line SecurityCheck-DoubleEscaped */
			$ret .= $this->getDropdownForNavMenu( $menuName, $menuDescription,
				array_search( $menuName, $flatten ) !== false );
		}

		return $ret;
	}

	/**
	 * Create a single dropdown
	 *
	 * @param string $menuName
	 * @param array $menuDescription
	 * @param bool $flatten
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function getDropdownForNavMenu( $menuName, $menuDescription, $flatten = false ) {
		// open list item containing the dropdown
		$ret = $this->indent() . '<!-- ' . $menuName . ' -->';

		if ( $flatten ) {

			$ret .= $this->buildMenuItemsForDropdownMenu( $menuDescription );

		} elseif ( !$this->hasSubmenuItems( $menuDescription ) ) {

			$ret .= $this->buildDropdownMenuStub( $menuDescription );

		} else {
			$ret .= $this->buildDropdownOpeningTags( $menuDescription ) .
					$this->buildMenuItemsForDropdownMenu( $menuDescription, 1 ) .
					$this->buildDropdownClosingTags();

		}

		return $ret;
	}

	/**
	 * @param array $menuDescription
	 * @param int $indent
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function buildMenuItemsForDropdownMenu( $menuDescription, $indent = 0 ) {
		// build the list of submenu items
		if ( $this->hasSubmenuItems( $menuDescription ) ) {

			$menuitems = '';
			$this->indent( $indent );

			foreach ( $menuDescription['content'] as $key => $item ) {
				$id = $item['id'] ?? '';
				$menuitems .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item, [
					'tag' => 'div',
					'class' => 'nav-item',
					'link-class' => 'nav-link '. $id . ( $this->isHrefActive( $item['href'] ) ? ' active' : '' )
				] );
			}

			$this->indent( - $indent );

			return $menuitems;

		} else {
			return $this->indent() . '<!-- empty -->';
		}
	}

	/**
	 * @param array $menuDescription
	 *
	 * @return bool
	 */
	protected function hasSubmenuItems( $menuDescription ) {
		return is_array( $menuDescription['content'] ) &&
			count( $menuDescription['content'] ) > 0;
	}

	/**
	 * @param array $menuDescription
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function buildDropdownMenuStub( $menuDescription ) {
		$menuId = $menuDescription['id'];

		return $this->indent() . \Html::rawElement( 'div',
				[
					'class' => 'nav-item ' . $menuId . '-dropdown',
				],
				\Html::rawElement( 'a',
					[
						'href' => '#',
						'class' => 'nav-link ' . $menuId . '-toggle',
						'title' => Linker::titleAttrib( $menuId ),
					],
					htmlspecialchars( $menuDescription['header'] ) )
			);
	}

	/**
	 * @param array $menuDescription
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function buildDropdownOpeningTags( $menuDescription ) {
		$menuId = $menuDescription['id'];

		// open list item containing the dropdown
		$ret = $this->indent() . \Html::openElement( 'div',
				[
					'class' => 'nav-item dropdown ' . $menuId . '-dropdown',
				] );

		// add the dropdown toggle
		$ret .= $this->indent( 1 ) .
			\Html::rawElement( 'a',
				[
					'href' => '#',
					'class' => 'nav-link dropdown-toggle ' . $menuId . '-toggle',
					'data-toggle' => 'dropdown',
					'data-boundary' => 'viewport',
					'title' => Linker::titleAttrib( $menuId ),
				],
				htmlspecialchars( $menuDescription['header'] ) );

		// open list of dropdown menu items
		$ret .=
			$this->indent() . \Html::openElement( 'div',
				[
					'class' => 'dropdown-menu ' . $menuId,
					'id'    => IdRegistry::getRegistry()->getId( $menuId ),
				]
			);
		return $ret;
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildDropdownClosingTags() {
		return $this->indent() . '</div>' .
			$this->indent( - 1 ) . '</div>';
	}

	/**
	 * @return string[]
	 */
	public function getMenusToBeFlattened() {
		$msg = \Message::newFromKey( 'skin-chameleon-navmenu-flatten' );

		if ( $msg->exists() ) {
			$flatten = array_map( 'trim', explode( ',', $msg->plain() ) );
		} elseif ( $this->getDomElement() !== null ) {
			$flatten =
				array_map( 'trim',
					explode( ';', $this->getDomElement()->getAttribute( 'flatten' ) ) );
		} else {
			$flatten = [];
		}

		return $flatten;
	}

	private function isHrefActive( string $href ): bool {
		return filter_var( $this->getDomElement()->getAttribute( 'showActive' ), FILTER_VALIDATE_BOOLEAN )
			&& $href === $this->getSkin()->getTitle()->getLocalURL();
	}

}
