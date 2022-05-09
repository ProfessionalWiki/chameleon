<?php
/**
 * File holding the ContentHeader class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2022, gesinn-it-wam
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

use Skins\Chameleon\IdRegistry;

/**
 * The ContentHeader component
 *
 * @author gesinn-it-wam
 * @since 4.2
 * @ingroup Skins
 */
class ContentHeader extends Component {

	/**
	 * @inheritDoc
	 * @throws \MWException
	 */
	public function getHtml(): string {
		return $this->buildContentHeader();
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildContentHeader(): string {
		$skintemplate = $this->getSkinTemplate();
		$idRegistry = IdRegistry::getRegistry();

		$firstHeading =
			$this->indent( 1 ) . '<!-- title of the page -->' .
			$this->indent() . $idRegistry->element( 'h1', [ 'id' => 'firstHeading' ],
				$skintemplate->get( 'title' ) );

		// @codingStandardsIgnoreStart
		$siteSub =
			$this->indent() . '<!-- tagline; usually goes something like "From WikiName" primary purpose of this seems to be for printing to identify the source of the content -->' .
			$this->indent() . $idRegistry->element( 'div', [ 'id' => 'siteSub' ], $skintemplate->getMsg( 'tagline' )->escaped() );
		// @codingStandardsIgnoreEnd

		$contentSub = '';

		if ( $skintemplate->get( 'subtitle' ) ) {

			// TODO: should not use class 'small', better use class 'contentSub' and do styling in a
			// scss file
			$contentSub =
				$this->indent() .
				'<!-- subtitle line; used for various things like the subpage hierarchy -->' .
				$this->indent() . $idRegistry->element( 'div', [ 'id' => 'contentSub', 'class' => 'small' ],
				$skintemplate->get( 'subtitle' ) );

		}

		$contentSub2 = '';

		if ( $skintemplate->get( 'undelete' ) ) {
			// TODO: should not use class 'small', better use class 'contentSub2' and do styling in a
			// scss file
			$contentSub2 =
				$this->indent() . '<!-- undelete message -->' .
				$this->indent() . $idRegistry->element( 'div',
				[ 'id' => 'contentSub2', 'class' => 'small' ], $skintemplate->get( 'undelete' ) );
		}

		// TODO: This should be put in a separate component (and appear at the very beginning of the
		// page right after the <body>
		$jumpToNav = $idRegistry->element(
			'div',
			[ 'id' => 'jump-to-nav', 'class' => 'mw-jump' ],
			$skintemplate->getMsg( 'jumpto' )->escaped() . $idRegistry->element( 'a',
			[ 'href' => '#mw-navigation' ], $skintemplate->getMsg( 'jumptonavigation' )->escaped() ) .
			$skintemplate->getMsg( 'comma-separator' )->escaped() . $idRegistry->element( 'a',
			[ 'href' => '#p-search' ], $skintemplate->getMsg( 'jumptosearch' )->escaped() )
		);

		return $this->indent()
			. $idRegistry->element(
				'div',
				[ 'class' => "contentHeader" ],
				$firstHeading .
				$siteSub .
				$contentSub .
				$contentSub2 .
				$jumpToNav .
				$this->indent( -1 )
			);
	}

}
