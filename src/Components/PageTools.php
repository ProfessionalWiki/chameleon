<?php
/**
 * File holding the PageTools class
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

namespace Skins\Chameleon\Components;

use Action;
use MediaWiki\MediaWikiServices;
use Skins\Chameleon\ChameleonTemplate;
use Skins\Chameleon\IdRegistry;

/**
 * The PageTools class.
 *
 * An unordered list containing content navigation links (Page, Discussion,
 * Edit, History, Move, ...)
 *
 * The tab list is a list of lists: '<ul id="p-contentnavigation">
 *
 * @author  Stephan Gambke
 * @since   1.0
 * @ingroup Skins
 */
class PageTools extends Component {

	private $mFlat = false;

	/**
	 * PageTools constructor.
	 *
	 * @param ChameleonTemplate $template
	 * @param \DOMElement|null $domElement
	 * @param int $indent
	 *
	 * @throws \MWException
	 */
	public function __construct( ChameleonTemplate $template, \DOMElement $domElement = null,
		$indent = 0 ) {
		parent::__construct( $template, $domElement, $indent );
		$this->addClasses( 'pagetools' );
	}

	/**
	 * Builds the HTML code for this component
	 *
	 * @return string the HTML code
	 * @throws \ConfigException
	 * @throws \MWException
	 */
	public function getHtml() {
		$toolGroups = $this->getToolGroups();

		if ( $toolGroups === [] ) {
			return '';
		}

		return $this->indent() . '<!-- Content navigation -->' .
			IdRegistry::getRegistry()->element(
				'div',
				[ 'class' => $this->getClassString(), 'id' => 'p-contentnavigation' ],
				implode( $toolGroups ),
				$this->indent()
			);
	}

	/**
	 * @return string[]
	 * @throws \ConfigException
	 * @throws \MWException
	 */
	protected function getToolGroups() {
		$toolGroups = [];

		$this->indent( 1 );

		foreach ( $this->getContentNavigation() as $category => $tabsDescription ) {

			$toolGroup = $this->getToolGroup( $category, $tabsDescription );

			if ( $toolGroup !== null ) {
				$toolGroups[] = $toolGroup;
			}
		}

		$this->indent( -1 );

		return $toolGroups;
	}

	/**
	 * @return array
	 */
	private function getContentNavigation(): array {
		$contentNavigation = $this->getPageToolsStructure();

		$this->removeSelectedNamespaceIfNeedBe( $contentNavigation );
		$this->removeDiscussionLinkIfNeedBe( $contentNavigation );

		return $contentNavigation;
	}

	/**
	 * @param array &$contentNavigation
	 */
	private function removeSelectedNamespaceIfNeedBe( array &$contentNavigation ) {
		if ( $this->hideSelectedNamespace() ) {
			unset( $contentNavigation[ 'namespaces' ][ $this->getNamespaceKey() ] );
		}
	}

	/**
	 * @param array &$contentNavigation
	 */
	private function removeDiscussionLinkIfNeedBe( array &$contentNavigation ) {
		if ( $this->hideDiscussionLink() ) {
			$talkNamespaceKey = $this->getNamespaceKey() === 'main' ? 'talk' :
				$this->getNamespaceKey() . '_talk';

			unset( $contentNavigation[ 'namespaces' ][ $talkNamespaceKey ] );
		}
	}

	/**
	 * @return mixed
	 */
	public function getPageToolsStructure() {
		return $this->getSkinTemplate()->get( 'content_navigation', null );
	}

	/**
	 * @param mixed $pageToolsStructure
	 *
	 * @return void
	 */
	public function setPageToolsStructure( $pageToolsStructure ) {
		$this->getSkinTemplate()->set( 'content_navigation', $pageToolsStructure );
	}

	private function hideSelectedNamespace(): bool {
		return $this->attributeIsYes( 'hideSelectedNameSpace' )
			&& Action::getActionName( $this->getSkin() ) === 'view';
	}

	/**
	 * @return bool
	 */
	private function hideDiscussionLink(): bool {
		return $this->attributeIsYes( 'hideDiscussionLink' );
	}

