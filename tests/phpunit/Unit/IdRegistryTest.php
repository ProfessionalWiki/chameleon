<?php

declare( strict_types = 1 );

namespace Skins\Chameleon\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Skins\Chameleon\IdRegistry;

/**
 * @covers \Skins\Chameleon\IdRegistry
 *
 * @group skins-chameleon
 * @group mediawiki-databaseless
 */
class IdRegistryTest extends TestCase {

	public function testIdsAreAvailableAgainOnANewPage(): void {
		$registry = new IdRegistry();
		$registry->getId( 'some-id' );

		$registry->startNewPage();

		$this->assertSame( 'some-id', $registry->getId( 'some-id' ) );
	}

}
