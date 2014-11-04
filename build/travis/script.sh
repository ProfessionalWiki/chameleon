#! /bin/bash

#####
# This file is part of the MediaWiki skin Chameleon.
#
# @copyright 2013 - 2014, Stephan Gambke, mwjames
# @license   GNU General Public License, version 3 (or any later version)
#
# The Chameleon skin is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by the Free
# Software Foundation, either version 3 of the License, or (at your option) any
# later version.
#
# The Chameleon skin is distributed in the hope that it will be useful, but
# WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
# FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
# details.
#
# You should have received a copy of the GNU General Public License along with
# this program. If not, see <http://www.gnu.org/licenses/>.
#
# @author mwjames
# @since 1.0
# @ingroup Skins
#####

set -x

originalDirectory=$(pwd)

function installMediaWiki {
	cd ..

	wget https://github.com/wikimedia/mediawiki/archive/$MW.tar.gz
	tar -zxf $MW.tar.gz
	mv mediawiki-$MW mw

	cd mw

	## MW 1.25 requires Psr\Logger
	if [ "$MW" == "master" ]
	then
		composer install
	fi

	mysql -e 'create database its_a_mw;'
	php maintenance/install.php --dbtype $DBTYPE --dbuser root --dbname its_a_mw --dbpath $(pwd) --pass nyan TravisWiki admin
}

function installSkinViaComposerOnMediaWikiRoot {

	composer init

	composer require 'phpunit/phpunit=~4.0' --prefer-source
	composer require 'mediawiki/chameleon-skin=@dev' --prefer-source

	cd skins
	cd chameleon

	# Pull request number, "false" if it's not a pull request
	if [ "$TRAVIS_PULL_REQUEST" != "false" ]
	then
		git fetch origin +refs/pull/"$TRAVIS_PULL_REQUEST"/merge:
		git checkout -f FETCH_HEAD
	else
		git fetch origin "$TRAVIS_BRANCH"
		git checkout -f FETCH_HEAD
	fi

	git log HEAD^..HEAD

	cd ../..

	# Rebuild the class map after git fetch
	composer dump-autoload

	echo 'error_reporting(E_ALL| E_STRICT);' >> LocalSettings.php
	echo 'ini_set("display_errors", 1);' >> LocalSettings.php
	echo '$wgShowExceptionDetails = true;' >> LocalSettings.php
	echo '$wgDevelopmentWarnings = true;' >> LocalSettings.php
	echo "putenv( 'MW_INSTALL_PATH=$(pwd)' );" >> LocalSettings.php

	php maintenance/update.php --quick
}

function uploadCoverageReport {
	wget https://scrutinizer-ci.com/ocular.phar
	php ocular.phar code-coverage:upload --repository='g/wikimedia/mediawiki-skins-chameleon' --format=php-clover coverage.clover
}

installMediaWiki
installSkinViaComposerOnMediaWikiRoot

cd skins/chameleon

if [ "$MW" == "master" ]
then
	php ../../tests/phpunit/phpunit.php --group skins-chameleon -c phpunit.xml.dist --coverage-clover=coverage.clover
	uploadCoverageReport
else
	php ../../tests/phpunit/phpunit.php --group skins-chameleon -c phpunit.xml.dist
fi