	/**
	 * @param string $attributeName
	 *
	 * @return bool
	 */
	private function attributeIsYes( string $attributeName ): bool {
		return $this->getDomElement() !== null &&
			filter_var( $this->getDomElement()->getAttribute( $attributeName ), FILTER_VALIDATE_BOOLEAN );
	}

	/**
	 * Generate strings used for xml 'id' names in tabs
	 *
	 * Based on MW's Title::getNamespaceKey()
	 *
	 * Difference: This function here reports the actual namespace while the
	 * one in Title reports the subject namespace, i.e. no talk namespaces
	 *
	 * @return string
	 * @throws \ConfigException
	 */
	public function getNamespaceKey() {
		// Gets the subject namespace of this title
		$title = $this->getSkinTemplate()->getSkin()->getTitle();

		$namespaceKey = MediaWikiServices::getInstance()->getNamespaceInfo()->getCanonicalName(
			$title->getNamespace()
		);

		if ( $namespaceKey === false ) {
			$namespaceKey = $title->getNsText();
		}

		// Makes namespace key lowercase
		$namespaceKey =
			MediaWikiServices::getInstance()->getContentLanguage()->lc( $namespaceKey );

		if ( $namespaceKey === '' ) {
			return 'main';
		} elseif ( $namespaceKey === 'file' ) {
			return 'image';
		}

		return $namespaceKey;
	}

	/**
	 * @param string $category
	 * @param mixed[][] $tabsDescription
	 *
	 * @return string|null
	 * @throws \MWException
	 */
	protected function getToolGroup( $category, $tabsDescription ) {
		if ( empty( $tabsDescription ) ) {
			return null;
		}

		$comment = $this->indent() . "<!-- $category -->";

		if ( $this->mFlat ) {
			return $comment . implode( $this->getToolsForGroup( $tabsDescription ) );
		}

		return $comment .

			IdRegistry::getRegistry()->element( 'div',
				[ 'id' => 'p-' . $category ],

				IdRegistry::getRegistry()->element( 'div',
					[ 'class' => 'tab-group' ],

					implode( $this->getToolsForGroup( $tabsDescription, 2 ) ),

					$this->indent( 1 )
				),
				$this->indent( -1 )
			);
	}

	/**
	 * @param array $tabsDescription
	 *
	 * @param int $indent
	 *
	 * @return array
	 * @throws \MWException
	 */
	protected function getToolsForGroup( $tabsDescription, $indent = 0 ) {
		$tabs = [];
		$this->indent( $indent );

		foreach ( $tabsDescription as $key => $tabDescription ) {
			$tabs[] = $this->getTool( $tabDescription, $key );
		}

		$this->indent( -$indent );

		return $tabs;
	}

	/**
	 * @param mixed[] $tabDescription
	 * @param string $key
	 *
	 * @return string
	 * @throws \MWException
	 */
	protected function getTool( $tabDescription, $key ) {
		// skip redundant links (i.e. the 'view' link)
		// TODO: make this dependent on an option
		if ( array_key_exists( 'redundant', $tabDescription ) && $tabDescription[ 'redundant' ]
			=== true ) {
			return '';
		}

		// apply a link class if specified, e.g. for the currently active namespace
		$options = [
			'tag' => 'div'
		];
		if ( array_key_exists( 'class', $tabDescription ) ) {
			$options[ 'link-class' ] = $tabDescription[ 'class' ].' '.$tabDescription['id'];
		}

		return $this->indent() .
			$this->getSkinTemplate()->makeListItem( $key, $tabDescription, $options );
	}

	/**
	 * Set the page tool menu to have submenus or not
	 *
	 * @param bool $flat
	 */
	public function setFlat( $flat ) {
		$this->mFlat = $flat;
	}

	/**
	 * Set redundant tools
	 *
	 * @param string|string[] $tools
	 */
	public function setRedundant( $tools ) {
		$tools = (array)$tools;

		$pageToolsStructure = $this->getPageToolsStructure();

		foreach ( $tools as $tool ) {
			foreach ( $pageToolsStructure as $group => $groupStructure ) {
				if ( array_key_exists( $tool, $groupStructure ) ) {
					$pageToolsStructure[ $group ][ $tool ][ 'redundant' ] = true;
				}
			}
		}

		$this->setPageToolsStructure( $pageToolsStructure );
	}

}
