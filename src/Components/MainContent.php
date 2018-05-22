<?php
/**
 * File holding the MainContent class
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

namespace Skins\Chameleon\Components;

use Skins\Chameleon\IdRegistry;

/**
 * The MainContent class.
 *
 * FIXME: Extract into separate modules/allow as plugins: TOC, CategoryLinks, NewtalkNotifier, Indicators
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class MainContent extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {

		$idRegistry = IdRegistry::getRegistry();

		$topAnchor = $idRegistry->element( 'a', [ 'id' => 'top' ] );
		$mwIndicators = $idRegistry->element( 'div', [ 'id' => 'mw-indicators', 'class' => 'mw-indicators', ], $this->buildMwIndicators() );

		$mwBody =
			$topAnchor .
			$this->indent( 1 ) . $mwIndicators .

			$this->buildContentHeader() .
			$this->buildContentBody() .
			$this->buildCategoryLinks() .
			$this->indent( -1 );

		return
			$this->indent() . '<!-- start the content area -->' .
			$this->indent() . $idRegistry->element(
				'div',
				[ 'id' => 'content', 'class' => 'mw-body ' . $this->getClassString() ],
				$mwBody
			);
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildContentHeader() {

		$skintemplate = $this->getSkinTemplate();
		$idRegistry = IdRegistry::getRegistry();

		$firstHeading =
			$this->indent( 1 ) . '<!-- title of the page -->' .
			$this->indent() . $idRegistry->element( 'h1', [ 'id' => 'firstHeading' ], $skintemplate->get( 'title' ) );

		$siteSub =
			$this->indent() . '<!-- tagline; usually goes something like "From WikiName" primary purpose of this seems to be for printing to identify the source of the content -->' .
			$this->indent() . $idRegistry->element( 'div', [ 'id' => 'siteSub' ], $skintemplate->getMsg( 'tagline' )->escaped() );

		$contentSub = '';

		if ( $skintemplate->get( 'subtitle' ) ) {

			// TODO: should not use class 'small', better use class 'contentSub' and do styling in a scss file
			$contentSub =
				$this->indent() . '<!-- subtitle line; used for various things like the subpage hierarchy -->' .
				$this->indent() . $idRegistry->element( 'div', [ 'id' => 'contentSub', 'class' => 'small' ], $skintemplate->get( 'subtitle' ) );

		}

		$contentSub2 = '';

		if ( $skintemplate->get( 'undelete' ) ) {
			// TODO: should not use class 'small', better use class 'contentSub2' and do styling in a scss file
			$contentSub2 =
				$this->indent() . '<!-- undelete message -->' .
				$this->indent() . $idRegistry->element( 'div', [ 'id' => 'contentSub2', 'class' => 'small' ], $skintemplate->get( 'undelete' ) );
		}

		// TODO: This should be put in a separate component (and appear at the very beginning of the page right after the <body>
		$jumpToNav = $idRegistry->element(
			'div',
			[ 'id' => 'jump-to-nav', 'class' => 'mw-jump' ],
			$skintemplate->getMsg( 'jumpto' )->escaped() . $idRegistry->element( 'a', [ 'href' => '#mw-navigation' ], $skintemplate->getMsg( 'jumptonavigation' )->escaped() ) .
			$skintemplate->getMsg( 'comma-separator' )->escaped() . $idRegistry->element( 'a', [ 'href' => '#p-search' ], $skintemplate->getMsg( 'jumptosearch' )->escaped() )
		);

		$ret = $this->indent() . $idRegistry->element( 'div', [ 'class' => "contentHeader" ],

			$firstHeading .
			$siteSub .
			$contentSub .
			$contentSub2 .
			$jumpToNav .
			$this->indent( -1 )
			);

		return $ret;
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildContentBody() {
		return
			$this->indent() . IdRegistry::getRegistry()->element(
				'div',
				[ 'id' => 'bodyContent' ],

				$this->indent( 1 ) . '<!-- body text -->' . "\n" .
				$this->indent() . $this->getSkinTemplate()->get( 'bodytext' ) .
				$this->indent() . '<!-- end body text -->' .
				$this->buildDataAfterContent() .
				$this->indent( -1 )
			);
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildCategoryLinks() {

		// TODO: Category links should be a separate component, but
		// * dataAfterContent should come after the the category links.
		// * only one extension is known to use it dataAfterContent and it is geared specifically towards MonoBook
		// => provide an attribute hideCatLinks for the XML and -if present- hide category links and assume somebody knows what they are doing?
		// => alternatively provide a sub-component CategoryLinks and use it if present in the layout DOM

		return
			$this->indent() . '<!-- category links -->' .
			$this->indent() . $this->getSkinTemplate()->get( 'catlinks' );
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildDataAfterContent() {

		$dataAfterContent = $this->getSkinTemplate()->get( 'dataAfterContent' );

		if ( $dataAfterContent !== null ) {
			return
				$this->indent() . '<!-- data blocks which should go somewhere after the body text, but not before the catlinks block-->' .
				$this->indent() . $dataAfterContent;
		}

		return '';
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	private function buildMwIndicators() {

		$idRegistry = IdRegistry::getRegistry();
		$indicators = $this->getSkinTemplate()->get( 'indicators' );

		if ( !is_array( $indicators ) || count( $indicators ) === 0 ) {
			return '';
		}

		$this->indent( 1 );

		$ret = '';

		foreach ( $indicators as $id => $content ) {
			$ret .=
				$this->indent() .
				$idRegistry->element(
					'div',
					[ 'id' => \Sanitizer::escapeId( "mw-indicator-$id" ), 'class' => 'mw-indicator' ],
					$content
				);
		}

		$ret .= $this->indent( -1 );

		return $ret;
	}

}
