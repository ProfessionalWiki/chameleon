#! /bin/bash
set -e

MW_BRANCH=$1
EXTENSION_NAME=$2

wget https://github.com/wikimedia/mediawiki/archive/$MW_BRANCH.tar.gz -nv

tar -zxf $MW_BRANCH.tar.gz
mv mediawiki-$MW_BRANCH mediawiki

cd mediawiki

# TODO: Remove once MW < 1.43 is dropped from the matrix.
# Mirrors the upstream fix in MW REL1_43+ / master (mediawiki commit
# ef90ede, Phab T416518), which older branches never received.
composer config audit.block-insecure false

composer install
php maintenance/install.php --dbtype sqlite --dbuser root --dbname mw --dbpath $(pwd) --pass AdminPassword WikiName AdminUser

# echo 'error_reporting(E_ALL| E_STRICT);' >> LocalSettings.php
# echo 'ini_set("display_errors", 1);' >> LocalSettings.php
echo '$wgShowExceptionDetails = true;' >> LocalSettings.php
echo '$wgShowDBErrorBacktrace = true;' >> LocalSettings.php
echo '$wgDevelopmentWarnings = true;' >> LocalSettings.php

echo 'wfLoadExtension( "Bootstrap" );' >> LocalSettings.php
echo 'wfLoadSkin( "chameleon" );' >> LocalSettings.php

cat <<EOT >> composer.local.json
{
  "require": {

  },
	"extra": {
		"merge-plugin": {
			"merge-dev": true,
			"include": [
				"skins/*/composer.json"
			]
		}
	}
}
EOT
