<?php
/**
 * File holding the PersonalTools class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2018, Stephan Gambke
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

/**
 * The PersonalTools class.
 *
 * An unordered list of personal tools: <ul id="p-personal" >...
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class PersonalTools extends Component {

	private const ECHO_LINK_KEYS = [ 'notifications-alert', 'notifications-notice' ];
	private const ATTR_SHOW_ECHO = 'showEcho';
	private const SHOW_ECHO_ICONS = 'icons';
	private const SHOW_ECHO_LINKS = 'links';

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {
		$ret = $this->indent() . '<!-- personal tools -->' .
			   $this->indent() . '<div class="p-personal ' . $this->getClassString() . '" id="p-personal" >';

		$ret .= $this->indent( 1 ) . '<ul class="p-personal-tools" >';

		$this->indent( 1 );

		// add personal tools (links to user page, user talk, prefs, ...)
		foreach ( $this->getSkinTemplate()->getPersonalTools() as $key => $item ) {
			// Flatten classes to avoid MW bug: https://phabricator.wikimedia.org/T262160
			if ( !empty( $item['links'][0]['class'] ) && is_array( $item['links'][0]['class'] ) ) {
				$item['links'][0]['class'] = implode( ' ', $item['links'][0]['class'] );
			}

			if ( in_array( $key, self::ECHO_LINK_KEYS ) ) {
				$showEcho = $this->getAttribute( self::ATTR_SHOW_ECHO, self::SHOW_ECHO_ICONS );

				if ( $showEcho === self::SHOW_ECHO_LINKS ) {
					// Remove Echo classes to render as a link
					unset( $item['links'][0]['class'] );
				}
			}

			if ( isset( $item['id'] ) ) {
				$ret .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item,
					[ 'link-class' => $item['id'] ] );
			} else {
				$ret .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item );
			}
		}

		$ret .= $this->indent( -1 ) . '</ul>' .
				$this->indent( -1 ) . '</div>' . "\n" .
				$this->getNewtalkNotifier();

		return $ret;
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	private function getNewtalkNotifier() {
		if ( $this->getDomElement() !== null &&
			filter_var( $this->getDomElement()->getAttribute( 'hideNewtalkNotifier' ),
			FILTER_VALIDATE_BOOLEAN ) ) {
			return '';
		}

		// include message to a user about new messages on their talkpage
		$newtalkNotifier = new NewtalkNotifier( $this->getSkinTemplate(), null, $this->getIndent() + 2 );

		return $this->indent() . '<div class="newtalk-notifier pull-right">' .
			$newtalkNotifier->getHtml() . $this->indent() . '</div>';
	}

}
