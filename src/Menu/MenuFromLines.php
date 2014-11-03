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
	private $forContent = false;

	private $linkData = null;

	/**
	 * @var Menu[]
	 */
	private $children = array();

	private $html = null;

	/**
	 * @param string[] $lines
	 * @param bool     $forContent
	 */
	public function __construct( &$lines, $forContent = false ) {
		$this->lines = &$lines;
		$this->forContent = $forContent;
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

		if ( $this->linkData['original'] !== '' ) {
			return $this->getHtmlForMenuItem( $this->linkData['href'], $this->linkData['text'], $this->linkData['depth'], $itemList );
		} else {
			return $itemList;
		}
	}

	/**
	 * Will return an array of the form
	 * array(
	 *   'original' => $orig,  // original link target
	 *   'text'     => $text,  // link text
	 *   'href'     => $href   // parsed link target
	 * );
	 *
	 * @param string $line
	 *
	 * @return array
	 */
	protected function parseOneLine( $line ) {
		wfProfileIn( __METHOD__ );

		$depth = strrpos( ltrim( $line ), '*' );
		$depth = $depth === false ? 0 : $depth + 1;

		// trim spaces and asterisks from line and then split it to maximum two chunks
		$lineArr = array_map( 'trim', explode( '|', trim( $line, "* \t\n\r\0\x0B" ), 2 ) );

		// trim [ and ] from line to have just http://en.wikipedia.org instead
		// of [http://en.wikipedia.org] for external links
		$lineArr[ 0 ] = trim( $lineArr[ 0 ], '[]' );

		if ( count( $lineArr ) === 2 && $lineArr[ 1 ] !== '' ) {
			$msgObj = wfMessage( $lineArr[ 0 ] );
			$link = ( $msgObj->isDisabled() ? $lineArr[ 0 ] : trim( $msgObj->inContentLanguage()->text() ) );
			$desc = trim( $lineArr[ 1 ] );
		} else {
			$link = $desc = trim( $lineArr[ 0 ] );
		}

		$text = $this->forContent ? wfMessage( $desc )->inContentLanguage() : wfMessage( $desc );

		if ( $text->isDisabled() ) {
			$text = $desc;
		}

		if ( preg_match( '/^(?:' . wfUrlProtocols() . ')/', $link ) ) {
			$href = $link;
		} elseif ( empty( $link ) ) {
			$href = '#';
		} elseif ( $link[ 0 ] === '#' ) {
			$href = '#';
		} else {
			$title = Title::newFromText( $link );
			if ( $title instanceof Title ) {
				$href = $title->fixSpecialName()->getLocalURL();
			} else {
				$href = '#';
			}
		}

		wfProfileOut( __METHOD__ );

		return array(
			'original' => $lineArr[ 0 ],
			'text'     => $text,
			'href'     => $href,
			'depth'    => $depth
		);
	}

}
