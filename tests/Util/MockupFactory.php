<?php
/**
 * @ingroup Test
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 *
 * @license GNU GPL v3+
 * @since   1.0
 *
 * @author  Stephan Gambke
 */

namespace Skins\Chameleon\Tests\Util;


class MockupFactory {

	private $testCase;
	private $configuration = array(
		'UserIsLoggedIn'      => false,
		'UserNewMessageLinks' => array(),
	);

	public function __construct( \PHPUnit_Framework_TestCase $testCase ) {
		$this->testCase = $testCase;
	}

	/**
	 * Returns a new factory. Convenience method to avoid having to use the constructor.
	 *
	 * @param \PHPUnit_Framework_TestCase $testCase
	 *
	 * @return MockupFactory
	 */
	public static function makeFactory( \PHPUnit_Framework_TestCase $testCase ) {
		return new self( $testCase );
	}

	public function set( $key, $value ) {
		$this->configuration[ $key ] = $value;
	}

	public function getChameleonSkinTemplateStub() {

		$chameleonTemplate = $this->testCase->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();

		$chameleonTemplate->data = $this->getSkinTemplateDummyDataSetForMainNamespace();
		$chameleonTemplate->translator = $this->getTranslatorStub();

		$dataMap = array_map(
			function ( $key, $value ) {
				return array( $key, null, $value );
			},
			array_keys( $chameleonTemplate->data ),
			array_values( $chameleonTemplate->data )
		);

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'get' )
			->will( $this->testCase->returnValueMap( $dataMap ) );

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'getMsg' )
			->will( $this->testCase->returnValue( $this->getMessageStub() ) );

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'getSkin' )
			->will( $this->testCase->returnValue( $this->getSkinStub() ) );

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'getComponent' )
			->will( $this->testCase->returnValue( $this->getComponentStub() ) );

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'getSidebar' )
			->will( $this->testCase->returnValue( array() ) );

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'getToolbox' )
			->will( $this->testCase->returnValue( array() ) );

		$chameleonTemplate->expects( $this->testCase->any() )
			->method( 'getPersonalTools' )
			->will( $this->testCase->returnValue( array( 'foo' => array(), 'bar' => array() ) ) );

		$chameleonTemplate->expects( $this->testCase->any( 0 ) )
			->method( 'getFooterLinks' )
			->will( $this->testCase->returnValue(
					array(
						'category1' => array( 'key1', 'key2' ),
						'category2' => array( 'key3', 'key4' ),
						'places'    => array( 'privacy', 'about', 'disclaimer' ),
					)
				)
			);

		return $chameleonTemplate;
	}

	/**
	 * Dummy values are by no means to represent a particular intention or
	 * objective and merely used to pass through the respective method
	 *
	 * Testing specific conditions should be done separately in each sub
	 * component
	 */
	protected function getSkinTemplateDummyDataSetForMainNamespace() {
		return array(

			// Required by Logo
			'logopath'           => 'foo',

			// Required by NavMenu
			'nav_urls'           => array(
				'mainpage' => array( 'href' => 'bat' )
			),

			// Required by PageTools
			'content_navigation' => array(
				'namespaces' =>
					array(
						'talk' =>
							array(
								'class'   => '',
								'text'    => 'Discussion',
								'href'    => '/mw/index.php?title=Talk:Main_Page',
								'primary' => true,
								'context' => 'talk',
								'id'      => 'ca-talk',
							),
					),
				'views'      =>
					array(
						'view'    =>
							array(
								'class'     => 'selected',
								'text'      => 'View',
								'href'      => '/mw/index.php/Main_Page',
								'primary'   => true,
								'redundant' => true,
								'id'        => 'ca-view',
							),
						'edit'    =>
							array(
								'class'   => '',
								'text'    => 'Edit',
								'href'    => '/mw/index.php?title=Main_Page&action=edit',
								'primary' => true,
								'id'      => 'ca-edit',
							),
						'history' =>
							array(
								'class' => false,
								'text'  => 'History',
								'href'  => '/mw/index.php?title=Main_Page&action=history',
								'rel'   => 'archives',
								'id'    => 'ca-history',
							),
					),
			),

			// Required by SearchBar
			'wgScript'           => 'bam',
			'searchtitle'        => 'jouy',

			// Required by MainContent
			'subtitle'           => 'SomeSubtitle',
			'undelete'           => 'SomeUndeleteMessage',
			'dataAfterContent'   => 'SomeDataAfterContent',
		);
	}

	protected function getTranslatorStub() {

		$translator = $this->testCase->getMockBuilder( '\stdClass' )
			->setMethods( array( 'translate' ) )
			->getMock();

		$translator->expects( $this->testCase->any() )
			->method( 'translate' )
			->will( $this->testCase->returnValue( 'translate' ) );

		return $translator;
	}

	protected function getMessageStub() {

		$message = $this->testCase->getMockBuilder( '\Message' )
			->disableOriginalConstructor()
			->getMock();

		$message->expects( $this->testCase->any() )
			->method( 'params' )
			->will( $this->testCase->returnSelf() );

		return $message;

	}

	protected function getSkinStub() {

		$title = \Title::newFromText( 'FOO' );

		$skin = $this->testCase->getMockBuilder( '\Skin' )
			->disableOriginalConstructor()
			->getMock();

		$skin->expects( $this->testCase->any() )
			->method( 'getTitle' )
			->will( $this->testCase->returnValue( $title ) );

		$skin->expects( $this->testCase->any() )
			->method( 'getUser' )
			->will( $this->testCase->returnValue( $this->getUserStub() ) );

		return $skin;
	}

	protected function getComponentStub() {

		$component = $this->testCase->getMockBuilder( 'Skins\Chameleon\Components\Component' )
			->disableOriginalConstructor()
			->getMock();

		$component->expects( $this->testCase->any() )
			->method( 'getHtml' )
			->will( $this->testCase->returnValue( 'SomePlainText' ) );

		return $component;
	}

	protected function getUserStub() {

		$user = $this->testCase->getMockBuilder( '\User' )
			->disableOriginalConstructor()
			->getMock();

		$user->expects( $this->testCase->any() )
			->method( 'isLoggedIn' )
			->will( $this->testCase->returnValue( $this->get( 'UserIsLoggedIn', true ) ) );

		$user->expects( $this->testCase->any() )
			->method( 'getNewMessageLinks' )
			->will( $this->testCase->returnValue( $this->get( 'UserNewMessageLinks', 0 ) ) );

		$user->expects( $this->testCase->any() )
			->method( 'getTalkPage' )
			->will( $this->testCase->returnValue( $this->getTitleStub() ) );

		return $user;

	}

	public function get( $key, $default = null ) {

		if ( isset( $this->configuration[ $key ] ) ) {
			return $this->configuration[ $key ];
		} else {
			return $default;
		}

	}

	protected function getTitleStub() {

		$title = $this->testCase->getMockBuilder( '\Title' )
			->disableOriginalConstructor()
			->getMock();

		$title->expects( $this->testCase->any() )
			->method( 'getLinkUrl' )
			->will( $this->testCase->returnValue( 'SomeLinkUrl' ) );

		return $title;

	}

}
