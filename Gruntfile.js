/*jshint node:true */
module.exports = function ( grunt ) {

	'use strict';

	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-jsonlint' );
	grunt.loadNpmTasks( 'grunt-banana-checker' );

	grunt.initConfig( {
		jshint: {
			options: {
				// Enforcing
				"bitwise": true,
				"curly": true,
				"eqeqeq": true,
				"freeze": true,
				"latedef": "nofunc",
				"noarg": true,
				"nonew": true,
				"undef": true,
				"unused": true,
				"strict": true,

				// ECMAScript version
				"esversion": 3,

				// Environment
				"browser": true,
				"jquery": true,

				// map of global variables, with keys as names and a boolean value to determine if they are assignable
				"globals": {
					"mediaWiki": false
				},

				"ignores": []
			},
			all: [
				'**/*.js',
				'!node_modules/**',
				'!resources/js/sticky-kit/**'
			]
		},
		banana: {
			all: 'resources/i18n/'
		},
		jsonlint: {
			all: [
				'**/*.json',
				'!node_modules/**'
			]
		}
	} );

	grunt.registerTask( 'lint', [ 'jshint', 'jsonlint', 'banana' ] );
	grunt.registerTask( 'test', [ 'lint' ] );
	grunt.registerTask( 'default', 'test' );
};
