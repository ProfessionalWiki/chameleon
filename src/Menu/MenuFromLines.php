<?php
/**
 * File holding the MenuFromLines class
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
use Title;

/**
 * Class MenuFromLines
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class MenuFromLines extends Menu {

	private $lines = null;
	private $inContentLanguage = false;

	private $linkData = null;

	/**
	 * @var Menu[]
	 */
	private $children = array();

	private $html = null;

	/**
	 * @param string[] $lines
	 * @param bool     $inContentLanguage
	 */
	public function __construct( &$lines, $inContentLanguage = false ) {
		$this->lines = &$lines;
		$this->inContentLanguage = $inContentLanguage;
	}

	/**
	 * @return mixed|null|string
	 */
	public function getHtml() {

		if ( $this->html !== null ) {
			return $this->html;
		}

		$this->parseLines();

		$this->html = $this->buildHtml();

		return $this->html;
	}

	public function parseLines() {

		if ( empty( $this->lines ) ) {
			return;
		}

		$line = array_shift( $this->lines );
		$this->linkData = $this->parseOneLine( $line );

		while ( count( $this->lines ) ) {

			$line = trim( reset( $this->lines ) );

			if ( empty( $line ) ) { // skip empty lines
				array_shift( $this->lines );
				continue;
			}

			if ( strrpos( $line, '*' ) !== $this->linkData[ 'depth' ] ) {
				return;
			}

			$child = new self( $this->lines );
			$child->setMenuItemFormatter( $this->getMenuItemFormatter() );
			$child->setItemListFormatter( $this->getItemListFormatter() );
			$child->parseLines();
			$this->children[] = $child;
		}
	}

	/**
	 * @return mixed|string
	 */
	private function buildHtml()  {

		$itemList = '';

		if ( ! empty( $this->children ) ) {
			foreach ( $this->children as $child ) {
				$itemList .= $child->getHtml();
			}
			$itemList = $this->getHtmlForMenuItemList( $itemList, $this->linkData['depth'] );
		}

		if ( $this->linkData['text'] !== '' ) {
			return $this->getHtmlForMenuItem( $this->linkData['href'], $this->linkData['text'], $this->linkData['depth'], $itemList );
		} else {
			return $itemList;
		}
	}

	/**
	 * Will return an array of the form
	 * array(
	 *   'text'     => $text,  // link text
	 *   'href'     => $href,  // parsed link target
	 *   'depth'    => $depth
	 * );
	 *
	 * @param string $rawLine
	 *
	 * @return array
	 */
	protected function parseOneLine( $rawLine ) {

		list( $depth, $line ) = $this->extractDepthAndLine( $rawLine );

		$lineArr = array_map( 'trim', explode( '|', $line, 2 ) );

		$linkTarget = trim( trim( $lineArr[ 0 ], '[]' ) );
		$linkTarget = $this->getTextFromMessageName( $linkTarget );
		$href = $this->getHrefForTarget( $linkTarget );

		$linkDescription = count( $lineArr ) > 1 ? $lineArr[ 1 ] : '';
		$text = $linkDescription === '' ? $linkTarget : $this->getTextFromMessageName( $linkDescription );

		return array(
			'text'     => $text,
			'href'     => $href,
			'depth'    => $depth
		);
	}

	/**
	 * @param $rawLine
	 * @return array
	 */
	protected function extractDepthAndLine( $rawLine ) {

		$matches = array();
		preg_match( '/(\**)(.*)/', ltrim( $rawLine ), $matches );

		$depth = strlen( $matches[ 1 ] );
		$line = $matches[ 2 ];

		return array( $depth, $line );
	}

	/**
	 * @param string $messageName
	 * @return string
	 */
	protected function getTextFromMessageName( $messageName ) {
		$msgObj = $this->inContentLanguage ? wfMessage( $messageName )->inContentLanguage() : wfMessage( $messageName );
		$messageText = ( $msgObj->isDisabled() ? $messageName : trim( $msgObj->inContentLanguage()->text() ) );
		return $messageText;
	}

	/**
	 * @param $linkTarget
	 * @return string
	 * @throws \MWException
	 */
	protected function getHrefForTarget( $linkTarget ) {

		if ( empty( $linkTarget ) ) {
			return '#';
		} elseif ( preg_match( '/^(?:' . wfUrlProtocols() . ')/', $linkTarget ) || $linkTarget[ 0 ] === '#') {
			return $linkTarget;
		} else {
			return $this->getHrefFromTitle( $linkTarget );
		}
	}

	/**
	 * @param $linkTarget
	 * @return string
	 * @throws \MWException
	 */
	protected function getHrefFromTitle( $linkTarget ) {
		$title = Title::newFromText( $linkTarget );

		if ( $title instanceof Title ) {
			return $title->fixSpecialName()->getLocalURL();
		}

		return '#';
	}

}
