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
 * @ingroup   Skins
 */

namespace Skins\Chameleon;

use DOMElement;

/**
 * PermissionsHelper class
 *
 * @author  Stephan Gambke
 * @since   1.1
 * @ingroup Skins
 */
class PermissionsHelper {

	private $domElement;
	private $skin;
	private $default;

	/**
	 * @param \SkinChameleon $skin
	 * @param DOMElement     $domElement
	 * @param bool           $default
	 */
	public function __construct( \SkinChameleon $skin, DOMElement $domElement = null, $default = false ) {
		$this->skin = $skin;
		$this->domElement = $domElement;
		$this->default = $default;
	}

	/**
	 * @since 1.1
	 *
	 * @param string $attributeNameInDomElement
	 *
	 * @return bool
	 */
	public function userHasGroup( $attributeNameInDomElement ) {

		return $this->userHas( 'group', $attributeNameInDomElement );
	}

	/**
	 * @param string $attributeOfUser
	 * @param string $attributeNameInDomElement
	 *
	 * @throws \MWException
	 * @return bool
	 */
	protected function userHas( $attributeOfUser, $attributeNameInDomElement ) {

		$user = $this->skin->getUser();
		$attributeAccessors = array(
			'group'      => array( $user, 'getEffectiveGroups' ),
			'permission' => array( $user, 'getRights' ),
		);

		if ( !array_key_exists( $attributeOfUser, $attributeAccessors ) ) {
			throw new \MWException( sprintf( 'Unknown permission: %s', $attributeOfUser ) );
		}

		if ( !$this->hasAttribute( $attributeNameInDomElement ) ) {
			return $this->default;
		}

		$expectedValues = $this->getValueListFromAttribute( $attributeNameInDomElement );
		$observedValues = call_user_func( $attributeAccessors[ $attributeOfUser ] );
		$effectiveValues = array_intersect( $expectedValues, $observedValues );

		return !empty( $effectiveValues );
	}

	/**
	 * @since 1.1
	 *
	 * @param string $attributeNameInDomElement
	 *
	 * @return bool
	 */
	public function hasAttribute( $attributeNameInDomElement ) {
		return $this->domElement !== null && $this->domElement->hasAttribute( $attributeNameInDomElement );
	}

	/**
	 * @param string $attributeName
	 *
	 * @return string[]
	 */
	protected function getValueListFromAttribute( $attributeName ) {
		return $this->domElement === null ? array() : array_map( 'trim', explode( ',', $this->domElement->getAttribute( $attributeName ) ) );

	}

	/**
	 * @since 1.1
	 *
	 * @param string $attributeNameInDomElement
	 *
	 * @return bool
	 */
	public function userHasPermission( $attributeNameInDomElement ) {

		return $this->userHas( 'permission', $attributeNameInDomElement );
	}

	/**
	 * @since 1.1
	 *
	 * @param string $attributeNameInDomElement
	 *
	 * @return bool
	 */
	public function pageIsInNamespace( $attributeNameInDomElement ) {

		if ( !$this->hasAttribute( $attributeNameInDomElement ) ) {
			return $this->default;
		}

		$expectedNamespaces = array_map( array( $this, 'getNamespaceNumberFromDefinedConstantName' ), $this->getValueListFromAttribute( $attributeNameInDomElement ) );
		$pageNamespace = $this->skin->getTitle()->getNamespace();

		return in_array( $pageNamespace, $expectedNamespaces );
	}

	/**
	 * @param null|string $value
	 *
	 * @return int
	 */
	protected function getNamespaceNumberFromDefinedConstantName( $value ) {
		$constants = get_defined_constants();
		if ( !is_null( $value ) && array_key_exists( $value, $constants ) ) {
			$value = $constants[ $value ];
		}

		return is_int( $value ) ? $value : -1;
	}
}
