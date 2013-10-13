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
		}
	}

}

namespace skins\chameleon {

	use BaseTemplate;

	/**
	 * BaseTemplate class for Chameleon skin
	 *
	 * @ingroup Skins
	 */
	class ChameleonTemplate extends BaseTemplate {

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
			?>

			<div class="container">

				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-3">
						<?php $component = new components\Logo( $this, 6 ); echo $component->getHtml(); ?>
					</div>

					<div class="col-lg-9 col-md-9 col-sm-9">

						<div class="row">
							<div class="col-lg-12"><?php $component = new components\PersonalTools( $this, 8 ); echo $component->getHtml(); ?>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12"><?php $component = new components\SearchForm( $this, 8 ); echo $component->getHtml(); ?>
							</div>
						</div>

					</div>
				</div>


				<div class="row">
					<div class="col-lg-12"><?php $component = new components\NavbarHorizontal( $this, 6 ); echo $component->getHtml();?>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12"><?php $component = new components\TabList( $this, 6 ); echo $component->getHtml(); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12"><?php $component = new components\SiteNotice( $this, 6 ); echo $component->getHtml(); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12"><?php $component = new components\MainContent( $this, 6 ); echo $component->getHtml(); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12"><?php $component = new components\ToolbarHorizontal( $this, 6 ); echo $component->getHtml(); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12"><?php $component = new components\FooterInfo( $this, 6 ); echo $component->getHtml(); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-6"><?php $component = new components\FooterPlaces( $this, 6 ); echo $component->getHtml(); ?>
					</div>
					<div class="col-lg-6"><?php $component = new components\FooterIcons( $this, 6 ); echo $component->getHtml(); ?>
					</div>
				</div>

			</div>
<?php $this->printTrail(); ?>

</body>
</html><?php
			wfRestoreWarnings();
		}

	}

}
