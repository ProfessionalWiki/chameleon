<?php

namespace Skins\Chameleon\Tests;

use Skins\Chameleon\Tests\Util\XmlFileProvider;

use DOMDocument;
use RuntimeException;

/**
 * @ingroup Test
 *
 * @group skins-chameleon
 * @group mediawiki-databaseless
 *
 * @license GNU GPL v3+
 * @since 1.0
 *
 * @author mwjames
 */
class XmlLayoutFileValidityTest extends \PHPUnit_Framework_TestCase {

	public function testXmlValidityOfLayoutFiles() {

		$xmlFileProvider = new XmlFileProvider( __DIR__ . '/../../layouts' );

		$listOfLayoutXmlFiles = $xmlFileProvider->getFiles();

		$this->assertNotEmpty( $listOfLayoutXmlFiles );
		$this->assertXmlFiles( $listOfLayoutXmlFiles );
	}

	protected function assertXmlFiles( $files ) {
		foreach ( $files as $file ) {
			$this->assertXmlDocumentLoad( $file );
		}
	}

	protected function assertXmlDocumentLoad( $file ) {
		$document = new DOMDocument();
		$document->validateOnParse = false;
		$this->assertTrue( $document->load( $file ) );
	}

}
