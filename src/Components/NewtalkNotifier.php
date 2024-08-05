<?php
/**
 * File holding the NewtalkNotifier class
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

/**
 * The NewtalkNotifier class.
 *
 * A message to a user about new messages on their talkpage
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class NewtalkNotifier extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @param ChameleonTemplate $tpl
	 * @return String the HTML code
	 * @throws \MWException
	 */
	public function getHtml($tpl = null) {
      if ( !is_null( $tpl ) ) {
          $this->setSkinTemplate( $tpl );
      }
		$data = $this->getSkinTemplate()->data;

		if ( array_key_exists( 'newtalk', $data ) && $data[ 'newtalk' ] ) {
			return $this->indent() .
				'<!-- new talk notifier message to a user about new messages on their talkpage -->' .
			  $this->indent() . \Html::rawElement( 'div', [ 'class' => 'usermessage ' .
				$this->getClassString() ], $data[ 'newtalk' ] );
		} else {
			return '';
		}
	}

}
