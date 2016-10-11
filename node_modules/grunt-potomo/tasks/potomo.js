/*
 * grunt-potomo
 * https://github.com/axisthemes/grunt-potomo
 *
 * Copyright (c) 2016 AxisThemes
 * Licensed under the MIT license.
 */

'use strict';

var shell = require( 'shelljs' );

module.exports = function( grunt ) {

	grunt.registerMultiTask( 'potomo', 'Compile .po files into binary .mo files with msgfmt.', function() {
		var options = this.options({
			poDel: false
		});

		// Return warning if not found msgfmt command
		if ( ! shell.which( 'msgfmt' ) ) {
			grunt.fail.fatal( 'GNU gettext is not installed in your system PATH.' );
		}

		if ( this.files.length < 1 ) {
			grunt.verbose.warn( 'Destination not written because no source files were provided.' );
		}

		this.files.forEach( function( file ) {

			var files = file.src.filter( function( filepath ) {
				// Warn on and remove invalid source files (if nonull was set).
				if ( ! grunt.file.exists( filepath ) ) {
					grunt.log.warn( 'Source file "' + filepath.cyan + '" not found.' );
					return false;
				} else {
					return true;
				}
			}).map( function( filepath ) {
				return grunt.file.read( filepath );
			}).join( grunt.util.normalizelf( grunt.util.linefeed ) );

			// Make sure grunt creates the destination folders if they don't exist
			if( ! grunt.file.exists( file.dest ) ) {
				grunt.file.write( file.dest, '' );
			}

			// Run external tool synchronously.
			var command = 'msgfmt -o ' + file.dest + ' ' + file.src[0];
			if( shell.exec( command ).code !== 0 ) {
				grunt.log.error( 'Failed to Compile "*.po" files into binary "*.mo" files with "msgfmt".'.cyan );
				shell.exit(1);
			} else {
				grunt.verbose.writeln( 'File ' + file.dest.cyan + ' Created.' );
			}

			// Delete Source PO file(s).
			if ( options.poDel && grunt.file.exists( file.src[0] ) ) {
				grunt.file.delete( file.src[0] );
			}
		});

		// Process the Message.
		if ( this.files.length > 1 ) {
			var message = "Total compiled " + this.files.length + ' ".mo" files.';
			if ( options.poDel ) {
				message = "Total compiled " + this.files.length + " and deleted " + this.files.length + ' ".po" files.';
			}
			grunt.log.ok( message );
		}
	});
};
