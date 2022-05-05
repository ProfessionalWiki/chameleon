<?php
/**
 * File holding the AggregateComponentTrait trait
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

/**
 * Provides the getSubComponentHtml method to ease embedding other components
 *
 * @author gesinn-it-wam
 * @since 4.2
 * @ingroup Skins
 */
trait AggregateComponentTrait {

	abstract function getSkinTemplate();

	abstract function getDomElement();

	abstract function getIndent();

	/**
	 * @param string $component
	 * @param string|null $hideSuffix
	 * @return string
	 */
	protected function getSubComponentHtml( string $component, ?string $hideSuffix = null): string {
		if ( $hideSuffix != null && $this->shouldHide( $hideSuffix ) ) {
			return '';
		}

		$component =
			new $component( $this->getSkinTemplate(), $this->getDomElement(), $this->getIndent() );
		return $component->getHtml();
	}

	private function shouldHide( $hideSuffix ): bool {
		return $this->getDomElement() !== null &&
			filter_var( $this->getDomElement()->getAttribute( 'hide' . $hideSuffix ),
				FILTER_VALIDATE_BOOLEAN );
	}

}
