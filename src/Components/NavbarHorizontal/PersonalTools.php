<?php
/**
 * File holding the NavbarHorizontal\PersonalTools class
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

namespace Skins\Chameleon\Components\NavbarHorizontal;

use Hooks;
use Skins\Chameleon\Components\Component;
use Skins\Chameleon\IdRegistry;

/**
 * The NavbarHorizontal\PersonalTools class.
 *
 * Provides a PersonalTools component to be included in a NavbarHorizontal component.
 *
 * @author Stephan Gambke
 * @since 1.6
 * @ingroup Skins
 */
class PersonalTools extends Component {

	private const ECHO_LINK_KEYS = [ 'notifications-alert', 'notifications-notice' ];
	private const ATTR_SHOW_ECHO = 'showEcho';
	private const SHOW_ECHO_ICONS = 'icons';
	private const SHOW_ECHO_LINKS = 'links';
	private const ATTR_SHOW_USER_NAME = 'showUserName';

	/**
	 * @return String
	 * @throws \FatalError
	 * @throws \MWException
	 */
	public function getHtml() {
		// start personal tools element
		$echoHtml = '';
		if ( $this->getShowEcho() === self::SHOW_ECHO_ICONS ) {
			$echoHtml = $this->indent() . $this->getEchoIcons();
		}
		return $echoHtml .
			$this->indent() . '<!-- personal tools -->' .
			$this->indent() . '<div class="navbar-tools navbar-nav" >' .
			$this->indent( 1 ) . \Html::rawElement( 'div', [ 'class' => 'navbar-tool dropdown' ],

				$this->getDropdownToggle() .
				$this->indent( 1 ) . \Html::rawElement( 'div',
				[ 'class' => 'p-personal-tools dropdown-menu' ], $this->getTools() . $this->indent() ) .
				$this->indent( -1 )
			) .
			$this->indent( -1 ) . '</div>';
	}

	/**
	 * @return string
	 * @throws \FatalError
	 * @throws \MWException
	 */
	protected function getNewtalkNotifier() {
		$user = $this->getSkinTemplate()->getSkin()->getUser();

		$newMessagesAlert = $this->getSkinTemplate()->getMsg( 'chameleon-newmessages' )->text();

		if ( empty( $this->getSkinTemplate()->data[ 'newtalk' ] ) ) {
			return '';
		}

		$talkClass = $user->isRegistered() ? 'pt-mytalk' : 'pt-anontalk';

		$newtalkNotifier = $this->indent( 1 ) . '<span class="badge badge-pill badge-info ' .
			$talkClass . '" title="' . $newMessagesAlert . '" href="#"></span>';
		$this->indent( -1 );

		return $newtalkNotifier;
	}

	/**
	 * @return string
	 * @throws \FatalError
	 * @throws \MWException
	 */
	protected function getUserName() {
		if ( filter_var( $this->getAttribute( self::ATTR_SHOW_USER_NAME ), FILTER_VALIDATE_BOOLEAN ) ) {
			$user = $this->getSkinTemplate()->getSkin()->getUser();
			if ( $user->isRegistered() ) {
				$username = !empty( $user->getRealName() ) ? $user->getRealName() : $user->getName();
				return '<span class="user-name">' . htmlspecialchars( $username ) . '</span>';
			}
		}
		return '';
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function getTools() {
		$this->indent( 1 );
		$ret = '';

		// add personal tools (links to user page, user talk, prefs, ...)
		foreach ( $this->getSkinTemplate()->getPersonalTools() as $key => $item ) {
			// Flatten classes to avoid MW bug: https://phabricator.wikimedia.org/T262160
			if ( !empty( $item['links'][0]['class'] ) && is_array( $item['links'][0]['class'] ) ) {
				$item['links'][0]['class'] = implode( ' ', $item['links'][0]['class'] );
			}

			if ( in_array( $key, self::ECHO_LINK_KEYS ) ) {
				$showEcho = $this->getShowEcho();
				if ( $showEcho === self::SHOW_ECHO_LINKS ) {
					// Remove Echo classes to render as a link
					unset( $item['links'][0]['class'] );
				} elseif ( $showEcho === self::SHOW_ECHO_ICONS ) {
					// Icons will be rendered elsewhere
					continue;
				}
			}

			if ( isset( $item['id'] ) ) {
				$ret .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item,
					[ 'tag' => 'div', 'link-class' => $item['id'] ] );
			} else {
				$ret .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item,
					[ 'tag' => 'div' ] );
			}
		}

		$this->indent( -1 );
		return $ret;
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function getEchoIcons() {
		$items = '';

		foreach ( $this->getSkinTemplate()->getPersonalTools() as $key => $item ) {
			if ( in_array( $key, self::ECHO_LINK_KEYS ) ) {
				// Flatten classes to avoid MW bug: https://phabricator.wikimedia.org/T262160
				if ( !empty( $item['links'][0]['class'] ) && is_array( $item['links'][0]['class'] ) ) {
					$item['links'][0]['class'] = implode( ' ', $item['links'][0]['class'] );
				}

				$items .= $this->indent() .
					$this->getSkinTemplate()->makeListItem( $key, $item );
			}
		}

		if ( empty( $items ) ) {
			return '';
		}

		return '<!-- echo icons -->' .
			'<ul class="navbar-tools echo-icons">' .
			$this->indent() . $items .
			'</ul>';
	}


	/**
	 * @return string
	 * @throws \FatalError
	 * @throws \MWException
	 */
	protected function getDropdownToggle(): string {
		$user = $this->getSkinTemplate()->getSkin()->getUser();

		if ( $user->isRegistered() ) {

			$toolsClass = 'navbar-userloggedin';
			$toolsLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-loggedin' )->
				params( $user->getName() )->text();

		} else {

			$toolsClass = 'navbar-usernotloggedin';
			$toolsLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-notloggedin' )->text();

		}

		Hooks::run( 'ChameleonNavbarHorizontalPersonalToolsLinkText', [ &$toolsLinkText,
			$this->getSkin() ] );

		$this->indent( 1 );

		$dropdownToggle = IdRegistry::getRegistry()->element( 'a', [ 'class' => $toolsClass,
			'href' => '#', 'data-toggle' => 'dropdown', 'data-boundary' => 'viewport',
			'title' => $toolsLinkText ], $this->getNewtalkNotifier() . $this->getUserName(),
			$this->indent() );

		$this->indent( -1 );

		return $dropdownToggle;
	}

	/**
	 * @return string
	 */
	protected function getShowEcho() {
		return $this->getAttribute( self::ATTR_SHOW_ECHO, self::SHOW_ECHO_ICONS );
	}

}
