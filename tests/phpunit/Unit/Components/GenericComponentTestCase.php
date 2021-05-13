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

namespace Skins\Chameleon\Tests\Unit\Components;

use DOMDocument;
use DOMXPath;
use PHPUnit\Framework\TestCase;
use Skins\Chameleon\Components\Component;
use Skins\Chameleon\Tests\Util\DocumentElementFinder;
use Skins\Chameleon\Tests\Util\MockupFactory;
use Skins\Chameleon\Tests\Util\XmlFileProvider;

/**
 * @coversDefaultClass \Skins\Chameleon\Components\Component
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 * @ingroup Test
 */
class GenericComponentTestCase extends TestCase {

	private $successColor = '';
	private $testObject;
	protected $classUnderTest;
	protected $componentUnderTest;

	private static $lastValidatorCallTime = 0;

	/**
	 * @covers ::__construct
	 */
	public function testCanConstruct() {
		/** @var Component $instance */
		$instance = $this->getTestObject();

		$this->assertInstanceOf(
			$this->classUnderTest,
			$instance
		);

		$this->assertSame( 0, $instance->getIndent() );
		$this->assertNull( $instance->getDomElement() );
	}

	/**
	 * @covers ::getHtml
	 */
	public function testGetHtmlwithEmptyElement() {
		/** @var Component $instance */
		$instance = $this->getTestObject();
		$this->assertValidHTML( $instance->getHtml() );
	}

	/**
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromSyntheticLayoutFiles
	 *
	 * @param \DOMElement $domElement
	 */
	public function testGetHtmlOnSyntheticLayoutXml( \DOMElement $domElement ) {
		/** @var Component $instance */
		$instance = $this->getTestObject( $domElement );
		$this->assertValidHTML( $instance->getHtml() );
	}

	/**
	 * @param mixed $domElement
	 * @covers ::getHtml
	 * @dataProvider domElementProviderFromDeployedLayoutFiles
	 */
	public function testGetHtmlOnDeployedLayoutXml( $domElement ) {
		if ( $domElement === null ) {
			$this->assertTrue( true );
			return;
		}

		/** @var Component $instance */
		$instance = $this->getTestObject( $domElement );

		$this->assertValidHTML( $instance->getHtml() );
	}

	/**
	 * @param \DOMElement|null $domElement
	 *
	 * @return object
	 */
	public function getTestObject( \DOMElement $domElement = null ) {
		if ( $this->testObject === null ) {
			$chameleonTemplate = $this->getChameleonSkinTemplateStub();
			$this->testObject = new $this->classUnderTest( $chameleonTemplate, $domElement );
		}
		return $this->testObject;
	}

	public function domElementProviderFromSyntheticLayoutFiles() {
		$file = __DIR__ . '/../../Fixture/' . $this->getNameOfComponentUnderTest() . '.xml';
		return array_chunk( $this->getDomElementsFromFile( $file ), 1 );
	}

	public function domElementProviderFromDeployedLayoutFiles() {
		$xmlFileProvider = new XmlFileProvider( __DIR__ . '/../../../../layouts' );
		$files = $xmlFileProvider->getFiles();

		$elements = [];
		foreach ( $files as $file ) {
			$elements = array_merge( $elements, $this->getDomElementsFromFile( $file ) );
		}

		if ( count( $elements ) === 0 ) {
			$elements[ ] = null;
		}

		return array_chunk( $elements, 1 );
	}

	/**
	 * @param string $file
	 *
	 * @return mixed
	 */
	protected function getDomElementsFromFile( $file ) {
		$elementFinder = new DocumentElementFinder( $file );
		$nameParts = array_values( explode( '\\', $this->getNameOfComponentUnderTest() ) );
		$componentName = end( $nameParts );
		return $elementFinder->getComponentsByTypeAttribute( $componentName );
	}

