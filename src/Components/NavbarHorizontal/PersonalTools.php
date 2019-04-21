<?php
/**
 * File holding the NavbarHorizontal\PersonalTools class
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

	/**
	 * @return String
	 * @throws \FatalError
	 * @throws \MWException
	 */
	public function getHtml() {

		// start personal tools element
		return
			$this->indent() . '<!-- personal tools -->' .
			$this->indent() . '<div class="navbar-tools navbar-nav" >' .
			$this->indent( 1 ) . \Html::rawElement( 'div', [ 'class' => 'navbar-tool dropdown' ],

				$this->getDropdownToggle() .
				$this->indent( 1 ) . \Html::rawElement( 'div', [ 'class' => 'p-personal-tools dropdown-menu' ], $this->getTools() . $this->indent() ) .
				$this->indent( -1 )
			) .
			$this->indent( -1 ) . '</div>';
	}

	/**
	 * @param \User $user
	 *
	 * @return string
	 * @throws \FatalError
	 * @throws \MWException
	 */
	protected function getNewtalkNotifier() {

		$user = $this->getSkinTemplate()->getSkin()->getUser();

		$newMessagesAlert = $this->getSkinTemplate()->getMsg( 'chameleon-newmessages' )->text();
		$newtalks = $user->getNewMessageLinks();
		$out = $this->getSkinTemplate()->getSkin()->getOutput();

		// Allow extensions to disable the new messages alert
		if ( !Hooks::run( 'GetNewMessagesAlert', [ &$newMessagesAlert, $newtalks, $user, $out ] ) || count( $user->getNewMessageLinks() ) === 0 ) {
			return '';
		}

		$talkClass = $user->isLoggedIn() ? 'pt-mytalk' : 'pt-anontalk';

		$newtalkNotifier = $this->indent( 1 ) . '<span class="badge badge-pill badge-info ' . $talkClass . '" title="' . $newMessagesAlert . '" href="#"></span>';
		$this->indent( -1 );

		return $newtalkNotifier;
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
			$ret .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item, [ 'tag' => 'div' ] );
		}

		$this->indent( -1 );
		return $ret;
	}

	/**
	 * @return string
	 * @throws \FatalError
	 * @throws \MWException
	 */
	protected function getDropdownToggle(): string {

		$user = $this->getSkinTemplate()->getSkin()->getUser();

		if ( $user->isLoggedIn() ) {

			$toolsClass = 'navbar-userloggedin';
			$toolsLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-loggedin' )->params( $user->getName() )->text();

		} else {

			$toolsClass = 'navbar-usernotloggedin';
			$toolsLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-notloggedin' )->text();

		}

		\Hooks::run( 'ChameleonNavbarHorizontalPersonalToolsLinkText', [ &$toolsLinkText, $this->getSkin() ] );

		$this->indent( 1 );

		$dropdownToggle = IdRegistry::getRegistry()->element( 'a', [ 'class' => $toolsClass, 'href' => '#', 'data-toggle' => 'dropdown', 'data-boundary' => 'viewport', 'title' => $toolsLinkText ], $this->getNewtalkNotifier(), $this->indent() );

		$this->indent( -1 );

		return $dropdownToggle;
	}


}
