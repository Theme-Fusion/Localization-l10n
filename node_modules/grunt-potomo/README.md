# grunt-potomo [![Build Status](https://travis-ci.org/axisthemes/grunt-potomo.svg?branch=master)](https://travis-ci.org/axisthemes/grunt-potomo) [![npm version](https://img.shields.io/npm/v/grunt-potomo.svg)](https://www.npmjs.com/package/grunt-potomo)

> Grunt plug-in to compile .po files into binary .mo files with msgfmt.

### Requirements
* This plugin requires Grunt `~0.4.5`
* [GNU gettext](http://www.gnu.org/software/gettext/) installed and in your PATH. Installation instructions: [Mac](http://brewformulas.org/Gettext), [Windows](http://gnuwin32.sourceforge.net/packages/gettext.htm) and [Linux](http://ftp.gnu.org/pub/gnu/gettext/)

## Getting Started
If you haven't used [Grunt](http://gruntjs.com/) before, be sure to check out the [Getting Started](http://gruntjs.com/getting-started) guide, as it explains how to create a [Gruntfile](http://gruntjs.com/sample-gruntfile) as well as install and use Grunt plugins. Once you're familiar with that process, you may install this plugin with this command:

```shell
npm install grunt-potomo --save-dev
```

Once the plugin has been installed, it may be enabled inside your Gruntfile with this line of JavaScript:

```js
grunt.loadNpmTasks( 'grunt-potomo' );
```

## The "potomo" task
_Run this task with the `grunt potomo` command._

Task targets, files and options may be specified according to the grunt [Configuring tasks](http://gruntjs.com/configuring-tasks) guide.

### Options

#### options.poDel
Type: `Boolean`  
Default: `false`

Whether the `PO` file(s) used from source should be deleted or remove after the creation of `MO` file(s).

### Example config

```js
grunt.initConfig({
  potomo: {                            // Task
    dist: {                            // Target
      options: {                       // Target options
        poDel: true
      },
      files: {                         // Dictionary of files
        'en_GB.mo': 'en_GB.po',        // 'destination': 'source'
        'ne_NP.mo': 'ne_NP.po'
      }
    },
    dev: {                             // Another target
      options: {                       // Target options
        poDel: false
      },
      files: {
        'dest/languages': [ 'en_GB.po', 'ne_NP.po' ]
      }
    }
  }
});

grunt.loadNpmTasks( 'grunt-potomo' );

grunt.registerTask( 'default', ['potomo' ]);
```

### Example usage

#### Compile

```js
grunt.initConfig({
  potomo: {
    dist: {
      files: {
        'ne_NP.mo': 'ne_NP.po'
      }
    }
  }
});
```

#### Compile with options

```js
grunt.initConfig({
  potomo: {
    dist: {
      options: {
        poDel: true
      }
      files: {
        'ne_NP.mo': 'ne_NP.po'
      }
    }
  }
});
```

#### Compile multiple files

You can specify multiple `destination: source` items in `files`.

```js
grunt.initConfig({
  potomo: {
    dist: {
      files: {
        'en_GB.mo': 'en_GB.po',
        'ne_NP.mo': 'ne_NP.po'
      }
    }
  }
});
```

#### Compile files in a directory

Instead of naming all files you want to compile, you can use the `expand` property allowing you to specify a directory. More information available in the [grunt docs](http://gruntjs.com/configuring-tasks#building-the-files-object-dynamically) - `Building the files object dynamically`.

```js
grunt.initConfig({
  dirs: {
    lang: 'language',
  },
  potomo: {
    dist: {
      options: {
        poDel: false
      },
      files: [{
        expand: true,
        cwd: '<%= dirs.lang %>/po',
        src: ['*.po'],
        dest: '<%= dirs.lang %>/mo',
        ext: '.mo',
        nonull: true
      }]
    }
  }
});
```

## License

Copyright (c) 2016 [AxisThemes](http://axisthemes.com)  
Licensed under the MIT license:  
<http://axisthemes.mit-license.org/>
