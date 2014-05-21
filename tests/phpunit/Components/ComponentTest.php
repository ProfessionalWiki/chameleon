<?php

namespace Skins\Chameleon\Tests\Components;

/**
 * @ingroup Test
 *
 * @license GNU GPL v3+
 * @since   1.0
 *
 * @author  Stephan Gambke
 *
 * @coversDefaultClass \Skins\Chameleon\Components\Component
 * @covers ::<private>
 * @covers ::<protected>
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 */
class ComponentTest extends \PHPUnit_Framework_TestCase {

	protected $classUnderTest = '\Skins\Chameleon\Components\Component';


	/**
	 * @covers ::__construct
	 */
	public function testCanConstruct() {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$instance = $this->getMockForAbstractClass( $this->classUnderTest, array( $chameleonTemplate ) );
		$instance->expects( $this->any() )
			->method( 'getHtml' )
			->will( $this->returnValue( 'SomeHtml' ) );

		$this->assertInstanceOf(
			$this->classUnderTest,
			$instance
		);

		$this->assertEquals( 0, $instance->getIndent() );
		$this->assertNull( $instance->getDomElement() );
	}

	/**
	 * @covers ::__construct
	 */
	public function testCanConstruct_withClassAttribute() {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$domElement = $this->getMockBuilder( '\DOMElement' )
			->disableOriginalConstructor()
			->getMock();

		$domElement->expects( $this->atLeastOnce() )
			->method( 'getAttribute' )
			->will( $this->returnValueMap( array( array( 'class', 'someClass' ) ) ) );

		$instance = $this->getMockForAbstractClass( $this->classUnderTest, array( $chameleonTemplate, $domElement ) );
		$instance->expects( $this->any() )
			->method( 'getHtml' )
			->will( $this->returnValue( 'SomeHtml' ) );

		$this->assertInstanceOf(
			$this->classUnderTest,
			$instance
		);
	}

	/**
	 * @covers ::getHtml
	 */
	public function testGetHtml() {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$instance = $this->getMockForAbstractClass( $this->classUnderTest, array( $chameleonTemplate ) );
		$instance->expects( $this->any() )
			->method( 'getHtml' )
			->will( $this->returnValue( 'SomeHtml' ) );


		$this->assertValidHTML( $instance->getHtml() );
	}

	/**
	 * @covers ::getSkinTemplate
	 */
	public function testGetSkinTemplate() {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$instance = $this->getMockForAbstractClass( $this->classUnderTest, array( $chameleonTemplate ) );
		$instance->expects( $this->any() )
			->method( 'getHtml' )
			->will( $this->returnValue( 'SomeHtml' ) );

		$this->assertEquals(
			$chameleonTemplate,
			$instance->getSkinTemplate()
		);
	}

	/**
	 * @covers ::getIndent
	 */
	public function testGetIndent() {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$instance = $this->getMockForAbstractClass( $this->classUnderTest, array( $chameleonTemplate, null, 42 ) );
		$instance->expects( $this->any() )
			->method( 'getHtml' )
			->will( $this->returnValue( 'SomeHtml' ) );

		$this->assertEquals(
			42,
			$instance->getIndent()
		);
	}

	/**
	 * @covers ::indent
	 */
	public function testIndent() {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$instance = $this->getMockForAbstractClass( $this->classUnderTest, array( $chameleonTemplate, null, 42 ) );
		$instance->expects( $this->any() )
			->method( 'getHtml' )
			->will( $this->returnValue( 'SomeHtml' ) );

		$reflection = new \ReflectionClass( get_class( $instance ) );
		$method = $reflection->getMethod( 'indent' );
		$method->setAccessible( true );

		$this->assertEquals(
			"\n" . str_repeat( "\t", 43 ),
			$method->invokeArgs( $instance, array( 1 ) )
		);
	}

	/**
	 * @covers ::getDomElement
	 */
	public function testGetDomElement() {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$domElement = $this->getMockBuilder( '\DOMElement' )
			->disableOriginalConstructor()
			->getMock();

		$instance = $this->getMockForAbstractClass( $this->classUnderTest, array( $chameleonTemplate, $domElement ) );
		$instance->expects( $this->any() )
			->method( 'getHtml' )
			->will( $this->returnValue( 'SomeHtml' ) );

		$this->assertEquals(
			$domElement,
			$instance->getDomElement()
		);
	}

