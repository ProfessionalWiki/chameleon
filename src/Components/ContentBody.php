<?php
/**
 * File holding the ContentBody class
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
 * The ContentBody component
 *
 * @author gesinn-it-wam
 * @since 4.2
 * @ingroup Skins
 */
class ContentBody extends Component {

	/**
	 * @inheritDoc
	 * @throws \MWException
	 */
	public function getHtml(): string {
		return $this->buildContentBody();
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function buildContentBody(): string {
		return $this->indent() . IdRegistry::getRegistry()->element(
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
	protected function buildDataAfterContent(): string {
		$dataAfterContent = $this->getSkinTemplate()->get( 'dataAfterContent' );

		if ( $dataAfterContent !== null ) {
			// @codingStandardsIgnoreStart
			return $this->indent() . '<!-- data blocks which should go somewhere after the body text, but not before the catlinks block-->' .
				$this->indent() . $dataAfterContent;
			// @codingStandardsIgnoreEnd
		}

		return '';
	}

}
