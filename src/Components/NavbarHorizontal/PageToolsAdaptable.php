<?php
/**
 * File holding the NavbarHorizontal\PageToolsAdaptable class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2017, Stephan Gambke
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


namespace Skins\Chameleon\Components\NavbarHorizontal;

use Skins\Chameleon\Components\PageTools as GenPageTools;

/**
 * The NavbarHorizontal\PageToolsAdaptable class.
 *
 * Provides an adaptable PageTools component to be included in a NavbarHorizontal component.
 *
 * @author Tobias Oetterer
 * @since 1.6
 * @ingroup Skins
 */
class PageToolsAdaptable extends PageTools
{

	const GLYPH_ICON_UNKNOWN_ACTION = 'asterisk';

	/**
	 * @var string[]
	 */
	private $mShowActions = null;

	/**
	 * @var string[]
	 */
	private $mValidActionsToShow = null;

	/**
	 * @var array
	 */
	private static $sGlyphIconForAction = array(
		'delete'    => 'trash',
		'edit'      => 'edit',
		'formedit'  => 'list-alt',
		'history'   => 'education',
		'move'      => 'share-alt',
		'protect'   => 'folder-close',
		'purge'     => 'repeat',
		'undelete'  => 'road',
		'unprotect' => 'folder-open',
		'unwatch'   => 'star',
		've-edit'   => 'pencil',
		'view'      => 'eye-open',
		'watch'     => 'star-empty',
	);

	/**
	 * @param string $action
	 * @param string $fallback
	 * @return null|string
	 */
	public static function getGlyphIconForAction( $action, $fallback = null ) {
		if ( isset( self::$sGlyphIconForAction[$action] ) ) {
			return self::$sGlyphIconForAction[$action];
		}
		return $fallback !== null ? $fallback : self::GLYPH_ICON_UNKNOWN_ACTION;
	}

	/**
	 * @param string $icon
	 * @param string $action
	 */
	public static function setGlyphIconForAction( $icon, $action ) {
		if ( is_string( $icon ) && $icon && is_string( $action ) && $action ) {
			self::$sGlyphIconForAction[$action] = $icon;
		}
	}

	/**
	 * @param GenPageTools $pageTools
	 * @return string
	 * @throws \MWException
	 */
	protected function getEditLinkHtml( $pageTools ) {

		$pageToolsStructure = $pageTools->getPageToolsStructure();
		if ( !array_key_exists( 'views', $pageToolsStructure ) ) {
			return '';
		}

		$items = array();

		$showActions = $this->getShowActions( $pageTools );

		foreach ( $showActions as $actionId ) {

			if ( array_key_exists( $actionId, $pageToolsStructure['views'] ) ) {
				$items[] = $this->getLinkAndRemoveFromPageToolStructure( $pageTools, $actionId );
			}
		}

		return implode(
			$this->indent() . '</ul>' . $this->indent() . '<ul class="navbar-tools navbar-nav" >' . $this->indent() . "\t",
			$items
		);
	}

	/**
	 * @param string $action
	 * @return string
	 */
	protected function getGlyphIconClassFor( $action ) {
		return 'glyphicon glyphicon-' . self::getGlyphIconForAction( $action );
	}

	/**
	 * @param GenPageTools $pageTools
	 * @param string $editActionId
	 *
	 * @return string
	 */
	protected function getLinkAndRemoveFromPageToolStructure( $pageTools, $editActionId ) {

		$pageToolsStructure = $pageTools->getPageToolsStructure();
		$editActionStructure = $pageToolsStructure['views'][$editActionId];

		$editActionStructure['text'] = '';

		if ( array_key_exists( 'class', $editActionStructure ) ) {
			$editActionStructure['class'] .= ' navbar-tools-tools';
		} else {
			$editActionStructure['class'] = 'navbar-tools-tools';
		}

		$options = array(
			'text-wrapper' => array(
				'tag'        => 'span',
				'attributes' => array( 'class' => $this->getGlyphIconClassFor( $editActionId ), ),
			),
		);

		$editLinkHtml = $this->getSkinTemplate()->makeListItem(
			$editActionId,
			$editActionStructure,
			$options
		);

		$pageTools->setRedundant( $editActionId );

		return $editLinkHtml;
	}

	/**
	 * @param @param GenPageTools $pageTools
	 * @return string[]|null
	 */
	protected function getShowActions( $pageTools ) {
		if ( $this->mShowActions !== null ) {
			return $this->mShowActions;
		}
		$showActions = array();

		$showAttributesString = $this->getDomElement() !== null ? $this->getDomElement()->getAttribute( 'show' ) : '';

		if ( $showAttributesString != '' ) {
			foreach ( explode( ',', $showAttributesString ) as $requestedShowAction ) {
				if ( in_array( $requestedShowAction, $this->getValidActionsToShow( $pageTools ) ) ) {
					$showActions[] = $requestedShowAction;
				}
			}
		}
		return $this->mShowActions = $showActions;
	}

	/**
	 * @param GenPageTools $pageTools
	 * @return string[]
	 */
	protected function getValidActionsToShow( $pageTools ) {
		if ( $this->mValidActionsToShow !== null ) {
			return $this->mValidActionsToShow;
		}
		$pageToolsStructure = $pageTools->getPageToolsStructure();
		$validActionsToShow = array();

		foreach ( $pageToolsStructure as $group => $groupStructure ) {
			$validActionsToShow = array_merge( $validActionsToShow, array_keys( $groupStructure ) );
		}
		return $this->mValidActionsToShow = $validActionsToShow;
	}
}