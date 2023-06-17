<?php
/**
 * File containing the Sticky TOC class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2023
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

namespace Skins\Chameleon\Components\Modifications;

/**
 * Class Sticky TOC
 *
 * @since 1.0
 * @ingroup Skins
 */
class Stickytoc extends Modification {

	/**
	 * @throws \MWException
	 */
	protected function applyModification() {
		$this->getComponent()->addClasses( 'stickytoc' );
	}

	/**
	 * @return string[] the resource loader modules needed by this component
	 */
	public function getResourceLoaderModules() {
		$modules = parent::getResourceLoaderModules();
		$modules[] = 'skin.chameleon.stickytoc';
		return $modules;
	}

}
