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

	public function testRequestedIdIsReturnedAsIs(): void {
		$registry = new IdRegistry();

		$this->assertSame( 'some-id', $registry->getId( 'some-id' ) );
	}

	public function testTheSameIdIsNeverHandedOutTwice(): void {
		$registry = new IdRegistry();

		$ids = [ $registry->getId( 'some-id' ), $registry->getId( 'some-id' ), $registry->getId( 'some-id' ) ];

		$this->assertSame( $ids, array_unique( $ids ) );
	}

}
