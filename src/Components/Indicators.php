<?php
/**
 * File holding the Indicators class
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
 * The Indicators component
 *
 * @author gesinn-it-wam
 * @since 4.2
 * @ingroup Skins
 */
class Indicators extends Component {

	/**
	 * @inheritDoc
	 * @throws \MWException
	 */
	public function getHtml(): string {
		$idRegistry = IdRegistry::getRegistry();

		return $idRegistry->element( 'div', [ 'id' => 'mw-indicators',
			'class' => 'mw-indicators', ], $this->buildMwIndicators() );
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	private function buildMwIndicators(): string {
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
					[
						'id' => \Sanitizer::escapeIdForAttribute( "mw-indicator-$id" ),
						'class' => 'mw-indicator'
					],
					$content
				);
		}

		$ret .= $this->indent( -1 );

		return $ret;
	}

}
