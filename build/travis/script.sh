#! /bin/bash

#####
# This file is part of the MediaWiki skin Chameleon.
#
# @copyright 2013 - 2016, Stephan Gambke, mwjames
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

set -x  # display commands and their expanded arguments
set -u  # treat unset variables as an error when performing parameter expansion
set -o pipefail  # pipelines exit with last (rightmost) non-zero exit code
set -e  # exit immediately if a command exits with an error

originalDirectory=$(pwd)

function installMediaWiki {
	cd ..

	wget https://github.com/wikimedia/mediawiki/archive/$MW.tar.gz
	tar -zxf $MW.tar.gz
	mv mediawiki-$MW mw

	cd mw

	## MW 1.25+ installs packages using composer
	if [ -f composer.json ]
	then
		composer install --prefer-source
	fi

	mysql -e 'create database its_a_mw;'
	php maintenance/install.php --dbtype $DBTYPE --dbuser root --dbname its_a_mw --dbpath $(pwd) --pass nyan TravisWiki admin
}

function installSkinViaComposerOnMediaWikiRoot {

	if [ ! -f composer.json ]
	then
		composer init
	fi

	composer remove --dev --update-with-dependencies 'phpunit/phpunit'
	composer require 'phpunit/phpunit=~4.0' 'mediawiki/chameleon-skin=@dev' --prefer-source

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

	php maintenance/update.php --quick --skip-external-dependencies
}

function uploadCoverageReport {
	wget https://scrutinizer-ci.com/ocular.phar
	php ocular.phar code-coverage:upload --repository='g/cmln/chameleon' --format=php-clover coverage.clover
}

composer self-update

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
