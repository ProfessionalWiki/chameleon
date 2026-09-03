<?php

namespace Skins\Chameleon\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Skins\Chameleon\Chameleon;

/**
 * @covers \Skins\Chameleon\Chameleon
 *
 * @group skins-chameleon
 * @group skins-chameleon-unit
 * @group mediawiki-databaseless
 *
 * @license GPL-3.0-or-later
 */
class ChameleonTest extends TestCase {

	/**
	 * @dataProvider mediaWikiVersionWithModernMenusProvider
	 */
	public function testMenusFromMediaWiki146AreTheModernOnes( string $mediaWikiVersion ) {
		$this->assertEqualsCanonicalizing(
			[
				'associated-pages',
				'views',
				'actions',
				'variants',
				'user-interface-preferences',
				'user-page',
				'notifications',
				'user-menu',
			],
			Chameleon::getSupportedMenus( $mediaWikiVersion )
		);
	}

	public static function mediaWikiVersionWithModernMenusProvider(): array {
		return [
			'release' => [ '1.46.0' ],
			'bare minor version' => [ '1.46' ],
			'development branch' => [ '1.46.0-alpha' ],
			'later version' => [ '1.47.0-alpha' ],
		];
	}

	/**
	 * @dataProvider mediaWikiVersionWithLegacyMenusProvider
	 */
	public function testMenusBeforeMediaWiki146AreTheLegacyOnes( string $mediaWikiVersion ) {
		$this->assertEqualsCanonicalizing(
			[ 'namespaces', 'views', 'actions', 'variants' ],
			Chameleon::getSupportedMenus( $mediaWikiVersion )
		);
	}

	public static function mediaWikiVersionWithLegacyMenusProvider(): array {
		return [
			'minimum supported version' => [ '1.43.9' ],
			'last version with legacy menus' => [ '1.45.3' ],
		];
	}

}
