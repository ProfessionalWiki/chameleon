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

use MediaWiki\MediaWikiServices;
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
	private const SHOW_USER_NAME_NONE = 'none';
	private const SHOW_USER_NAME_TRY_REALNAME = 'try-realname';
	private const SHOW_USER_NAME_USERNAME_ONLY = 'username-only';
	// Boolean values for showUserName deprecated since Chameleon 4.2.0:
	private const SHOW_USER_NAME_NO = 'no';
	private const SHOW_USER_NAME_YES = 'yes';
	private const ATTR_PROMOTE_LONE_ITEMS = 'promoteLoneItems';

	/**
	 * @return String
	 * @throws \FatalError
	 * @throws \MWException
	 */
	public function getHtml() {
		$tools = $this->getSkinTemplate()->getPersonalTools();

		// Flatten classes to avoid MW bug: https://phabricator.wikimedia.org/T262160
		// NB: This bug is finally fixed in MW >=1.36.
		foreach ( $tools as $key => $item ) {
			if ( !empty( $item['links'][0]['class'] ) && is_array( $item['links'][0]['class'] ) ) {
				$tools[$key]['links'][0]['class'] = implode( ' ', $item['links'][0]['class'] );
			}
		}

		// start personal tools element
		$echoHtml = '';
		if ( $this->getShowEcho() === self::SHOW_ECHO_ICONS ) {
			$echoHtml = $this->indent() . $this->getEchoIcons( $tools );
		}

		if ( count( $tools ) == 1 ) {
			$promotableItems =
				array_map( 'trim',
					explode( ';', $this->getAttribute( self::ATTR_PROMOTE_LONE_ITEMS ) ) );
			$loneKey = array_key_first( $tools );
			if ( in_array( $loneKey, $promotableItems, true ) ) {
				$item = $tools[$loneKey];
				return $echoHtml .
					$this->indent() . '<!-- personal tools, lone item -->' .
					$this->indent() . '<div class="navbar-tools navbar-nav" >' .
					$this->indent( 1 ) . $this->getSkinTemplate()->makeListItem(
						$loneKey, $item,
						[
							'tag' => 'div',
							'link-class' => 'nav-link ' . ($item['id'] ?? ''),
						] ) .
					$this->indent( -1 ) . '</div>';
			}
        }

		return $echoHtml .
			$this->indent() . '<!-- personal tools -->' .
			$this->indent() . '<div class="navbar-tools navbar-nav" >' .
			$this->indent( 1 ) . \Html::rawElement( 'div', [ 'class' => 'navbar-tool dropdown' ],

				$this->getDropdownToggle() .
				$this->indent( 1 ) . \Html::rawElement( 'div',
					[ 'class' => 'p-personal-tools dropdown-menu' ],
					$this->getToolsHtml( $tools ) . $this->indent() ) .
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
		$user = $this->getSkinTemplate()->getSkin()->getUser();
		if ( $user->isRegistered() ) {
			$showUserName = $this->getAttribute( self::ATTR_SHOW_USER_NAME );
			if ( ( $showUserName == self::SHOW_USER_NAME_TRY_REALNAME ) ||
				 ( $showUserName == self::SHOW_USER_NAME_YES ) ) {
				$username = !empty( $user->getRealName() ) ? $user->getRealName() : $user->getName();
				return '<span class="user-name">' . htmlspecialchars( $username ) . '</span>';
			} elseif ( $showUserName == self::SHOW_USER_NAME_USERNAME_ONLY ) {
				return '<span class="user-name">' . htmlspecialchars( $user->getName() ) . '</span>';
			}
		}
		return '';
	}

	/**
	 * @param array $tools
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function getToolsHtml( $tools ) {
		$this->indent( 1 );
		$ret = '';

		// add personal tools (links to user page, user talk, prefs, ...)
		foreach ( $tools as $key => $item ) {
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
	 * @param array $tools
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function getEchoIcons( $tools ) {
		$items = '';

		foreach ( $tools as $key => $item ) {
			if ( in_array( $key, self::ECHO_LINK_KEYS ) ) {
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

		// TODO Rename '...LinkText' to '...LinkTitle' in both the hook and variable.
		MediaWikiServices::getInstance()->getHookContainer()->run( 'ChameleonNavbarHorizontalPersonalToolsLinkText', [ &$toolsLinkText,
			$this->getSkin() ] );

		$newtalkNotifierHtml = $this->getNewtalkNotifier();
		$userNameHtml = $this->getUserName();
		MediaWikiServices::getInstance()->getHookContainer()->run( 'ChameleonNavbarHorizontalPersonalToolsLinkInnerHtml',
			[ &$newtalkNotifierHtml, &$userNameHtml, $this ] );

		$this->indent( 1 );

		$dropdownToggle = IdRegistry::getRegistry()->element( 'a', [ 'class' => $toolsClass,
			'href' => '#', 'data-toggle' => 'dropdown', 'data-boundary' => 'viewport',
			'title' => $toolsLinkText ], $newtalkNotifierHtml . $userNameHtml,
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
