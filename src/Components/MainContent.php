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

	use AggregateComponentTrait;

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {
		$idRegistry = IdRegistry::getRegistry();

		$topAnchor = $idRegistry->element( 'a', [ 'id' => 'top' ] );

		$mwBody =
			$topAnchor . $this->indent( 1 ) .
			$this->getSubComponentHtml( Indicators::class, 'Indicators' ) .
			$this->getSubComponentHtml( ContentHeader::class, 'ContentHeader' ) .
			$this->getSubComponentHtml( ContentBody::class, 'ContentBody' ) .
			$this->getSubComponentHtml( CategoryLinks::class, 'CatLinks' ) .
			$this->indent( - 1 );

		return $this->indent() . '<!-- start the content area -->' .
			$this->indent() . $idRegistry->element(
				'div',
				[ 'id' => 'content', 'class' => 'mw-body ' . $this->getClassString() ],
				$mwBody
			);
	}
}
