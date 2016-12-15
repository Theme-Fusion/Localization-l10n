module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		msgInitMerge: {
			theme: {
				src: ['Avada/Avada.pot'],
				options: {
					locales: ['ar', 'ca', 'bg_BG', 'cs_CZ', 'da_DK', 'de_DE','el', 'es_ES', 'fa', 'fa_IR', 'fi', 'fr_FR', 'he', 'hr_HR', 'hu_HU', 'it_IT', 'ja', 'ko', 'mk_MK', 'nb_NO', 'nl_NL', 'pl_PL', 'pt_BR', 'pt_PT', 'ro', 'ru_RU', 'sv_SE', 'tr_TR', 'uk_UA', 'zh_CN', 'zh_TW' ],
					poFilesPath: 'Avada/Avada-<%= locale%>.po',
					msgInit: {
						cmd: 'msginit',
						opts: {}
					},
					msgMerge: {
						cmd: 'msgmerge',
						opts: {
							'no-fuzzy-matching': true,
							'backup': 'none',
						}
					}
				}
			},
			plugin: {
				src: ['fusion-core/fusion-core.pot'],
				options: {
					locales: ['de_DE','es_ES', 'fi', 'fr_FR', 'he', 'it_IT', 'ja', 'ko', 'mk_MK', 'nb_NO', 'nl_NL', 'pl_PL', 'pt_BR', 'ru_RU'],
					poFilesPath: 'fusion-core/fusion-core-<%= locale%>.po',
					msgInit: {
						cmd: 'msginit',
						opts: {}
					},
					msgMerge: {
						cmd: 'msgmerge',
						opts: {
							'no-fuzzy-matching': true,
							'backup': 'none',
						}
					}
				}
			},
			plugin2: {
				src: ['fusion-builder/fusion-builder.pot'],
				options: {
					locales: ['de_DE','es_ES', 'fi', 'fr_FR', 'he', 'it_IT', 'ja', 'ko', 'mk_MK', 'nb_NO', 'nl_NL', 'pl_PL', 'pt_BR', 'ru_RU'],
					poFilesPath: 'fusion-builder/fusion-builder-<%= locale%>.po',
					msgInit: {
						cmd: 'msginit',
						opts: {}
					},
					msgMerge: {
						cmd: 'msgmerge',
						opts: {
							'no-fuzzy-matching': true,
							'backup': 'none',
						}
					}
				}
			}
		},
		potomo: {
			theme: {
				options: { poDel: false },
				files: [{
					expand: true,
					cwd: 'Avada',
					src: ['*.po'],
					dest: 'Avada',
					ext: '.mo',
					nonull: true
				}]
			},
			plugin: {
				options: { poDel: false },
				files: [{
					expand: true,
					cwd: 'fusion-core',
					src: ['*.po'],
					dest: 'fusion-core',
					ext: '.mo',
					nonull: true
				}]
			},
			plugin2: {
				options: { poDel: false },
				files: [{
					expand: true,
					cwd: 'fusion-builder',
					src: ['*.po'],
					dest: 'fusion-builder',
					ext: '.mo',
					nonull: true
				}]
			}
		},
	});

	grunt.loadNpmTasks( 'grunt-potomo' );
	grunt.loadNpmTasks( 'grunt-msg-init-merge' );

	grunt.registerTask('default', ['msgInitMerge', 'potomo'] );
};
