<?php
/**
 * File holding the NavbarHorizontal\PersonalTools class
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

use Hooks;
use Skins\Chameleon\Components\Component;

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

	/**
	 * @return String
	 * @throws \FatalError
	 * @throws \MWException
	 */
	public function getHtml() {

		$user = $this->getSkinTemplate()->getSkin()->getUser();

		if ( $user->isLoggedIn() ) {
			$toolsClass = 'navbar-userloggedin';
			$toolsLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-loggedin' )->params( $user->getName() )->text();
		} else {
			$toolsClass = 'navbar-usernotloggedin';
			$toolsLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-notloggedin' )->text();
		}

		\Hooks::run('ChameleonNavbarHorizontalPersonalToolsLinkText', [ &$toolsLinkText, $this->getSkin() ] );

		// start personal tools element
		return
			$this->indent() . '<!-- personal tools -->' .
			$this->indent() . '<div class="navbar-tools navbar-nav" >' .
			$this->indent( 1 ) . \Html::rawElement( 'div', [ 'class' => 'navbar-tool dropdown' ],

				$this->indent( 1 ) . \Html::rawElement( 'a', [ 'class' => $toolsClass, 'href' => '#', 'data-toggle' => 'dropdown', 'title' => $toolsLinkText ] ) .
				$this->indent() . \Html::rawElement( 'ul', [ 'class' => 'p-personal-tools dropdown-menu dropdown-menu-right' ], $this->getTools() . $this->indent() ) .
				$this->indent( -1 )
			) .
			$this->getNewtalkNotifier( $user ) .
			$this->indent( -1 ) . '</div>';
	}

	/**
	 * @param \User $user
	 *
	 * @return string
	 * @throws \FatalError
	 * @throws \MWException
	 */
	protected function getNewtalkNotifier( \User $user ) {

		// if the user is logged in, add the newtalk notifier
		if ( $user->isLoggedIn() ) {

			$newMessagesAlert = '';
			$newtalks = $user->getNewMessageLinks();
			$out = $this->getSkinTemplate()->getSkin()->getOutput();

			// Allow extensions to disable the new messages alert;
			// since we do not display the link text, we ignore the actual value returned in $newMessagesAlert
			if ( Hooks::run( 'GetNewMessagesAlert', [ &$newMessagesAlert, $newtalks, $user, $out ] ) ) {

				if ( count( $user->getNewMessageLinks() ) > 0 ) {
					$newtalkClass = 'navbar-newtalk-available';
					$newtalkLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-newmessages' )->text();
				} else {
					$newtalkClass = 'navbar-newtalk-not-available';
					$newtalkLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-nonewmessages' )->text();
				}

				// FIXME: Glyphicon???
				$linkText = '<span class="glyphicon glyphicon-envelope"></span>';
				\Hooks::run( 'ChameleonNavbarHorizontalNewTalkLinkText', [ &$linkText, $this->getSkin() ] );

				return $this->indent() . '<li class="navbar-newtalk-notifier">' .
					$this->indent( 1 ) . '<a class="dropdown-toggle ' . $newtalkClass . '" title="' .
					$newtalkLinkText . '" href="' . $user->getTalkPage()->getLinkURL( 'redirect=no' ) . '">' . $linkText . '</a>' .
					$this->indent( -1 ) . '</li>';

			}

		}
		return '';
	}

	/**
	 * @param $ret
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function getTools( ) {

		$this->indent( 1 );
		$ret = '';

		// add personal tools (links to user page, user talk, prefs, ...)
		foreach ( $this->getSkinTemplate()->getPersonalTools() as $key => $item ) {
			$ret .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item );
		}

		$this->indent( -1 );
		return $ret;
	}


}