<?php
/**
 * File containing the PermissionsHelper class
 *
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2019, Stephan Gambke
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

namespace Skins\Chameleon;

use DOMElement;
use MediaWiki\MediaWikiServices;

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
	 * @param Chameleon $skin
	 * @param DOMElement|null $domElement
	 * @param bool $default
	 */
	public function __construct( Chameleon $skin, DOMElement $domElement = null, $default = false ) {
		$this->skin = $skin;
		$this->domElement = $domElement;
		$this->default = $default;
	}

	/**
	 * @param string $attributeNameInDomElement
	 *
	 * @return bool
	 * @throws \MWException
	 * @since 1.1
	 *
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
		$attributeAccessors = [ 'group', 'permission' ];

		if ( !in_array( $attributeOfUser, $attributeAccessors ) ) {
			throw new \MWException( sprintf( 'Unknown permission: %s', $attributeOfUser ) );
		}

		if ( !$this->hasAttribute( $attributeNameInDomElement ) ) {
			return $this->default;
		}

		$expectedValues = $this->getValueListFromAttribute( $attributeNameInDomElement );
		switch ( $attributeOfUser ) {
			case 'group':
				$observedValues = MediaWikiServices::getInstance()
					->getUserGroupManager()
					->getUserEffectiveGroups( $user );
				break;
			case 'permission';
				$observedValues = MediaWikiServices::getInstance()
					->getPermissionManager()
					->getUserPermissions( $user );
				break;
		}
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
		return $this->domElement !== null &&
			$this->domElement->hasAttribute( $attributeNameInDomElement );
	}

	/**
	 * @param string $attributeName
	 *
	 * @return string[]
	 */
	protected function getValueListFromAttribute( $attributeName ) {
		return $this->domElement === null ? [] :
			array_map( 'trim', explode( ',', $this->domElement->getAttribute( $attributeName ) ) );
	}

	/**
	 * @param string $attributeNameInDomElement
	 *
	 * @return bool
	 * @throws \MWException
	 * @since 1.1
	 *
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

		$expectedNamespaces = array_map( [ $this, 'getNamespaceNumberFromDefinedConstantName' ],
			$this->getValueListFromAttribute( $attributeNameInDomElement ) );
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
		if ( $value !== null && array_key_exists( $value, $constants ) ) {
			$value = $constants[ $value ];
		}

		return is_int( $value ) ? $value : -1;
	}
}