	/**
	 * @param string $fragment
	 * @param bool $isHtml
	 *
	 * @return mixed
	 */
	protected static function loadXML( $fragment, $isHtml = true ) {
		if ( $isHtml ) {
			$fragment = self::wrapHtmlFragment( $fragment );
		}

		$doc = new DOMDocument();
		$doc->preserveWhiteSpace = false;

		if ( $isHtml === true ) {
			libxml_use_internal_errors( true );
			$result = $doc->loadHTML( $fragment );
			libxml_use_internal_errors( false );
		} else {
			$result = $doc->loadXML( $fragment );
		}

		if ( $result === true ) {
			return $doc;
		} else {
			return false;
		}
	}

	/**
	 * @param string $fragment
	 *
	 * @return string
	 */
	protected static function wrapHtmlFragment( $fragment ) {
		// @codingStandardsIgnoreStart
		return '<!DOCTYPE html><html><head><meta charset="utf-8" /><title>SomeTitle</title></head><body>' .
			$fragment . '</body></html>';
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Evaluate an HTML or XML string and assert its structure and/or contents.
	 *
	 * @todo Currently only supports 'tag' and 'class'
	 *
	 * The first argument ($matcher) is an associative array that specifies the
	 * match criteria for the assertion:
	 *
	 *  - `id`           : the node with the given id attribute must match the
	 *                     corresponding value.
	 *  - `tag`          : the node type must match the corresponding value.
	 *  - `attributes`   : a hash. The node's attributes must match the
	 *                     corresponding values in the hash.
	 *  - `class`        : The node's class attribute must contain the given
	 *                     value.
	 *  - `content`      : The text content must match the given value.
	 *  - `parent`       : a hash. The node's parent must match the
	 *                     corresponding hash.
	 *  - `child`        : a hash. At least one of the node's immediate children
	 *                     must meet the criteria described by the hash.
	 *  - `ancestor`     : a hash. At least one of the node's ancestors must
	 *                     meet the criteria described by the hash.
	 *  - `descendant`   : a hash. At least one of the node's descendants must
	 *                     meet the criteria described by the hash.
	 *  - `children`     : a hash, for counting children of a node.
	 *                     Accepts the keys:
	 *    - `count`        : a number which must equal the number of children
	 *                       that match
	 *    - `less_than`    : the number of matching children must be greater
	 *                       than this number
	 *    - `greater_than` : the number of matching children must be less than
	 *                       this number
	 *    - `only`         : another hash consisting of the keys to use to match
	 *                       on the children, and only matching children will be
	 *                       counted
	 *
	 * @param array $matcher
	 * @param string $actual
	 * @param bool $isHtml
	 *
	 * @return int
	 */
	protected static function countTags( $matcher, $actual, $isHtml ) {
		$doc = self::loadXML( $actual, $isHtml );

		if ( $doc === false ) {
			return false;
		}

		$query = '//';

		if ( array_key_exists( 'tag', $matcher ) ) {
			$query .= strtolower( $matcher[ 'tag' ] );
			unset( $matcher[ 'tag' ] );
		} else {
			$query .= '*';
		}

		if ( array_key_exists( 'class', $matcher ) ) {
			$query .= '[contains(concat(" ", normalize-space(@class), " "), " ' . $matcher[ 'class' ] .
				' ")]';
			unset( $matcher[ 'class' ] );
		}

		if ( array_key_exists( 'id', $matcher ) ) {
			$query .= '[contains(concat(" ", normalize-space(@id), " "), " ' . $matcher[ 'id' ] . ' ")]';
			unset( $matcher[ 'id' ] );
		}

		if ( count( $matcher ) > 0 ) {
			trigger_error( 'Found unsupported matcher tags: ' . implode( ', ', array_keys( $matcher ) ),
				E_USER_WARNING );
		}

		$xpath = new DOMXPath( $doc );
		$entries = $xpath->query( $query );

		return $entries->length;
	}

	/**
	 * @param array $matcher
	 * @param string $actual
	 * @param string $message
	 * @param bool $isHtml
	 */
	public static function assertTag( $matcher, $actual,
		$message = 'Failed asserting that the given fragment contained the described node.',
		$isHtml = true ) {
		$entryCount = self::countTags( $matcher, $actual, $isHtml );

		self::assertTrue( $entryCount !== false && $entryCount > 0, $message );
	}

	/**
	 * @param array $matcher
	 * @param string $actual
	 * @param string $message
	 * @param bool $isHtml
	 */
	public static function assertNotTag( $matcher, $actual,
		$message = 'Failed asserting that the given fragment did not contain the described node.',
		$isHtml = true ) {
		$entryCount = self::countTags( $matcher, $actual, $isHtml );

		self::assertTrue( $entryCount === 0, $message );
	}

	/**
	 * Asserts that $actual is a valid HTML fragment
	 *
	 * @todo Put this whole stuff in a PHPUnit_Framework_Constraint and just call assertThat
	 *
	 * @param mixed $actual
	 * @param string $message
	 */
	public function assertValidHTML( $actual, $message = 'HTML text is not valid. ' ) {
		if ( !defined( 'USE_EXTERNAL_HTML_VALIDATOR' ) || !USE_EXTERNAL_HTML_VALIDATOR ) {

			$doc = $this->loadXML( $actual, true );
			$this->assertNotFalse( $doc, $message );

			return;
		}

		$actual = $this->wrapHtmlFragment( $actual );

		$curlVersion = curl_version();

		// cURL
		$curl = curl_init();

		curl_setopt_array( $curl, [
			CURLOPT_CONNECTTIMEOUT => 1,
			CURLOPT_URL            => 'http://validator.w3.org/check',
			CURLOPT_USERAGENT      => 'cURL ' . $curlVersion[ 'version' ],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => [
				'output'   => 'json',
				'fragment' => $actual,
			],
		] );

		// @codingStandardsIgnoreStart
		@time_sleep_until( self::$lastValidatorCallTime + 1 );
		// @codingStandardsIgnoreEnd
		self::$lastValidatorCallTime = time();

		$response = curl_exec( $curl );
		$curlInfo = curl_getinfo( $curl );

		curl_close( $curl );

		if ( $response === false ) {
			$this->markTestIncomplete( 'Could not connect to validation service.' );
		}

		if ( $curlInfo[ 'http_code' ] != '200' ) {
			$this->markTestIncomplete( 'Error connecting to validation service. HTTP ' .
				$curlInfo[ 'http_code' ] );
		}

		$response = json_decode( $response, true );

		if ( $response === null ) {
			$this->markTestIncomplete(
				'Validation service returned an invalid response (invalid JSON): ' . $response );
		}

		// fail if errors or warnings
		if ( array_key_exists( 'messages', $response ) ) {

			foreach ( $response[ 'messages' ] as $responseMessage ) {

				if ( $responseMessage[ 'type' ] === 'error' || $responseMessage[ 'type' ] === 'warning' ) {
					$this->fail( $message . ucfirst( $response[ 'messages' ][ 0 ][ 'type' ] ) . ': ' .
						$response[ 'messages' ][ 0 ][ 'message' ] );
				}

			}
		}

		// valid
		$this->successColor = 'bg-green,fg-black';
		$this->assertTrue( true );
	}

	/**
	 * @return \Skins\Chameleon\ChameleonTemplate
	 * @throws \MWException
	 */
	public function getChameleonSkinTemplateStub() {
		return MockupFactory::makeFactory( $this )->getChameleonSkinTemplateStub();
	}

	/**
	 * @return string
	 */
	public function getSuccessColor() {
		return $this->successColor;
	}

	/**
	 * @return string
	 */
	public function getNameOfComponentUnderTest() {
		return str_replace( 'Skins\\Chameleon\\Components\\', '', get_class( $this->getTestObject() ) );
	}

}
