<?php
/**
 * File containing the ShowOnlyFor class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2014, Stephan Gambke
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
 * @ingroup Skins
 */

namespace Skins\Chameleon\Components\Modifications;
use Skins\Chameleon\Components\Silent;
use Skins\Chameleon\PermissionsHelper;

/**
 * ShowOnlyFor class
 *
 * @author Stephan Gambke
 * @since 1.1
 * @ingroup Skins
 */
class ShowOnlyFor extends Modification {

	private $permissionsHelper;

	/**
	 * This method checks if the restriction is applicable and if necessary
	 * replaces the decorated component by a Silent component
	 */
	protected function applyModification() {
		if ( ! $this->isShown() ) {
			$c = $this->getComponent();
			$this->setComponent( new Silent( $c->getSkinTemplate(), $c->getDomElement(), $c->getIndent() ) );
		}
	}

	/**
	 * @return bool
	 */
	private function isShown() {
		$p = $this->getPermissionsHelper();
		return $p->userHasGroup( 'group' ) || $p->userHasPermission( 'permission' ) || $p->pageIsInNamespace( 'namespace' );
	}

	/**
	 * @return PermissionsHelper
	 */
	private function getPermissionsHelper() {
		if ( $this->permissionsHelper === null ) {
			$this->permissionsHelper = new PermissionsHelper( $this->getSkinTemplate()->getSkin(), $this->getDomElementOfModification(), false );
		}

		return $this->permissionsHelper;
	}
}