<?php
/**
 * File holding the MainContent class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2018, Stephan Gambke
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
 * The MainContent class.
 *
 * FIXME: Extract into separate modules/allow as plugins: TOC, NewtalkNotifier
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
		$indicators = new Indicators($this->getSkinTemplate(), $this->getDomElement(),
				$this->getIndent());
		$contentHeader = new ContentHeader($this->getSkinTemplate(), $this->getDomElement(),
			$this->getIndent());
		$contentBody = new ContentBody($this->getSkinTemplate(), $this->getDomElement(),
			$this->getIndent());
		$categoryLinks = new CategoryLinks($this->getSkinTemplate(), $this->getDomElement(),
			$this->getIndent());

		$hideCategoryLinks = $this->getDomElement() !== null && filter_var( $this->getDomElement()
			->getAttribute( 'hideCatLinks' ),
				FILTER_VALIDATE_BOOLEAN );

		$mwBody =
			$topAnchor .
			$this->indent( 1 ) .
			$indicators->getHtml() .
			$contentHeader->getHtml() .
			$contentBody->getHtml() .
			($hideCategoryLinks ? '' : $categoryLinks->getHtml()) .
			$this->indent( -1 );

		return $this->indent() . '<!-- start the content area -->' .
			$this->indent() . $idRegistry->element(
				'div',
				[ 'id' => 'content', 'class' => 'mw-body ' . $this->getClassString() ],
				$mwBody
			);
	}

}
