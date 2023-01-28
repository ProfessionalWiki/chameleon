<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2023, Morne Alberts
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

namespace Skins\Chameleon\Tests\Unit\Hooks;

use ResourceLoader;
use PHPUnit\Framework\TestCase;
use Skins\Chameleon\Hooks\ResourceLoaderRegisterModules;

/**
 * @coversDefaultClass \Skins\Chameleon\Hooks\ResourceLoaderRegisterModules
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group skins-chameleon
 * @group skins-chameleon-unit
 * @group mediawiki-databaseless
 *
 * @author Morne Alberts
 * @since 4.2.1
 * @ingroup Skins
 * @ingroup Test
 */
class ResourceLoaderRegisterModulesTest extends TestCase {

	private function newBaseConfig(): array {
		return [
			'wgResourceModules' => [
				'ext.bootstrap.styles' => [ 'foo' => 'bar' ]
			],
			'egChameleonEnableExternalLinkIcons' => false
		];
	}

	/**
	 * @covers ::__construct
	 */
	public function testCanConstruct() {
		$resourceLoader = $this->getMockBuilder( ResourceLoader::class )
			->disableOriginalConstructor()
			->getMock();

		$configuration = $this->newBaseConfig();

		$this->assertInstanceOf(
			ResourceLoaderRegisterModules::class,
			new ResourceLoaderRegisterModules( $resourceLoader, $configuration )
		);
	}

	/**
	 * @covers ::process
	 * @covers ::registerBootstrap
	 * @covers ::registerChameleon
	 */
	public function testProcess() {
		$resourceLoader = $this->getMockBuilder( ResourceLoader::class )
			->disableOriginalConstructor()
			->getMock();

		$resourceLoader->expects( $this->exactly( 2 ) )
			->method( 'register' )
			->withConsecutive(
				[ 'zzz.ext.bootstrap.styles', [ 'foo' => 'bar' ] ],
				[ 'skins.chameleon', [
					'class' => 'ResourceLoaderSkinModule',
					'features' => $this->getBaseFeatures(),
					'targets' => [
						'desktop',
						'mobile'
					]
				] ],
			);

		$configuration = $this->newBaseConfig();

		( new ResourceLoaderRegisterModules( $resourceLoader, $configuration ) )->process();
	}

	/**
	 * @covers ::process
	 * @covers ::registerBootstrap
	 * @covers ::registerChameleon
	 */
	public function testProcessWithExternalLinkIconsEnabled() {
		$resourceLoader = $this->getMockBuilder( ResourceLoader::class )
			->disableOriginalConstructor()
			->getMock();

		$features = $this->getBaseFeatures();

		if ( version_compare( MW_VERSION, '1.39', '>=' ) ) {
			$features[] = 'content-links-external';
		}

		$resourceLoader->expects( $this->exactly( 2 ) )
			->method( 'register' )
			->withConsecutive(
				[ 'zzz.ext.bootstrap.styles', [ 'foo' => 'bar' ] ],
				[ 'skins.chameleon', [
					'class' => 'ResourceLoaderSkinModule',
					'features' => $features,
					'targets' => [
						'desktop',
						'mobile'
					]
				] ],
			);

		$configuration = [ 'egChameleonEnableExternalLinkIcons' => true ] + $this->newBaseConfig();

		( new ResourceLoaderRegisterModules( $resourceLoader, $configuration ) )->process();
	}

	private function getBaseFeatures(): array {
		if ( version_compare( MW_VERSION, '1.39', '<' ) ) {
			return [ 'elements', 'content', 'legacy', 'toc' ];
		}

		return [
			'elements',
			'content-links',
			'content-media',
			'interface-message-box',
			'interface-category',
			'content-tables',
			'i18n-ordered-lists',
			'i18n-all-lists-margins',
			'i18n-headings',
			'toc'
		];
	}

}
