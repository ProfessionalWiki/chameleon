<?php
/**
 * File holding the MainContent class
 *
 * @copyright (C) 2013, Stephan Gambke
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki extension Chameleon.
 * The Chameleon extension is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Chameleon extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup   Skins
 */

namespace skins\chameleon\components;
use skins\chameleon\IdRegistry;

/**
 * The NavbarHorizontal class.
 *
 * A horizontal navbar containing the sidebar items.
 * Does not include standard items (toolbox, search, language links). They need to be added to the page elsewhere
 *
 * The navbar is a list of lists wrapped in a nav element: <nav role="navigation" id="p-navbar" >
 *
 * @ingroup Skins
 */
class MainContent extends Component {

	/**
	 * Builds the HTML code for this component
	 *
	 * @return String the HTML code
	 */
	public function getHtml() {

		$skintemplate = $this->getSkinTemplate();
		$idRegistry = IdRegistry::getRegistry();

		// START content
		$ret =
			$this->indent() . '<!-- start the content area -->' .
			$this->indent() . $idRegistry->openElement( 'div',
				array( 'id' => 'content', 'class' => 'mw-body ' . $this->getClassString() )
			) .

			$idRegistry->element( 'a', array( 'id' => 'top' ) ) .

			$this->indent() . '<div ' . \Html::expandAttributes( array(
					'id'    => $idRegistry->getId( 'mw-js-message' ),
					'style' => 'display:none;'

				)
			) . $skintemplate->get( 'userlangattributes' ) . '></div>';


		// START contentHeader
		$ret .=	$this->indent( 1 ) . '<div class ="contentHeader">' .

			$this->indent( 1 ) . '<!-- title of the page -->' .
			$this->indent() . $idRegistry->element('h1', array( 'id' => 'firstHeading','class'=>'firstHeading') , $skintemplate->get( 'title' ) ) .

			$this->indent() . '<!-- tagline; usually goes something like "From WikiName" primary purpose of this seems to be for printing to identify the source of the content -->' .
			$this->indent() . $idRegistry->element( 'div', array( 'id'=> 'siteSub' ), $skintemplate->getMsg( 'tagline' )->escaped() );

		if ( $skintemplate->data[ 'subtitle' ] ) {

			// TODO: should not use class 'small', better use class 'contentSub' and do styling in a less file
			$ret .=
				$this->indent() . '<!-- subtitle line; used for various things like the subpage hierarchy -->' .
				$this->indent() . $idRegistry->element( 'div', array( 'id' => 'contentSub', 'class' => 'small' ), $skintemplate->get( 'subtitle' ) );

		}

		if ( $skintemplate->data[ 'undelete' ] ) {
			// TODO: should not use class 'small', better use class 'contentSub2' and do styling in a less file
			$ret .=
				$this->indent() . '<!-- undelete message -->' .
				$this->indent() . $idRegistry->element( 'div', array( 'id' => 'contentSub2', 'class' => 'small' ), $skintemplate->get( 'undelete' ) );
		}

		// TODO: Do we need this? Seems to be an accessibility thing. It's used in vector to jump to the nav wich is at the bottom of the document, but our nav is usually at the top
		$ret .= $idRegistry->element( 'div', array(	'id' => 'jump-to-nav', 'class' => 'mw-jump'	),
			$skintemplate->getMsg( 'jumpto' )->escaped() . '<a href="#mw-navigation">' . $skintemplate->getMsg( 'jumptonavigation' )->escaped() . '</a>' .
			$skintemplate->getMsg( 'comma-separator' )->escaped() . '<a href="#p-search">' . $skintemplate->getMsg( 'jumptosearch' )->escaped() . '</a>'
		);

		$ret .= $this->indent( -1 ) . '</div>';
		// END contentHeader


		// START content body
		$ret .= $idRegistry->element( 'div', array( 'id' => 'bodyContent' ),
			$this->indent() . '<!-- body text -->' . "\n" .
			$this->indent() . $skintemplate->get( 'bodytext' )
		);
		// END content body

		if ( $skintemplate->data['printfooter'] ) {
			$ret .= '<div class="printfooter">' . $skintemplate->get( 'printfooter' ) . '</div>';
		}

		// TODO: Category links should be a separate component, but
		// * dataAfterContent should come after the the category links.
		// * only one extension is known to use it dataAfterContent and it is geared specifically towards MonoBook
		// => provide an attribut hideCatLinks for the XML and -if present- hide category links and assume somebody knows what they are doing
		$ret .= $this->indent() . '<!-- category links -->' .
				$this->indent() . $skintemplate->get( 'catlinks' );


		if ( $skintemplate->data[ 'dataAfterContent' ] ) {
			$ret .= $this->indent() . '<!-- data blocks which should go somewhere after the body text, but not before the catlinks block-->' .
					$this->indent() . $skintemplate->get( 'dataAfterContent' );
		}

		$ret .= $this->indent( -1 ) . '</div>' . "\n";
		// END content

		return $ret;
	}
}
