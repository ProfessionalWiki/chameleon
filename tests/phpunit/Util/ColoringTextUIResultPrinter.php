<?php
/**
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
 * @ingroup Skins
 */

namespace Skins\Chameleon\Tests\Util;

// @codingStandardsIgnoreStart
/**
 * @group skins-chameleon
 * @group mediawiki-databaseless
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 * @ingroup Test
 */
// @codingStandardsIgnoreEnd
class ColoringTextUIResultPrinter extends \PHPUnit_TextUI_ResultPrinter {

	/**
	 * @var array
	 */
	protected static $ansiCodes = [
		'bold'       => 1,
		'fg-black'   => 30,
		'fg-red'     => 31,
		'fg-green'   => 32,
		'fg-yellow'  => 33,
		'fg-cyan'    => 36,
		'fg-white'   => 37,
		'bg-red'     => 41,
		'bg-green'   => 42,
		'bg-yellow'  => 43
	];

	/**
	 * @param \PHPUnit_Framework_Test $test
	 * @param mixed $time
	 */
	public function endTest( \PHPUnit_Framework_Test $test, $time ) {
		if ( !$this->lastTestFailed ) {

			$color = '';
			if ( method_exists( $test, 'getSuccessColor' ) ) {
				$color = $test->getSuccessColor();
			}
			$this->writeProgressWithColor( $color, '.' );

		}

		if ( $test instanceof \PHPUnit\Framework\TestCase ) {
			$this->numAssertions += $test->getNumAssertions();
		} elseif ( $test instanceof \PHPUnit_Extensions_PhptTestCase ) {
			$this->numAssertions++;
		}

		$this->lastTestFailed = false;

		if ( $test instanceof \PHPUnit\Framework\TestCase ) {
			if ( !$test->hasPerformedExpectationsOnOutput() ) {
				$this->write( $test->getActualOutput() );
			}
		}
	}

	/**
	 * @param string $color
	 * @param string $buffer
	 *
	 * @return string
	 */
	protected function formatWithColor( $color, $buffer ) {
		if ( !$this->colors ) {
			return $buffer;
		}

		$codes = array_filter( array_map( 'trim', explode( ',', $color ) ) );
		$lines = explode( "\n", $buffer );
		$padding = max( array_map( 'strlen', $lines ) );

		$styles = [];
		foreach ( $codes as $code ) {
			$styles[] = self::$ansiCodes[$code];
		}
		$style = sprintf( "\x1b[%sm", implode( ';', $styles ) );

		$styledLines = [];
		foreach ( $lines as $line ) {
			$styledLines[] = $style . str_pad( $line, $padding ) . "\x1b[0m";
		}

		return implode( "\n", $styledLines );
	}

}
