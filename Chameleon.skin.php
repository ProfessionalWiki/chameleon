<?php
/**
 * Skin file for Chameleon skin
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki skin Chameleon.
 * The Chameleon skin is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Chameleon skin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup Skins
 */

namespace {

	/**
	 * SkinTemplate class for Chameleon skin
	 *
	 * @ingroup Skins
	 */
	class SkinChameleon extends SkinTemplate {

		var $skinname = 'chameleon';
		var $stylename = 'chameleon';
		var $template = '\skins\chameleon\ChameleonTemplate';
		var $useHeadElement = true;

		/**
		 * @param $out OutputPage object
		 */
		function setupSkinUserCss( OutputPage $out ) {

			parent::setupSkinUserCss( $out );

			// load Bootstrap styles
			$out->addModuleStyles( 'ext.bootstrap' );
		}

		/**
		 * @param \OutputPage $out
		 */
		function initPage( OutputPage $out ) {

			parent::initPage( $out );

			// load Bootstrap scripts
			$out->addModules( array( 'ext.bootstrap' ) );

			// Enable responsive behaviour on mobile browsers
			$out->addMeta( 'viewport', 'width=device-width, initial-scale=1.0' );
		}
	}

}

namespace skins\chameleon {

	use BaseTemplate;
	use DOMDocument;
	use skins\chameleon\components\Container;

	/**
	 * BaseTemplate class for Chameleon skin
	 *
	 * @ingroup Skins
	 */
	class ChameleonTemplate extends BaseTemplate {

		// the root component of the page; should be of type Container
		private $mRootComponent = null;

		/**
		 * Outputs the entire contents of the page
		 */
		public function execute() {

			// Suppress warnings to prevent notices about missing indexes in $this->data
			wfSuppressWarnings();

			// output the head element
			// The headelement defines the <body> tag itself, it shouldn't be included in the html text
			// To add attributes or classes to the body tag override addToBodyAttributes() in SkinChameleon
			$this->html( 'headelement' );
			echo $this->getRootComponent()->getHtml();
			$this->printTrail(); ?>

</body>
</html><?php
			wfRestoreWarnings();
		}

		protected function getRootComponent() {

			global $egChameleonLayoutFile;

			if ( $this->mRootComponent === null ) {

				$doc = new DOMDocument();

				$doc->load( $egChameleonLayoutFile ); //TODO: error handling (file not found, file empty)

				$doc->normalizeDocument();

				// TODO: only create new root component the first time
				$roots = $doc->getElementsByTagName( 'structure' );

				if ( $roots->length > 0 ) {

					$this->mRootComponent = $this->getComponent( $roots->item( 0 ) );

				} else {
					// TODO: catch other errors, e.g. malformed XML
					throw new \MWException( 'XML description is missing an element: structure' );
				}
			}

			return $this->mRootComponent;

		}

		/**
		 * @param \DOMElement $description
		 */
		public function getComponent( \DOMElement $description, $indent = 0, $htmlClassAttribute = '' ) {

			$class = 'skins\\chameleon\\components\\';

			switch ($description->nodeName) {
			case 'structure':
				$class .= 'Structure';
				break;
			case 'grid':
				$class .= 'Grid';
				break;
			case 'row':
				$class .= 'Row';
				break;
			case 'cell':
				$class .= 'Cell';
				break;
			default:
				if ( $description->hasAttribute('type')) {
					$class .= $description->getAttribute('type');
				} else {
					$class .= 'Container';
				}
			}

			if ( class_exists( $class ) && is_subclass_of( $class, 'skins\\chameleon\\components\\Component' )) {
				return new $class( $this, $description, $indent, $htmlClassAttribute );
			} else {
				return new Container( $this, $description, $indent, $htmlClassAttribute );
			}
		}
	}

}
