<?php
/**
 * File holding the MenuFromLines class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke
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

namespace Skins\Chameleon\Menu;

use Title;

/**
 * Class MenuFromLines
 *
 * @author  Stephan Gambke
 * @since   1.0
 * @ingroup Skins
 */
class MenuFromLines extends Menu {

	private $lines = null;
	private $inContentLanguage = false;
	private $menuItemData = null;

	private $needsParse = true;

	/** @var Menu[] */
	private $children = [];
	private $html = null;

	/**
	 * @param string[]      $lines
	 * @param bool          $inContentLanguage
	 * @param null|string[] $itemData
	 */
	public function __construct( &$lines, $inContentLanguage = false, $itemData = null ) {

		$this->lines = &$lines;
		$this->inContentLanguage = $inContentLanguage;
		$this->menuItemData = $itemData ?? [ 'text' => '', 'class' => '', 'href' => '#', 'depth' => 0 ];

	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	public function getHtml() {

		if ( $this->html === null ) {

			$this->parseLines();
			$this->html = $this->buildHtml();

		}

		return $this->html;
	}

	/**
	 * @return string[]|null
	 * @throws \MWException
	 */
	public function parseLines() {

		if ( !$this->needsParse ) {
			return null;
		}

		$this->needsParse = false;

		$line = $this->getNextLine();
		$subItemData = $this->parseOneLine( $line );

		while ( $subItemData !== null && $subItemData[ 'depth' ] > $this->menuItemData[ 'depth' ] ) {

			$subItemData = $this->createChildAndParseNextLine( $subItemData );

		}

		return $subItemData;
	}

	/**
	 * @return string
	 */
	protected function getNextLine() {
		$line = '';

		while ( count( $this->lines ) > 0 && empty( $line ) ) {
			$line = trim( array_shift( $this->lines ) );
		};
		return $line;
	}

	/**
	 * Will return an array of the form
	 * [
	 *   'text'     => $text,  // link text
	 *   'href'     => $href,  // parsed link target
	 *   'depth'    => $depth
	 * ];
	 *
	 * @param string $rawLine
	 *
	 * @return array
	 */
	protected function parseOneLine( $rawLine ) {

		if ( empty( $rawLine ) ) {
			return null;
		}

		list( $depth, $linkDescription ) = $this->extractDepthAndLine( $rawLine );
		list( $href, $text, $class ) = $this->extractMenuItemData( $linkDescription );

		return [
			'text'  => $text,
			'href'  => $href,
			'depth' => $depth,
			'class' => $class,
		];
	}

	/**
	 * @param string $rawLine
	 *
	 * @return array
	 */
	protected function extractDepthAndLine( $rawLine ) {

		$matches = [];
		preg_match( '/(\**)(.*)/', ltrim( $rawLine ), $matches );

		$depth = strlen( $matches[ 1 ] );
		$line = $matches[ 2 ];

		return [ $depth, $line ];
	}

	/**
	 * @param $linkDescription
	 *
	 * @return string[]
	 */
	protected function extractMenuItemData( $linkDescription ) {

		$linkAttributes = array_map( 'trim', explode( '|', $linkDescription, 3 ) );

		$linkTarget = trim( trim( $linkAttributes[ 0 ], '[]' ) );
		$linkTarget = $this->getTextFromMessageName( $linkTarget );
		$href = $this->getHrefForTarget( $linkTarget );

		$linkDescription = $linkAttributes[ 1 ] ?? '';
		$text = $linkDescription === '' ? $linkTarget : $this->getTextFromMessageName( $linkDescription );

		$class = $linkAttributes[ 2 ] ?? '';

		return [ $href, $text, $class ];
	}

	/**
	 * @param string $messageName
	 *
	 * @return string
	 */
	protected function getTextFromMessageName( $messageName ) {
		$msgObj = $this->inContentLanguage ? wfMessage( $messageName )->inContentLanguage() : wfMessage( $messageName );
		$messageText = ( $msgObj->isDisabled() ? $messageName : trim( $msgObj->inContentLanguage()->text() ) );
		return $messageText;
	}

	/**
	 * @param string $linkTarget
	 *
	 * @return string
	 */
	protected function getHrefForTarget( $linkTarget ) {

		if ( empty( $linkTarget ) ) {
			return '#';
		} elseif ( preg_match( '/^(?:' . wfUrlProtocols() . ')/', $linkTarget ) || $linkTarget[ 0 ] === '#' ) {
			return $linkTarget;
		} else {
			return $this->getHrefForWikiPage( $linkTarget );
		}
	}

	/**
	 * @param string $linkTarget
	 *
	 * @return string
	 */
	protected function getHrefForWikiPage( $linkTarget ) {
		$title = Title::newFromText( $linkTarget );

		if ( $title instanceof Title ) {
			return $title->fixSpecialName()->getLocalURL();
		}

		return '#';
	}

	/**
	 * @param string[] $subItemData
	 *
	 * @return null|string[]
	 * @throws \MWException
	 */
	protected function createChildAndParseNextLine( $subItemData ) {

		$child = new self( $this->lines, $this->inContentLanguage, $subItemData );
		$child->setMenuItemFormatter( $this->getMenuItemFormatter() );
		$child->setItemListFormatter( $this->getItemListFormatter() );

		$subItemData = $child->parseLines();

		$this->children[] = $child;

		return $subItemData;
	}

	/**
	 * @return string
	 */
	protected function buildHtml() {

		$submenuHtml = $this->buildSubmenuHtml();

		if ( $this->menuItemData[ 'text' ] !== '' ) {
			return $this->getHtmlForMenuItem( $this->menuItemData[ 'href' ], $this->menuItemData[ 'class' ], $this->menuItemData[ 'text' ], $this->menuItemData[ 'depth' ], $submenuHtml );
		} else {
			return $submenuHtml;
		}
	}

	/**
	 * @return string
	 */
	protected function buildSubmenuHtml() {

		if ( empty( $this->children ) ) {
			return '';
		}

		$itemList = '';
		foreach ( $this->children as $child ) {
			$itemList .= $child->getHtml();
		}

		return $this->getHtmlForMenuItemList( $itemList, $this->menuItemData[ 'depth' ] );
	}

}