	/**
	 * @covers ::getClassString
	 */
	public function testGetClassString_WithoutSetting() {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$instance = $this->getMockForAbstractClass( $this->classUnderTest, array( $chameleonTemplate ) );
		$instance->expects( $this->any() )
			->method( 'getHtml' )
			->will( $this->returnValue( 'SomeHtml' ) );

		$this->assertInternalType( 'string', $instance->getClassString() );

	}

	/**
	 * @covers ::setClasses
	 * @covers ::getClassString
	 * @dataProvider setClassesProvider
	 */
	public function testSetClasses( $input, $expected ) {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$instance = $this->getMockForAbstractClass( $this->classUnderTest, array( $chameleonTemplate ) );
		$instance->expects( $this->any() )
			->method( 'getHtml' )
			->will( $this->returnValue( 'SomeHtml' ) );

		$instance->setClasses( $input );

		$this->assertEquals( $expected, $instance->getClassString() );
	}

	/**
	 * @covers ::setClasses
	 * @expectedException \MWException
	 */
	public function testSetClasses_WithInvalidParameter() {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$instance = $this->getMockForAbstractClass( $this->classUnderTest, array( $chameleonTemplate ) );
		$instance->expects( $this->any() )
			->method( 'getHtml' )
			->will( $this->returnValue( 'SomeHtml' ) );

		$instance->setClasses( true ); // use bool instead of string

	}

	/**
	 * @covers ::addClasses
	 * @covers ::getClassString
	 * @covers ::transformClassesToArray
	 * @dataProvider addClassesProvider
	 */
	public function testAddClasses( $input1, $input2, $combined ) {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$instance = $this->getMockForAbstractClass( $this->classUnderTest, array( $chameleonTemplate ) );
		$instance->expects( $this->any() )
			->method( 'getHtml' )
			->will( $this->returnValue( 'SomeHtml' ) );

		$instance->setClasses( $input1 );
		$instance->addClasses( $input2 );

		$this->assertEquals( $combined, $instance->getClassString() );
	}

	/**
	 * @covers ::removeClasses
	 * @covers ::getClassString
	 * @dataProvider removeClassesProvider
	 */
	public function testRemoveClasses( $combined, $toRemove, $remainder ) {

		$chameleonTemplate = $this->getChameleonSkinTemplateStub();

		$instance = $this->getMockForAbstractClass( $this->classUnderTest, array( $chameleonTemplate ) );
		$instance->expects( $this->any() )
			->method( 'getHtml' )
			->will( $this->returnValue( 'SomeHtml' ) );

		$instance->setClasses( $combined );
		$instance->removeClasses( $toRemove );

		$this->assertEquals( $remainder, $instance->getClassString() );
	}

	public function setClassesProvider() {
		return array(
			array( null, '' ),

			array( '', '' ),
			array( array(), '' ),

			array( 'foo bar baz', 'foo bar baz' ),
			array( array( 'foo', 'bar', 'baz', ), 'foo bar baz' ),
		);
	}

	public function addClassesProvider() {
		return array(
			array( 'foo bar', null, 'foo bar' ),

			array( 'foo bar', '', 'foo bar' ),
			array( 'foo bar', array(), 'foo bar' ),

			array( 'foo bar', 'baz', 'foo bar baz' ),
			array( 'foo bar', array( 'baz' ), 'foo bar baz' ),

			array( 'foo bar', 'baz quok', 'foo bar baz quok' ),
			array( 'foo bar', array( 'baz', 'quok' ), 'foo bar baz quok' ),
		);
	}

	public function removeClassesProvider() {
		return array(
			array( 'foo bar', null, 'foo bar' ),

			array( 'foo bar', '', 'foo bar' ),
			array( 'foo bar', array(), 'foo bar' ),

			array( 'foo bar baz', 'bar', 'foo baz' ),
			array( 'foo bar baz', array( 'baz' ), 'foo bar' ),

			array( 'foo bar baz quok', 'foo baz', 'bar quok' ),
			array( 'foo bar baz quok', array( 'bar', 'baz' ), 'foo quok' ),
		);
	}

	protected function getChameleonSkinTemplateStub() {
		return $this->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();
	}

	/**
	 * Asserts that $actual is a valid HTML fragment
	 *
	 * @todo Currently only asserts that $actual is a string. Need to parse and validate,
	 *
	 * @param        $actual
	 * @param string $message
	 */
	public function assertValidHTML( $actual, $message = '' ) {
		$this->assertInternalType( 'string', $actual, $message );
	}

}
