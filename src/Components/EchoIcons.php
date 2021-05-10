<?php
/**
 * File holding the EchoIcons component class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2021, Morne Alberts
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
 * @ingroup Skins
 */

namespace Skins\Chameleon\Components;

use Skins\Chameleon\IdRegistry;

/**
 * Class Menu
 *
 * @author Morne Alberts
 * @since 3.2
 * @ingroup Skins
 */
class EchoIcons extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return string the HTML code
	 * @throws \MWException
	 */
	public function getHtml() {
		$icons = $this->getEchoIcons();
		if ( empty( $icons ) ) {
			return '';
		}

		$idRegistry = IdRegistry::getRegistry();

		return $this->indent() . '<!-- echo icons -->' .
			$idRegistry->element( 'ul', [ 'id' => 'echo-icons',
			'class' => 'echo-icons ' . $this->getClassString(), ], $icons );
	}

	/**
	 * @return string
	 * @throws \MWException
	 */
	protected function getEchoIcons() {
		$this->indent( 1 );
		$ret = '';

		foreach ( $this->getSkinTemplate()->getPersonalTools() as $key => $item ) {
			if ( $key == 'notifications-alert' || $key == 'notifications-notice' ) {
				$ret .= $this->indent() .
					$this->getSkinTemplate()->makeListItem( $key, $item, [ 'tag' => 'li' ] );
			}
		}

		$this->indent( -1 );
		return $ret;
	}
}
