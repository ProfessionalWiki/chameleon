<?php
/**
 * File containing the ResourceLoaderRegisterModules class
 *
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

namespace Skins\Chameleon\Hooks;

use ResourceLoader;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ResourceLoaderRegisterModules
 *
 * @author Morne Alberts
 * @since 4.2.1
 * @ingroup Skins
 */
class ResourceLoaderRegisterModules {

	private ResourceLoader $resourceLoader;
	private array $configuration;

	public function __construct( ResourceLoader $resourceLoader, array $configuration ) {
		$this->resourceLoader = $resourceLoader;
		$this->configuration = $configuration;
	}

	public function process(): void {
		$this->registerBootstrap();
		$this->registerChameleon();
	}

	private function registerBootstrap(): void {
		$this->resourceLoader->register(
			'zzz.ext.bootstrap.styles',
			$this->configuration['wgResourceModules']['ext.bootstrap.styles']
		);
	}

	private function registerChameleon(): void {
		$this->resourceLoader->register( 'skins.chameleon', [
			'class' => 'ResourceLoaderSkinModule',
			'features' => $this->getFeatures(),
			'targets' => [
				'desktop',
				'mobile'
			]
		] );
	}

	private function getFeatures(): array {
		if ( version_compare( MW_VERSION, '1.39', '<' ) ) {
			return [ 'elements', 'content', 'legacy', 'toc' ];
		}

		$features = [
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

		if ( $this->configuration['egChameleonEnableExternalLinkIcons'] === true ) {
			$features[] = 'content-links-external';
		}

		return $features;
	}

}
