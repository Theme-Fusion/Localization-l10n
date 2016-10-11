'use strict';

var grunt = require( 'grunt' );

/*
  ======== A Handy Little Nodeunit Reference ========
  https://github.com/caolan/nodeunit

  Test methods:
    test.expect( numAssertions )
    test.done()
  Test assertions:
    test.ok( value, [message] )
    test.equal( actual, expected, [message] )
    test.notEqual( actual, expected, [message] )
    test.deepEqual( actual, expected, [message] )
    test.notDeepEqual( actual, expected, [message] )
    test.strictEqual( actual, expected, [message] )
    test.notStrictEqual( actual, expected, [message] )
    test.throws( block, [error], [message] )
    test.doesNotThrow( block, [error], [message] )
    test.ifError( value )
*/

exports.potomo = {
	
	setUp: function( done ) {
		// setup here if necessary
		done();
	},
	
	en_GB: function( test ) {
		test.expect(1);

		var actual   = grunt.file.read( 'tmp/en_GB.mo' );
		var expected = grunt.file.read( 'test/expected/en_GB.mo' );
		test.equal( actual, expected, 'should compile PO to MO with msgfmt.' );

		test.done();
	},
	
	ne_NP: function( test ) {
		test.expect(1);

		var actual   = grunt.file.read( 'tmp/ne_NP.mo' );
		var expected = grunt.file.read( 'test/expected/ne_NP.mo' );
		test.equal( actual, expected, 'should compile PO to MO with msgfmt.' );

		test.done();
	}
};
