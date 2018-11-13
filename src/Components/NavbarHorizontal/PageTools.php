<?php
/**
 * File holding the NavbarHorizontal\PageTools class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2018, Stephan Gambke
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

use Skins\Chameleon\ChameleonTemplate;
use Skins\Chameleon\Components\Component;
use Skins\Chameleon\Components\PageTools as GenericPageTools;

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
	 * @return string
	 * @throws \ConfigException
	 * @throws \MWException
	 */
	public function getHtml() {

		$ret = '';

		$pageTools = new GenericPageTools( $this->getSkinTemplate(), $this->getDomElement(), $this->getIndent() + 2 );

		$pageTools->setFlat( true );

		// FIXME: This removing/adding of classes is super-ugly. Create and use a PageToolsBuilder class instead.
		$pageTools->removeClasses( 'pagetools' );
		$pageTools->addClasses( [ 'navbar-pagetools', 'dropdown-menu' ] );

		$editLinkHtml = $this->getEditLinkHtml( $pageTools );

		$pageToolsHtml = $pageTools->getHtml();

		if ( $editLinkHtml || $pageToolsHtml ) {
			$ret =
				$this->indent() . '<!-- page tools -->' .
				$this->indent() . '<div class="navbar-tools navbar-nav" >';

			$this->indent( 1 );

			if ( $editLinkHtml !== '' ) {
				$ret .= $this->indent() . $editLinkHtml;
			}

			if ( $pageToolsHtml !== '' ) {
				$ret .=
					$this->indent() . '<div class="navbar-tool dropdown">' .
					$this->indent( 1 ) . '<a data-toggle="dropdown" class="navbar-more-tools" href="#" title="' . $this->getSkinTemplate()->getMsg( 'specialpages-group-pagetools' )->text() . '" ></a>' .
					$pageToolsHtml .
					$this->indent( -1 ) . '</div>';
			}

			$ret .=
				$this->indent( -1 ) . '</div>';
		}

		return $ret;
	}

	/**
	 * @param GenericPageTools $pageTools
	 *
	 * @return string
	 */
	protected function getEditLinkHtml( $pageTools ) {

		$pageToolsStructure = $pageTools->getPageToolsStructure();

		foreach ( $this->getReplaceableEditActionIds() as $id ) {

			if ( array_key_exists( $id, $pageToolsStructure[ 'views' ] ) ) {
				return $this->getLinkAndRemoveFromPageToolStructure( $pageTools, $id );
			}
		}

		return '';
	}

	/**
	 * @param GenericPageTools $pageTools
	 * @param string $editActionId
	 *
	 * @return string
	 */
	protected function getLinkAndRemoveFromPageToolStructure( $pageTools, $editActionId ) {

		$pageToolsStructure  = $pageTools->getPageToolsStructure();
		$editActionStructure = $pageToolsStructure[ 'views' ][ $editActionId ];

		$editActionStructure[ 'text' ] = '';

		if ( array_key_exists( 'class', $editActionStructure ) ) {
			$editActionStructure[ 'class' ] .= ' navbar-tool';
		} else {
			$editActionStructure[ 'class' ] = 'navbar-tool';
		}

		$options = [
			'tag' => 'div',
		];

		$editLinkHtml = $this->getSkinTemplate()->makeListItem(
			$editActionId,
			$editActionStructure,
			$options
		);

		$pageTools->setRedundant( $editActionId );

		return $editLinkHtml;
	}

	/**
	 * @return string[]
	 */
	protected function getReplaceableEditActionIds() {

		$actionsToShow = array_map( 'trim',	explode( ',', $this->getDomElement()->getAttribute( 'show' ) ) );

		$editActionIds = [ 've-edit', 'edit' ];

		if ( array_key_exists( 'sfgRenameEditTabs', $GLOBALS ) && $GLOBALS[ 'sfgRenameEditTabs' ] === true ||
			array_key_exists( 'wgPageFormsRenameEditTabs', $GLOBALS ) && $GLOBALS[ 'wgPageFormsRenameEditTabs' ] === true ) {

			$editActionIds = array_merge( [ 'formedit', 'form_edit' ], $editActionIds );
		}

		return $editActionIds;
	}


}