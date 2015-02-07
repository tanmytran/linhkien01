module.exports = function (grunt) {
	// load all deps
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	// configuration
	grunt.initConfig({
		pgk: grunt.file.readJSON('package.json'),

		// https://npmjs.org/package/grunt-contrib-compass
		compass: {
			all: {
				options: {
					sassDir:        'assets/lib',
					cssDir:         'assets/stylesheets',
					imagesDir:      'assets/images',
					outputStyle:    'compact',
					relativeAssets: true,
					noLineComments: true,
					watch:          true
				}
			}
		},

		// https://npmjs.org/package/grunt-contrib-watch
		watch: {
			options: {
				livereload: true
			},
			files: ['assets/{,*/}/*.{css,js}', '{,*/,woocommerce/**/,inc/**/}*.php']
		},

		// https://npmjs.org/package/grunt-concurrent
		concurrent: {
			server: [
				'compass:all',
				'watch'
			]
		},

		// https://npmjs.org/package/grunt-contrib-jshint
		jshint: {
			dist: {
				jshintrc: true,
				files: {
					src: ['assets/js/custom.js', 'Gruntfile.js']
				}
			}
		}
	});

	// when developing
	grunt.registerTask('server', [
		'concurrent:server'
	]);

	// linting
	grunt.registerTask('lint', ['jshint']);

	// defaults to the server
	grunt.registerTask('default', [
		'server'
	]);
};