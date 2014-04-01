<?php
/**
 * File holding the NavbarHorizontal class
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license       http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki extension Chameleon.
 * The Chameleon extension is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Chameleon extension is distributed in the hope that it will be useful,
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

namespace skins\chameleon\components;

use Linker;
use skins\chameleon\IdRegistry;

/**
 * The NavbarHorizontal class.
 *
 * A horizontal navbar containing the sidebar items.
 * Does not include standard items (toolbox, search, language links). They need to be added to the page elsewhere
 *
 * The navbar is a list of lists wrapped in a nav element: <nav role="navigation" id="p-navbar" >
 *
 * @ingroup Skins
 */
class NavbarHorizontal extends Component {

	private $mHtml = '';

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$this->mHtml =
			$this->indent() . '<!-- navigation bar -->' .
			$this->indent() .
			\HTML::openElement( 'nav', array(
					'class' => 'navbar navbar-default p-navbar ' . $this->getClassString(),
					'role'  => 'navigation',
					'id'    => IdRegistry::getRegistry()->getId( 'mw-navigation' )
				)
			) .
			$this->indent( 1 ) . '<ul class="nav navbar-nav">';

		$this->indent( 1 );

		// add components
		$this->eachChild( function ( \DOMElement $node ) {

				if ( $node->tagName !== 'component' || !$node->hasAttribute( 'type' ) ) {
					return;
				}

				switch ( $node->getAttribute( 'type' ) ) {
					case 'Logo':
						$this->mHtml .= $this->getLogo( $node );
						break;
					case 'NavMenu':
						$this->mHtml .= $this->getNavMenu( $node );
						break;
					case 'PageTools':
						$this->mHtml .= $this->getPageTools( $node );
						break;
					case 'SearchBar':
						$this->mHtml .= $this->getSearchBar( $node );
						break;
					case 'PersonalTools':
						$this->mHtml .= $this->getPersonalTools( $node );
						break;
				}
			}
		);

		$this->mHtml .= $this->indent( -1 ) . '</ul>' .
			$this->indent( -1 ) . '</nav>' . "\n";

		return $this->mHtml;
	}

	/**
	 * Creates HTML code for the wiki logo in a navbar
	 *
	 * @param \DOMElement $domElement
	 *
	 * @return String
	 */
	protected function getLogo( \DOMElement $domElement = null ) {

		$logo = new Logo( $this->getSkinTemplate(), $domElement, $this->getIndent() );
		$logo->addClasses( 'navbar-brand' );

		return $logo->getHtml();
	}

	/**
	 * Create a dropdown containing the page tools (page, talk, edit, history, ...)
	 *
	 * @param \DOMElement $domElement
	 *
	 * @return string
	 */
	protected function getPageTools( \DOMElement $domElement = null ) {

		$pageTools = new PageTools( $this->getSkinTemplate(), $domElement, $this->getIndent() );

		$pageTools->setFlat( true );
		$pageTools->removeClasses( 'text-center list-inline' );
		$pageTools->addClasses( 'dropdown-menu' );

		$ret = $pageTools->getHtml();

		if ( $ret !== '' ) {
			$ret =
				$this->indent() . '<!-- page tools -->' .
				$this->indent() . \Html::openElement( 'li', array( 'class' => 'dropdown' ) ) .
				$this->indent( 1 ) . '<a data-toggle="dropdown" class="dropdown-toggle" href="#">Page Tools <b class="caret"></b></a>' .
				$ret .
				$this->indent( -1 ) . '</li>' . "\n";
		}
		return $ret;
	}

	/**
	 * Creates a list of navigational links usually found in the sidebar
	 *
	 * @param \DOMElement $domElement
	 *
	 * @return string
	 */
	protected function getNavMenu( \DOMElement $domElement = null ) {

		$navMenu = new NavMenu( $this->getSkinTemplate(), $domElement, $this->getIndent() );

		return $navMenu->getHtml() . "\n";

	}

	/**
	 * Creates a user's personal tools and the newtalk notifier
	 *
	 * @param \DOMElement $domElement
	 *
	 * @return string
	 */
	protected function getPersonalTools( \DOMElement $domElement = null ) {

		$user = $this->getSkinTemplate()->getSkin()->getUser();

		if ( $user->isLoggedIn() ) {
			$toolsClass    = 'navbar-userloggedin';
			$toolsLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-loggedin' )->params( $user->getName() )->text();
		} else {
			$toolsClass    = 'navbar-usernotloggedin';
			$toolsLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-notloggedin' )->text();
		}

		// start personal tools element

		$ret =
			$this->indent() . '<!-- personal tools -->' .
			$this->indent() . '<ul class="navbar-right navbar-nav navbar-personaltools" >' .
			$this->indent( 1 ) . '<li class="dropdown navbar-personaltools-tools">' .
			$this->indent( 1 ) . '<a class="dropdown-toggle glyphicon glyphicon-user ' . $toolsClass . '" href="#" data-toggle="dropdown" title="' . $toolsLinkText . '" ></a>' .
			$this->indent() . '<ul class="p-personal-tools dropdown-menu" >';

		$this->indent( 1 );

		// add personal tools (links to user page, user talk, prefs, ...)
		foreach ( $this->getSkinTemplate()->getPersonalTools() as $key => $item ) {
			$ret .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item );
		}

		$ret .= $this->indent( -1 ) . '</ul>' .
			$this->indent( -1 ) . '</li>';

		// if the user is logged in, add the newtalk notifier
		if ( $user->isLoggedIn() ) {

			$newMessagesAlert = '';
			$newtalks         = $user->getNewMessageLinks();
			$out              = $this->getSkinTemplate()->getSkin()->getOutput();

			// Allow extensions to disable the new messages alert;
			// since we do not display the link text, we ignore the actual value returned in $newMessagesAlert
			if ( wfRunHooks( 'GetNewMessagesAlert', array( &$newMessagesAlert, $newtalks, $user, $out ) ) ) {

				if ( count( $user->getNewMessageLinks() ) > 0 ) {
					$newtalkClass    = 'navbar-newtalk-available';
					$newtalkLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-newmessages' )->text();
				} else {
					$newtalkClass    = 'navbar-newtalk-unavailable';
					$newtalkLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-nonewmessages' )->text();
				}

				$ret .= $this->indent() . '<li class="navbar-newtalk-notifier">' .
					$this->indent( 1 ) . '<a class="dropdown-toggle glyphicon glyphicon-envelope ' . $newtalkClass . '" title="' .
					$newtalkLinkText . '" href="' . $user->getTalkPage()->getLinkURL() . '?redirect=no"></a>' .
					$this->indent( -1 ) . '</li>';

			}

		}

		$ret .= $this->indent( -1 ) . '</ul>' . "\n";

		return $ret;
	}

	protected function getSearchBar( \DOMElement $domElement = null ) {

		$search = new SearchBar( $this->getSkinTemplate(), $domElement, $this->getIndent() );
		$search->addClasses( 'navbar-form' );

		return $search->getHtml();
	}

}
