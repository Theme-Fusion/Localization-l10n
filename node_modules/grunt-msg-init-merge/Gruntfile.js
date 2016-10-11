/*
 * grunt-msg-init-merge
 * https://github.com/kirill-zhirnov/grunt-msg-init-merge
 *
 * Copyright (c) 2015 Kirill Zhirnov
 * Licensed under the MIT license.
 */

'use strict';

module.exports = function (grunt) {

	// Project configuration.
	grunt.initConfig({
		jshint: {
			all: [
				'Gruntfile.js',
				'tasks/*.js',
				'<%= nodeunit.tests %>'
			],
			options: {
				jshintrc: '.jshintrc'
			}
		},

		// Before generating any new files, remove any previously-created files.
		clean: {
			tests: ['tmp']
		},

		copy: {
			old : {
				src : 'test/fixtures/old.po',
				dest : 'tmp/i18n/en/',
				expand : true,
				flatten : true,
				rename: function(dest, src) {
					return dest + 'myDomain.po';
				}
			}
		},

		// Configuration to be run (and then tested).
		msgInitMerge: {
			test: {
				options: {
					locales: [{name: 'ru_RU', folder: 'ru'}, 'en'],
					poFilesPath: 'tmp/i18n/<%= locale%>/<%= potFileName%>.po',
				},
				src: ['test/fixtures/*.pot']
			}
		},

		// Unit tests.
		nodeunit: {
			tests: ['test/*_test.js']
		}

	});

	// Actually load this plugin's task(s).
	grunt.loadTasks('tasks');

	// These plugins provide necessary tasks.
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-nodeunit');

	// Whenever the "test" task is run, first clean the "tmp" dir, then run this
	// plugin's task(s), then test the result.
	grunt.registerTask('test', ['clean', 'copy:old', 'msgInitMerge', 'nodeunit']);

	// By default, lint and run all tests.
	grunt.registerTask('default', ['jshint', 'test']);

};
