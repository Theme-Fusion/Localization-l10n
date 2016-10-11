'use strict';

var grunt = require('grunt');

/*
  ======== A Handy Little Nodeunit Reference ========
  https://github.com/caolan/nodeunit

  Test methods:
    test.expect(numAssertions)
    test.done()
  Test assertions:
    test.ok(value, [message])
    test.equal(actual, expected, [message])
    test.notEqual(actual, expected, [message])
    test.deepEqual(actual, expected, [message])
    test.notDeepEqual(actual, expected, [message])
    test.strictEqual(actual, expected, [message])
    test.notStrictEqual(actual, expected, [message])
    test.throws(block, [error], [message])
    test.doesNotThrow(block, [error], [message])
    test.ifError(value)
*/

exports.msgInitMerge = {
  setUp : function(done) {
    // setup here if necessary
    done();
  },

  default : function(test) {
    test.expect(2);

    //ru locale should be created with msginit
    test.ok(grunt.file.isFile('tmp/i18n/ru/myDomain.po'));

    //en locale should be updated with msgmerge
    test.notEqual(grunt.file.read('tmp/i18n/en/myDomain.po').search('Hello world!'), -1);

    test.done();
  }
};
