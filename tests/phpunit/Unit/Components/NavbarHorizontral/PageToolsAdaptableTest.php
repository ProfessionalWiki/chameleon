<?php
/**
 * This file is part of the MediaWiki skin Chameleon.
 *
 * @copyright 2013 - 2017, Stephan Gambke
 * @license   GNU General Public License, version 3 (or any later version)
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

namespace Skins\Chameleon\Tests\Unit\Components\NavbarHorizontal;

use Skins\Chameleon\Components\NavbarHorizontal\PageToolsAdaptable;
use Skins\Chameleon\Tests\Unit\Components\GenericComponentTestCase;
use \Html;

/**
 * @coversDefaultClass \Skins\Chameleon\Components\NavbarHorizontal\PageToolsAdaptable
 * @covers ::<private>
 * @covers ::<protected>
 *
 * @group   skins-chameleon
 * @group   mediawiki-databaseless
 *
 * @author Stephan Gambke
 * @since 1.6
 * @ingroup Skins
 * @ingroup Test
 */
class PageToolsAdaptableTest extends GenericComponentTestCase
{

	protected $classUnderTest = '\Skins\Chameleon\Components\NavbarHorizontal\PageToolsAdaptable';

	/**
	 * @param string $show
	 * @param array $expectedIconClasses
	 * @covers ::getHtml
	 * @dataProvider providerShowIconData
	 */
	public function testGetHtml_ContainsIconsToShow( $show, $expectedIconClasses ) {

		$chameleonTemplate = $this->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();

		$chameleonTemplate->expects( $this->any() )
			->method( 'get' )
			->will( $this->returnValue( $this->skinTemplateGet() ) );

		$message = $this->getMockBuilder( '\Message' )
			->disableOriginalConstructor()
			->getMock();

		$message->expects( $this->any() )
			->method( 'text' )
			->will( $this->returnValue( '' ) );

		$chameleonTemplate->method( 'getMsg' )
			->willReturn( $message );

		$chameleonTemplate->method( 'makeListItem' )
			->will( $this->returnCallback( array( $this, 'makeListItem' ) ) );

		$domElement = $this->getMockBuilder( '\DOMElement' )
			->disableOriginalConstructor()
			->getMock();

		$domElement->expects( $this->any() )
			->method( 'getAttribute' )
			->will( $this->returnValue( $show ) );

		/** @var \Skins\Chameleon\Components\Component $instance */
		$instance = new $this->classUnderTest ( $chameleonTemplate, $domElement );

		$output = $instance->getHtml();
		foreach ( $expectedIconClasses as $expectedIconClass ) {
			$matcher = array( 'tag' => 'span', 'class' => $expectedIconClass );
			$this->assertTag(
				$matcher,
				$output,
				'Failed asserting that the given fragment contained the described node. '
					. 'Class "' . $expectedIconClass . '" not found in output for show value "' . $show . '"!'
			);
		}
	}

	/**
	 * @covers ::getHtml
	 */
	public function testGetHtml_ContainsNoIconsOnEmptyShow() {

		$chameleonTemplate = $this->getMockBuilder( '\Skins\Chameleon\ChameleonTemplate' )
			->disableOriginalConstructor()
			->getMock();

		$chameleonTemplate->expects( $this->any() )
			->method( 'get' )
			->will( $this->returnValue( $this->skinTemplateGet() ) );

		$message = $this->getMockBuilder( '\Message' )
			->disableOriginalConstructor()
			->getMock();

		$message->expects( $this->any() )
			->method( 'text' )
			->will( $this->returnValue( '' ) );

		$chameleonTemplate->method( 'getMsg' )
			->willReturn( $message );

		$chameleonTemplate->method( 'makeListItem' )
			->will( $this->returnCallback( array( $this, 'makeListItem' ) ) );

		$domElement = $this->getMockBuilder( '\DOMElement' )
			->disableOriginalConstructor()
			->getMock();

		$domElement->expects( $this->any() )
			->method( 'getAttribute' )
			->will( $this->returnValue( '' ) );

		/** @var \Skins\Chameleon\Components\Component $instance */
		$instance = new $this->classUnderTest ( $chameleonTemplate, $domElement );

		$output = $instance->getHtml();
		$this->assertNotContains(
			'glyphicon glyphicon-',
			$output
		);
	}

	/**
	 * @return array
	 */
	public function providerShowIconData() {
		return array(
			'view only' => array(
				'view',
				array( 'glyphicon glyphicon-' . PageToolsAdaptable::getGlyphIconForAction( 'view' ) ),
			),
			'all edits' => array(
				'edit,ve-edit,formedit',
				array(
					'glyphicon glyphicon-' . PageToolsAdaptable::getGlyphIconForAction( 'edit' ),
					'glyphicon glyphicon-' . PageToolsAdaptable::getGlyphIconForAction( 've-edit' ),
					'glyphicon glyphicon-' . PageToolsAdaptable::getGlyphIconForAction( 'formedit' ),
				),
			),
			'some invalid' => array(
				'view,etit,history,wotch,protekt',
				array(
					'glyphicon glyphicon-' . PageToolsAdaptable::getGlyphIconForAction( 'view' ),
					'glyphicon glyphicon-' . PageToolsAdaptable::getGlyphIconForAction( 'history' ),
				),
			),
		);
	}

