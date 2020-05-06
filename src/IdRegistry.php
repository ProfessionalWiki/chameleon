<?php
/**
 * File holding the IdRegistry class
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
 * @ingroup Skins
 */

namespace Skins\Chameleon;

/**
 * Class IdRegistry provides a registry and access methods to ensure each id is only used once per
 * HTML page.
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class IdRegistry {

	private static $sInstance;
	private $mRegistry = [];

	/**
	 * @return IdRegistry
	 */
	public static function getRegistry() {
		if ( self::$sInstance === null ) {
			self::$sInstance = new IdRegistry();
		}

		return self::$sInstance;
	}

	/**
	 * @param null|string $id
	 * @param null|mixed $component
	 *
	 * @return string
	 */
	public function getId( $id = null, $component = null ) {
		if ( empty( $id ) ) {

			// no specific id requested, just return a unique string
			return base_convert( uniqid(), 16, 36 );

		} elseif ( array_key_exists( $id, $this->mRegistry ) ) {

			// specific id requested, but already in use
			// return a string derived from the id and a unique string
			$key = "$id-" . base_convert( uniqid(), 16, 36 );
			$this->mRegistry[ $id ][ $key ] = $component;
			return $key;

		} else {

			// specific id requested that is not yet in use
			// return the id
			$this->mRegistry[ $id ][ $id ] = $component;
			return $id;

		}
	}

	/**
	 * Returns the opening tag of an HTML element in a string.
	 *
	 * The advantage over Html::openElement is that any id attribute is ensured to be unique.
	 *
	 * @param string $tag
	 * @param array $attributes
	 *
	 * @return string
	 */
	public function openElement( $tag, $attributes = [] ) {
		$attributes = $this->getAttributesWithUniqueId( $attributes );

		return \Html::openElement( $tag, $attributes );
	}

	/**
	 * Returns an HTML element in a string. The contents are NOT escaped.
	 *
	 * The advantage over Html::rawElement is that any id attribute is ensured to be unique.
	 *
	 * @param string $tag
	 * @param array $attributes
	 * @param string $contents
	 * @param string $indent
	 *
	 * @return string
	 */
	public function element( $tag, $attributes = [], $contents = '', $indent = '' ) {
		$attributes = $this->getAttributesWithUniqueId( $attributes );

		return $indent . \Html::rawElement( $tag, $attributes, $contents . $indent );
	}

	/**
	 * @param array $attributes
	 *
	 * @return array
	 */
	protected function getAttributesWithUniqueId( $attributes ) {
		if ( is_array( $attributes ) && isset( $attributes[ 'id' ] ) ) {
			$attributes[ 'class' ] = ( isset( $attributes[ 'class' ] ) ?
				( $attributes[ 'class' ] . ' ' ) : '' ) . $attributes[ 'id' ];
			$attributes[ 'id' ] = $this->getId( $attributes[ 'id' ] );
		}
		return $attributes;
	}
}
