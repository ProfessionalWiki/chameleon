<?php
/**
 * File holding the NavbarHorizontal\PageTools class
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

		$pageTools = $this->createGenericPageTools();

		$this->indent( 1 );
		$actionButtonHtmlFragments = $this->getActionButtonsHtml( $pageTools );
		$pageTools->setRedundant( array_keys( $actionButtonHtmlFragments ) );
		$pageToolsHtml = $this->getPageToolsHtml( $pageTools );
		$this->indent( -1 );

		if ( $actionButtonHtmlFragments !== [] || $pageToolsHtml !== '' ) {

			return
				$this->indent() . '<!-- page tools -->' .
				$this->indent() . \Html::rawElement( 'div', [ 'class' => 'navbar-tools navbar-nav ' . $this->getClassString() ],
					join( $actionButtonHtmlFragments ) .
					$pageToolsHtml .
					$this->indent()
				);
		}

		return '';
	}

	/**
	 * @return GenericPageTools
	 * @throws \MWException
	 */
	protected function createGenericPageTools() {

		$pageTools = new GenericPageTools( $this->getSkinTemplate(), $this->getDomElement(), $this->getIndent() + 2 );

		$pageTools->setFlat( true );

		// FIXME: This removing/adding of classes is super-ugly. Create and use a PageToolsBuilder class instead.
		$pageTools->removeClasses( 'pagetools' );
		$pageTools->addClasses( [ 'navbar-pagetools', 'dropdown-menu' ] );

		return $pageTools;
	}

	/**
	 * @param GenericPageTools $pageTools
	 *
	 * @return string[]
	 * @throws \MWException
	 */
	protected function getActionButtonsHtml( $pageTools ) {

		$htmlFragments = [];

		foreach ( $this->getReplaceableActions() as $actionGroup ) {

			foreach ( $actionGroup as $actionId ) {

				$actionLink = $this->getActionLink( $pageTools, $actionId );

				if ( $actionLink !== '' ) {

					$htmlFragments[ $actionId ] = $this->indent() . $actionLink;
					break;
				}
			}
		}

		return $htmlFragments;
	}

	/**
	 * @return string[][]
	 */
	protected function getReplaceableActions() {

		$actionList = $this->getAttribute( 'buttons', 'edit' );

		$actions = [];

		foreach ( explode( ',', $actionList ) as $action ) {

			$action = trim( $action );

			if ( $action === 'edit' ) {
				$actions[] = [ 'formedit', 'form_edit', 've-edit', 'edit' ];
			} else {
				$actions[] = [ $action ];
			}
		}

		return $actions;
	}

	/**
	 * @param GenericPageTools $pageTools
	 * @param string $editActionId
	 *
	 * @return string
	 */
	protected function getActionLink( $pageTools, $editActionId ) {

		$editActionStructure = $this->getActionDescriptor( $pageTools, $editActionId );

		if ( $editActionStructure === null ) {
			return '';
		}

		$editActionStructure[ 'text' ] = '';

		if ( array_key_exists( 'class', $editActionStructure ) ) {
			$editActionStructure[ 'class' ] .= ' navbar-tool';
		} else {
			$editActionStructure[ 'class' ] = 'navbar-tool';
		}

		$options = [
			'tag' => 'div',
			'link-class' => 'navbar-tool-link',
		];

		return $this->getSkinTemplate()->makeListItem(
			$editActionId,
			$editActionStructure,
			$options
		);
	}

	/**
	 * @param GenericPageTools $pageTools
	 * @param string $action
	 *
	 * @return mixed
	 */
	protected function getActionDescriptor( $pageTools, $action ) {

		$pageToolsStructure = $pageTools->getPageToolsStructure();

		foreach ( $pageToolsStructure as $group => $groupStructure ) {
			if ( array_key_exists( $action, $groupStructure ) ) {
				return $pageToolsStructure[ $group ][ $action ];
			}
		}

		return null;
	}

	/**
	 * @param GenericPageTools $pageTools
	 *
	 * @return string
	 * @throws \ConfigException
	 * @throws \MWException
	 */
	protected function getPageToolsHtml( GenericPageTools $pageTools ) {

		$pageToolsHtml = $pageTools->getHtml();

		if ( $pageToolsHtml === '' ) {
			return '';
		}

		return
			$this->indent() . \Html::rawElement( 'div', [ 'class' => 'navbar-tool dropdown' ],
				$this->indent( 1 ) . \Html::rawElement( 'a', [ 'data-toggle' => 'dropdown', 'data-boundary' => 'viewport', 'class' => 'navbar-more-tools', 'href' => '#', 'title' => $this->getSkinTemplate()->getMsg( 'specialpages-group-pagetools' )->text() ] ) .
				$pageToolsHtml .
				$this->indent( -1 )
			);
	}


}
