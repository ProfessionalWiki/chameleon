<?php
/**
 * File holding the NavbarHorizontal class
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

namespace Skins\Chameleon\Components;

use Skins\Chameleon\IdRegistry;

/**
 * The NavbarHorizontal class.
 *
 * A horizontal navbar containing the sidebar items.
 * Does not include standard items (toolbox, search, language links). They need to be added to the page elsewhere
 *
 * The navbar is a list of lists wrapped in a nav element: <nav role="navigation" id="p-navbar" >
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class NavbarHorizontal extends Component {

	private $mHtml = null;
	private $htmlId = null;

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		if ( $this->mHtml !== null ) {
			return $this->mHtml;
		}

		$this->mHtml = '';

		if ( $this->getDomElement() === null ) {
			return $this->mHtml;
		}

		// if a fixed navbar is requested
		if ( filter_var( $this->getDomElement()->getAttribute( 'fixed' ), FILTER_VALIDATE_BOOLEAN ) === true ||
			$this->getDomElement()->getAttribute( 'position' ) === 'fixed'
		) {

			// first build the actual navbar and set a class so it will be fixed
			$this->getDomElement()->setAttribute( 'fixed', '0' );
			$this->getDomElement()->setAttribute( 'position', '' );

			$realNav = new self( $this->getSkinTemplate(), $this->getDomElement(), $this->getIndent() );
			$realNav->setClasses( $this->getClassString() . ' navbar-fixed-top' );
			$this->mHtml .= $realNav->getHtml();

			// then add an invisible copy of the nav bar that will act as a spacer
			$this->addClasses( 'navbar-static-top invisible' );
		}

		$this->mHtml .=
			$this->indent() . '<!-- navigation bar -->' .
			$this->indent() .
			\HTML::openElement( 'nav', array(
					'class' => 'navbar navbar-default p-navbar ' . $this->getClassString(),
					'role' => 'navigation',
					'id' => $this->getHtmlId()
				)
			) .
			$this->indent( 1 ) . '<div class="container-fluid">';

		$this->indent( 1 );

		$headElements = array();
		$leftElements = array();
		$rightElements = array();

		$children = $this->getDomElement()->hasChildNodes() ? $this->getDomElement()->childNodes : array();

		// add components
		foreach ( $children as $node ) {

			if ( is_a( $node, 'DOMElement' ) && $node->tagName === 'component' && $node->hasAttribute( 'type' ) ) {

				switch ( $node->getAttribute( 'type' ) ) {
					case 'Logo':
						$html = $this->getLogo( $node );
						break;
					case 'NavMenu':
						$html = $this->getNavMenu( $node );
						break;
					case 'PageTools':
						$html = $this->getPageTools( $node );
						break;
					case 'SearchBar':
						$html = $this->getSearchBar( $node );
						break;
					case 'PersonalTools':
						$html = $this->getPersonalTools( $node );
						break;
					case 'Menu':
						$html = $this->getMenu( $node );
						break;
					default:
						$html = '';
				}

				$position = $node->getAttribute( 'position' );

				switch ( $position ) {
					case 'head':
						$headElements[ ] = $html;
						break;
					case 'right':
						$rightElements[ ] = $html;
						break;
					case 'left':
					default:
						$leftElements[ ] = $html;
				}
			}
		}

		if ( !empty( $rightElements ) ) {
			$leftElements[ ] =
				'<div class="navbar-right-aligned">' .
				implode( $rightElements ) .
				'</div>';
		}

		$this->mHtml .=
			$this->buildHead( $headElements ) .
			$this->buildTail( $leftElements ) .
			$this->indent( -1 ) . '</div>' .
			$this->indent( -1 ) . '</nav>' . "\n";

		return $this->mHtml;
	}

	protected function buildHead( $headElements ) {
		// TODO: Break this down in several properly indented elements
		$head = "<div class=\"navbar-header\">
      <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#" . $this->getHtmlId() . "-collapse\">
        <span class=\"sr-only\">Toggle navigation</span>" .
			str_repeat( "<span class=\"icon-bar\"></span>", 3 ) .
			"</button>" .
			implode( '', $headElements ) . "</div>";

		return $head;
	}

	protected function buildTail( $tailElements ) {

		return '<div class="collapse navbar-collapse" id="' . $this->getHtmlId() . '-collapse">' .
		implode( '', $tailElements ) . '</div><!-- /.navbar-collapse -->';
	}

	private function getHtmlId() {
		if ( $this->htmlId === null ) {
			$this->htmlId = IdRegistry::getRegistry()->getId( 'mw-navigation' );
		}
		return $this->htmlId;
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

//        return \Html::rawElement( 'li', array(), $logo->getHtml() );
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
				$this->indent() . '<ul class="nav navbar-nav">' . \Html::openElement( 'li', array( 'class' => 'dropdown' ) ) .
				$this->indent( 1 ) . '<a data-toggle="dropdown" class="dropdown-toggle" href="#">Page Tools <b class="caret"></b></a>' .
				$ret .
				$this->indent( -1 ) . '</li></ul>' . "\n";
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

		return '<ul class="nav navbar-nav">' . $navMenu->getHtml() . "</ul>\n";

	}

	/**
	 * Creates a list of navigational links from a message key or message text
	 *
	 * @param \DOMElement $domElement
	 *
	 * @return string
	 */
	protected function getMenu( \DOMElement $domElement = null ) {

		$menu = new Menu( $this->getSkinTemplate(), $domElement, $this->getIndent() );

		return '<ul class="nav navbar-nav">' . $menu->getHtml() . "</ul>\n";

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
			$toolsClass = 'navbar-userloggedin';
			$toolsLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-loggedin' )->params( $user->getName() )->text();
		} else {
			$toolsClass = 'navbar-usernotloggedin';
			$toolsLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-notloggedin' )->text();
		}

		// start personal tools element

		$ret =
			$this->indent() . '<!-- personal tools -->' .
			$this->indent() . '<ul class="navbar-personaltools" >' .
			$this->indent( 1 ) . '<li class="dropdown navbar-personaltools-tools">' .
			$this->indent( 1 ) . '<a class="dropdown-toggle glyphicon glyphicon-user ' . $toolsClass . '" href="#" data-toggle="dropdown" title="' . $toolsLinkText . '" ></a>' .
			$this->indent() . '<ul class="p-personal-tools dropdown-menu dropdown-menu-right" >';

		$this->indent( 1 );

		// add personal tools (links to user page, user talk, prefs, ...)
		foreach ( $this->getSkinTemplate()->getPersonalTools() as $key => $item ) {
			$ret .= $this->indent() . $this->getSkinTemplate()->makeListItem( $key, $item );
		}

		$ret .=
			$this->indent( -1 ) . '</ul>';

		// if the user is logged in, add the newtalk notifier
		if ( $user->isLoggedIn() ) {

			$newMessagesAlert = '';
			$newtalks = $user->getNewMessageLinks();
			$out = $this->getSkinTemplate()->getSkin()->getOutput();

			// Allow extensions to disable the new messages alert;
			// since we do not display the link text, we ignore the actual value returned in $newMessagesAlert
			if ( wfRunHooks( 'GetNewMessagesAlert', array( &$newMessagesAlert, $newtalks, $user, $out ) ) ) {

				if ( count( $user->getNewMessageLinks() ) > 0 ) {
					$newtalkClass = 'navbar-newtalk-available';
					$newtalkLinkText = $this->getSkinTemplate()->getMsg( 'chameleon-newmessages' )->text();
				} else {
					$newtalkClass = 'navbar-newtalk-not-available';
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
