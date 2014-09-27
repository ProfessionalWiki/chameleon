<?php
/**
 * File holding the MenuFactory class
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

namespace Skins\Chameleon\Menu;

/**
 * Class MenuFactory
 *
 * @package Skins\Chameleon\Menu
 */
class MenuFactory {

	/**
	 * @param \Message|string|string[] $message
	 * @param bool                     $forContent
	 *
	 * @throws \MWException
	 *
	 * @return Menu
	 */
	public function getMenuFromMessage( $message, $forContent = false ) {

		if ( is_string( $message ) || is_array( $message ) ) {
			$message = \Message::newFromKey( $message );
		}

		if ( !is_a( $message, '\\Message' ) ) {
			throw new \MWException( 'String, array of strings or Message object expected. Got ' . is_object( $message ) ? get_class( $message ) : gettype( $message ) . '.' );
		}

		if ( $forContent ) {
			$message = $message->inContentLanguage();
		}

		if ( !$message->exists() ) {
			return $this->getMenuFromMessageText( '', $forContent );
		}

		return $this->getMenuFromMessageText( $message->text(), $forContent );
	}

	/**
	 * @param string $text
	 *
	 * @throws \MWException
	 *
	 * @return Menu
	 */
	public function getMenuFromMessageText( $text, $forContent = false ) {

		if ( !is_string( $text ) ) {
			throw new \MWException( 'String expected. Got ' . is_object( $text ) ? get_class( $text ) : gettype( $text ) . '.' );
		}

		$lines = explode( "\n", trim( $text ) );

		array_unshift( $lines, '' );

		return new MenuFromLines( $lines, $forContent );
	}
}
