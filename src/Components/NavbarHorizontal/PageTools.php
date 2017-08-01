<?php
/**
 * File holding the NavbarHorizontal\PageTools class
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

use Skins\Chameleon\Components\Component;
use Skins\Chameleon\Components\PageTools as GenPageTools;

/**
 * The NavbarHorizontal\PageTools class.
 *
 * Provides a PageTools component to be included in a NavbarHorizontal component.
 *
 * @author Stephan Gambke
 * @since 1.6
 * @ingroup Skins
 */
class PageTools extends Component {

	/**
	 * @return String
	 */
	public function getHtml() {

		$ret = '';

		$pageTools = new GenPageTools( $this->getSkinTemplate(), $this->getDomElement(), $this->getIndent() + 1 );

		$pageTools->setFlat( true );
		$pageTools->removeClasses( 'text-center list-inline' );
		$pageTools->addClasses( 'dropdown-menu' );

		$editLinkHtml = $this->getEditLinkHtml( $pageTools );

		$pageToolsHtml = $pageTools->getHtml();

		if ( $editLinkHtml || $pageToolsHtml ) {
			$ret =
				$this->indent() . '<!-- page tools -->' .
				$this->indent() . '<ul class="navbar-tools navbar-nav" >';

			if ( $editLinkHtml !== '' ) {
				$ret .= $this->indent( 1 ) . $editLinkHtml;
			}

			if ( $pageToolsHtml !== '' ) {
				$ret .=
					$this->indent( 1 ) . '<li class="navbar-tools-tools dropdown">' .
					$this->indent( 1 ) . '<a data-toggle="dropdown" class="dropdown-toggle" href="#" title="' . $this->getSkinTemplate()->getMsg( 'specialpages-group-pagetools' )->text() . '" ><span>...</span></a>' .
					$pageToolsHtml .
					$this->indent( -1 ) . '</li>';
			}

			$ret .=
				$this->indent( -1 ) . '</ul>' . "\n";
		}

		return $ret;
	}

	/**
	 * @param $pageTools
	 * @return string
	 */
	protected function getEditLinkHtml( $pageTools ) {

		$pageToolsStructure = $pageTools->getPageToolsStructure();

		if ( array_key_exists( 'views', $pageToolsStructure ) &&
			array_key_exists( 'sfgRenameEditTabs', $GLOBALS ) &&
			array_key_exists( 'formedit', $pageToolsStructure[ 'views' ] ) && // SemanticForms 3.5+
			$GLOBALS[ 'sfgRenameEditTabs' ] === true

		) {

			$editLinkHtml = $this->getLinkAndRemoveFromPageToolStructure( $pageTools, 'formedit' );
			return $editLinkHtml;

		} elseif ( array_key_exists( 'views', $pageToolsStructure ) &&
			array_key_exists( 'sfgRenameEditTabs', $GLOBALS ) &&
			array_key_exists( 'form_edit', $pageToolsStructure[ 'views' ] ) && // SemanticForms <3.5
			$GLOBALS[ 'sfgRenameEditTabs' ] === true

		) {

			$editLinkHtml = $this->getLinkAndRemoveFromPageToolStructure( $pageTools, 'form_edit' );
			return $editLinkHtml;

		} elseif ( array_key_exists( 'views', $pageToolsStructure ) &&
			array_key_exists( 've-edit', $pageToolsStructure[ 'views' ] )
		) {

			$editLinkHtml = $this->getLinkAndRemoveFromPageToolStructure( $pageTools, 've-edit' );
			return $editLinkHtml;

		} elseif ( array_key_exists( 'views', $pageToolsStructure ) &&
			array_key_exists( 'edit', $pageToolsStructure[ 'views' ] )
		) {

			$editLinkHtml = $this->getLinkAndRemoveFromPageToolStructure( $pageTools, 'edit' );
			return $editLinkHtml;

		}
		return '';
	}

	/**
	 * @param $pageTools
	 * @param $editActionId
	 *
	 * @return string
	 */
	protected function getLinkAndRemoveFromPageToolStructure( $pageTools, $editActionId ) {

		$pageToolsStructure  = $pageTools->getPageToolsStructure();
		$editActionStructure = $pageToolsStructure[ 'views' ][ $editActionId ];

		$editActionStructure[ 'text' ] = '';

		if ( array_key_exists( 'class', $editActionStructure ) ) {
			$editActionStructure[ 'class' ] .= ' navbar-tools-tools';
		} else {
			$editActionStructure[ 'class' ] = 'navbar-tools-tools';
		}

		$options = array (
			'text-wrapper' => array(
				'tag' => 'span',
				'attributes' => array('class' => 'glyphicon glyphicon-pencil',)
			),
		);

		$editLinkHtml = $this->getSkinTemplate()->makeListItem(
			$editActionId,
			$editActionStructure,
			$options
		);

		$pageTools->setRedundant( $editActionId );

		return $editLinkHtml;
	}


}