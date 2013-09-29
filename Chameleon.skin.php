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

/**
 * SkinTemplate class for Chameleon skin
 *
 * @ingroup Skins
 */
class SkinChameleon extends SkinTemplate {

	var $skinname = 'chameleon';
	var $stylename = 'chameleon';
	var $template = 'ChameleonTemplate';
	var $useHeadElement = true;

	/**
	 * @param $out OutputPage object
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles( 'skins.chameleon' );
	}

}

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
		<div class="container-fluid">

			<div class="row-fluid" id="userlinks">

				<!-- personal tools as an unordered list -->
				<div class="span12 text-right">
					<ul class="inline">
						<!-- message to a user about new messages on their talkpage -->
						<?php if ( $this->data['newtalk'] ) { ?><li class="usermessage"><?php $this->html( 'newtalk' ); ?></li><?php } ?>
						<?php
						foreach ( $this->getPersonalTools() as $key => $item ) {
							echo $this->makeListItem( $key, $item );
						}
						?>

					</ul>
				</div>
			</div>

			<!-- Logo and main page link -->
			<div class="row-fluid" id="logo">
				<div class="span6">
					<?php
					echo Html::rawElement( 'a', array(
						'href' => $this->data['nav_urls']['mainpage']['href'],
							)
							+ Linker::tooltipAndAccesskeyAttribs( 'p-logo' ), Html::element( 'img', array(
								'src' => $this->data['logopath'],
							) ) );
					?>

				</div>

				<!-- search form -->
				<div class="span6 text-right" id='p-search'<?php echo Linker::tooltip( 'p-search' ) ?>>
					<form id="searchform" class="mw-search " action="<?php $this->text( 'wgScript' ); ?>">
						<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>" />
						<div class="input-append">
							<?php echo $this->makeSearchInput( array( 'id' => 'searchInput', 'type' => 'text', 'class' => 'input-large span7' ) ); ?>

							<!-- A "Go" button -->
							<?php echo $this->makeSearchButton( 'go', array( 'id' => 'searchGoButton', 'class' => 'searchButton btn span2' ) ); ?>

							<!-- A Full Text "Search" button -->
							<?php echo $this->makeSearchButton( 'fulltext', array( 'id' => 'mw-searchButton', 'class' => 'searchButton btn span3' ) ); ?>

							<!-- For an image button use something like -->
							<!-- echo $this->makeSearchButton( 'image', array( 'id' => 'searchButton', 'src' => $this->getSkin()->getSkinStylePath( 'images/searchbutton.png') ); -->
						</div>
					</form>
				</div>
			</div>


			<div class="row-fluid" id="navigation">
				<div class="span12">
					<div class='navbar'>
						<div class="navbar-inner">
							<ul class='nav'>

								<!-- sidebar
									do not include standard items (toolbox, search, language links) here
									they will be included later -->
								<?php foreach ( $this->getSidebar( array( 'search' => false, 'toolbox' => false, 'languages' => false ) ) as $boxName => $box ) { ?>
									<li class='dropdown' id='<?php echo Sanitizer::escapeId( $box['id'] ) ?>'<?php echo Linker::tooltip( $box['id'] ) ?>>
										<?php if ( is_array( $box['content'] ) ) { ?>
											<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo htmlspecialchars( $box['header'] ); ?></a>
											<ul class='dropdown-menu'>
												<?php
												foreach ( $box['content'] as $key => $item ) {
													echo $this->makeListItem( $key, $item );
												}
												?>

											</ul>
											<?php
										} else {
											echo $box['content'];
										}
										?>
									</li>
								<?php } ?>

							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="row-fluid" id="p-views">
				<div class="span12 text-center">
					<ul class="inline">
						<!-- list of tabs (Page, Discussion, View, Edit, etc.) sorted by category -->
						<?php foreach ( $this->data['content_navigation'] as $category => $tabs ) { ?>
							<!-- <?php echo htmlspecialchars( $this->msg( $category ) ); ?> -->
							<?php
							foreach ( $tabs as $key => $tab ) {
								$options = array( );
								if ( array_key_exists( 'class', $tab ) ) {
									$options['link-class'] = $tab['class'];
								}
								echo $this->makeListItem( $key, $tab, $options );
							}
						}
						?>
					</ul>
				</div>
			</div>

			<?php if ( $this->data['sitenotice'] ) { ?>
				<div class="row-fluid">
					<div class="span12 text-center">
						<!-- sitenotice -->
						<div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div>
					</div>
				</div>
			<?php } ?>

			<div class="row-fluid" id="content-wrapper">
				<div class="span12">

					<div id="mw-js-message" style="display:none;"<?php $this->html( 'userlangattributes' ) ?>></div>

					<!-- start the content area -->
					<div id="content" class="mw-body">
						<div class ="contentHeader">
							<!-- title of the page -->
							<h1 id="firstHeading" class="firstHeading"><?php $this->html( 'title' ) ?></h1>

							<!-- tagline; usually goes something like "From WikiName"
								primary purpose of this seems to be for printing to identify the source of the content -->
							<div id="siteSub" ><?php $this->msg( 'tagline' ); ?></div>

							<!-- subtitle line; used for various things like the subpage hierarchy -->
							<?php if ( $this->data['subtitle'] ) { ?><div id='contentSub' class='muted'><?php $this->html( 'subtitle' ); ?></div><?php } ?>

							<!-- undelete message -->
							<?php if ( $this->data['undelete'] ) { ?><div id='contentSub2'><?php $this->html( 'undelete' ); ?></div><?php } ?>
						</div>

						<!-- body text -->
						<?php $this->html( 'bodytext' ) ?>

						<!-- category links -->
						<?php $this->html( 'catlinks' ); ?>

						<!-- data blocks which should go somewhere after the body text, but not before the catlinks block-->
						<?php
						if ( $this->data['dataAfterContent'] ) {
							$this->html( 'dataAfterContent' );
						}
						?>

					</div>
				</div>
			</div>

			<div class="row-fluid" id="toolbox">
				<div class="span12">
					<div class='navbar' id='p-tb'<?php echo Linker::tooltip( 'p-tb' ) ?> >
						<div class="navbar-inner">
							<!-- <?php echo htmlspecialchars( $this->getMsg( 'toolbox' )->text() ); ?> -->
							<ul class='nav'>
								<?php
								foreach ( $this->getToolbox() as $key => $tbitem ) {
									echo $this->makeListItem( $key, $tbitem );
								}
								wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this ) );
								if ( $this->data['language_urls'] ) {
									?>
									<li class='dropup' id='p-lang'<?php echo Linker::tooltip( 'p-lang' ) ?>>

										<a href='#' data-target="#" class="dropdown-toggle" data-toggle="dropdown">
											<?php echo htmlspecialchars( $this->getMsg( 'otherlanguages' )->text() ); ?>
										</a>
										<ul class='dropdown-menu' >
											<?php
											foreach ( $this->data['language_urls'] as $key => $langlink ) {
												echo $this->makeListItem( $key, $langlink );
											}
											?>
										</ul>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="row-fluid" id="footer">
				<div class="span12">
					<!-- footer links (license line, about, privacy policy, and disclaimer links) -->
					<?php $footerlinks = $this->getFooterLinks(); ?>
					<ul class='unstyled footerInfo'>
						<?php
						foreach ( $footerlinks as $category => $links ) {
							if ( $category !== 'places' ) {
								?>
								<!-- <?php echo htmlspecialchars( $category ); ?> -->
								<?php foreach ( $links as $key ) { ?>
								<li><small><?php $this->html( $key ) ?></small></li>
									<?php
								}
							}
						}
						?>
					</ul>

					<ul class='inline'>
						<?php if ( array_key_exists( 'places', $footerlinks ) ) { ?>
							<!-- places -->
							<?php foreach ( $footerlinks['places'] as $key ) { ?>
								<li><small><?php $this->html( $key ) ?></small></li>
								<?php
							}
						}
						?>

						<!-- footer icons (powered by icon, "copyright" icon, etc.) -->
						<?php foreach ( $this->getFooterIcons( "icononly" ) as $blockName => $footerIcons ) { ?>
							<li class='pull-right'>
								<!-- <?php echo htmlspecialchars( $blockName ) . ': '; ?> -->
								<?php foreach ( $footerIcons as $icon ) { ?>
									<?php echo $this->getSkin()->makeFooterIcon( $icon ); ?>
								<?php } ?>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>

		</div>
		<?php $this->printTrail(); ?>
		</body>
		</html><?php
		wfRestoreWarnings();
	}

}

