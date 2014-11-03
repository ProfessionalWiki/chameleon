<?php
/**
 * File containing the PermissionsHelper class
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

namespace Skins\Chameleon;
use DOMElement;
use Skin;

/**
 * PermissionsHelper class
 *
 * @author Stephan Gambke
 * @since 1.1
 * @ingroup Skins
 */
class PermissionsHelper {

	private $domElement;
	private $skin;
	private $default;

	/**
	 * @param Skin $skin
	 * @param DOMElement $domElement
	 * @param bool $default
	 */
	public function __construct ( Skin $skin, DOMElement $domElement = null, $default = false ){
		$this->skin = $skin;
		$this->domElement = $domElement;
		$this->default = $default;
	}

	/**
	 * @param string $attribute
	 * @return bool
	 */
	public function userHasGroup( $attribute ) {

		if ( !$this->hasAttribute( $attribute ) ) {
			return $this->default;
		}

		$expectedGroups = $this->getValueListFromAttribute( $attribute );
		$userGroups = $this->skin->getUser()->getEffectiveGroups();
		$effectiveUserGroups = array_intersect( $expectedGroups, $userGroups );

		return !empty( $effectiveUserGroups );
	}

	/**
	 * @param string $attribute
	 * @return bool
	 */
	public function userHasPermission( $attribute ) {

		if ( !$this->hasAttribute( $attribute ) ) {
			return $this->default;
		}

		$expectedRights = $this->getValueListFromAttribute( $attribute );
		$userRights = $this->skin->getUser()->getRights();
		$effectiveUserRights = array_intersect( $expectedRights, $userRights );

		return !empty( $effectiveUserRights );
	}

	/**
	 * @param string $attribute
	 * @return bool
	 */
	public function pageIsInNamespace( $attribute ) {

		if ( !$this->hasAttribute( $attribute ) ) {
			return $this->default;
		}

		$expectedNamespaces = array_map( array($this, 'getNamespaceNumberFromDefinedConstantName' ), $this->getValueListFromAttribute( $attribute ) );
		$pageNamespace = $this->skin->getTitle()->getNamespace();

		return in_array( $pageNamespace, $expectedNamespaces );
	}

	/**
	 * @param string $attributeName
	 * @return bool
	 */
	public function hasAttribute( $attributeName ) {
		return $this->domElement !== null && $this->domElement->hasAttribute( $attributeName );
	}

	/**
	 * @param string $attributeName
	 * @return string[]
	 */
	private function getValueListFromAttribute( $attributeName ) {
		return $this->domElement === null ? array () : array_map( 'trim', explode( ',', $this->domElement->getAttribute( $attributeName ) ) );

	}

	/**
	 * @param $value
	 * @return int
	 */
	private function getNamespaceNumberFromDefinedConstantName( $value ) {
		$constants = get_defined_constants();
		if ( !is_null( $value ) && array_key_exists( $value, $constants ) ) {
			$value = $constants[ $value ];
		}

		return is_int( $value ) ? $value : -1;
	}
}