	/**
	 * @param string $key
	 * @param array $item
	 * @param array $options
	 * @return string
	 */
	public function makeListItem( $key, $item, $options = array() ) {
		$html = isset( $item['text'] ) ? htmlentities( $item['text'] ) : '';
		if ( isset( $options['text-wrapper'] ) ) {
			$wrapper = $options['text-wrapper'];
			$html = Html::rawElement( $wrapper['tag'], $wrapper['attributes'], $html );
		}

		$link = $item;
		// These keys are used by makeListItem and shouldn't be passed on to the link
		foreach ( array( 'id', 'class', 'active', 'tag', 'itemtitle' ) as $k ) {
			unset( $link[$k] );
		}
		if ( isset( $options['link-class'] ) ) {
			if ( isset( $link['class'] ) ) {
				$link['class'] .= " {$options['link-class']}";
			} else {
				$link['class'] = $options['link-class'];
			}
		}
		$html = Html::rawElement( 'a', $link, $html );

		$attributes = array();
		foreach ( array( 'id', 'class' ) as $attr ) {
			if ( isset( $item[$attr] ) ) {
				$attributes[$attr] = $item[$attr];
			}
		}
		if ( isset( $item['active'] ) && $item['active'] ) {
			if ( !isset( $attributes['class'] ) ) {
				$attributes['class'] = '';
			}
			$attributes['class'] .= ' active';
			$attributes['class'] = trim( $attributes['class'] );
		}
		if ( isset( $item['itemtitle'] ) ) {
			$attributes['title'] = $item['itemtitle'];
		}
		return Html::rawElement( isset( $options['tag'] ) ? $options['tag'] : 'li', $attributes, $html );
	}

	/**
	 * @return array
	 */
	private function skinTemplateGet() {
		return array(
			'namespaces' => array(
				'talk' => array(
					'class'   => '',
					'text'    => 'Discussion',
					'href'    => '/mw/index.php?title=Talk:Main_Page',
					'primary' => true,
					'context' => 'talk',
					'id'      => 'ca-talk',
				),
			),
			'views'      => array(
				'view'     => array(
					'class'     => 'selected',
					'text'      => 'View',
					'href'      => '/mw/index.php/Main_Page',
					'primary'   => true,
					'redundant' => true,
					'id'        => 'ca-view',
				),
				've-edit'  => array(
					'class'   => '',
					'text'    => 'Edit with Virtual Editor',
					'href'    => '/mw/index.php?title=Main_Page&veaction=edit',
					'primary' => true,
					'id'      => 'ca-ve-edit',
				),
				'edit'     => array(
					'class'   => 'collapsible',
					'text'    => 'Edit',
					'href'    => '/mw/index.php?title=Main_Page&action=edit',
					'primary' => true,
					'id'      => 'ca-edit',
				),
				'formedit' => array(
					'class'   => '',
					'text'    => 'Edit with PageForms',
					'href'    => '/mw/index.php?title=Main_Page&action=formedit',
					'primary' => true,
					'id'      => 'ca-formedit',
				),
				'history'  => array(
					'class' => '',
					'text'  => 'History',
					'href'  => '/mw/index.php?title=Main_Page&action=history',
					'rel'   => 'archives',
					'id'    => 'ca-history',
				),
			),
			'actions'    => array(
				'delete'    => array(
					'class' => '',
					'text'  => 'Delete',
					'href'  => '/mw/index.php?title=Main_Page&action=delete',
					'id'    => 'ca-delete',
				),
				'undelete'  => array(
					'class' => '',
					'text'  => 'Restore 1 Version',
					'href'  => '/mw/index.php?title=Special:Undelete/Main_Page',
					'id'    => 'ca-undelete',
				),
				'move'      => array(
					'class' => '',
					'text'  => 'Move',
					'href'  => '/mw/index.php?title=Special:Move/Main_Page',
					'id'    => 'ca-move',
				),
				'protect'   => array(
					'class' => '',
					'text'  => 'Protect',
					'href'  => '/mw/index.php?title=Main_Page&action=protect',
					'id'    => 'ca-protect',
				),
				'unprotect' => array(
					'class' => '',
					'text'  => 'Change Protection',
					'href'  => '/mw/index.php?title=Main_Page&action=unprotect',
					'id'    => 'ca-unprotect',
				),
				'watch'     => array(
					'class' => 'mw-watchlink',
					'text'  => 'Watch',
					'href'  => '/mw/index.php?title=Main_Page&action=watch',
					'id'    => 'ca-watch',
				),
				'unwatch'   => array(
					'class' => 'mw-watchlink',
					'text'  => 'Unwatch',
					'href'  => '/mw/index.php?title=Main_Page&action=unwatch',
					'id'    => 'ca-unwatch',
				),
				'purge'     => array(
					'class' => '',
					'text'  => 'Refresh',
					'href'  => '/mw/index.php?title=Main_Page&action=purge',
					'id'    => 'ca-purge',
				),
			),
			'variants'   => array(),
		);
	}
}
