/* jshint node:true */
module.exports = function( grunt ){
	'use strict';

	grunt.initConfig({
		// setting folder templates
		dirs: {
			css: 'assets/css',
			less: 'assets/css',
			js: 'assets/js'
		},

		// Compile all .less files.
		less: {
			compile: {
				options: {
					// These paths are searched for @imports
					paths: ['<%= less.css %>/']
				},
				files: [{
					expand: true,
					cwd: '<%= dirs.css %>/',
					src: [
						'*.less',
						'!mixins.less'
					],
					dest: '<%= dirs.css %>/',
					ext: '.css'
				}]
			}
		},

		// Minify all .css files.
		cssmin: {
			minify: {
				expand: true,
				cwd: '<%= dirs.css %>/',
				src: ['*.css'],
				dest: '<%= dirs.css %>/',
				ext: '.css'
			}
		},

		// Minify .js files.
		uglify: {
			options: {
				preserveComments: 'some'
			},
			jsfiles: {
				files: [{
					expand: true,
					cwd: '<%= dirs.js %>/',
					src: [
						'*.js',
						'!*.min.js',
						'!Gruntfile.js',
					],
					dest: '<%= dirs.js %>/',
					ext: '.min.js'
				}]
			}
		},

		// Watch changes for assets
		watch: {
			less: {
				files: [
					'<%= dirs.less %>/*.less',
				],
				tasks: ['less', 'cssmin'],
			},
			js: {
				files: [
					'<%= dirs.js %>/*js',
					'!<%= dirs.js %>/*.min.js'
				],
				tasks: ['uglify']
			}
		},
		
		// build commands
		exec: {
		  tests: 'phpunit -c includes/tests/phpunit.xml',
      buildDir: '[ -d builds ] || mkdir -p builds/src',
      rsync: 'rsync -av --exclude=*build* --exclude=".git*" --exclude=*Gruntfile.js* --exclude=*node_modules* --exclude=*vendor* --exclude=*includes/tests* . ./builds/src',
      composer: 'composer install --no-dev -d builds/src',
		  bundle: {
		    cmd: function () {
		      var version = this.option('buildVer');
		      var cmd = 'cd builds/src && zip -r -x=*.project* -x=*.buildpath* -x=*.settings* -x="composer.*" ../msr_wp_plugin-'+ version +'.zip .';
		      
		      return cmd;
		    },
		    options: {
	        buildVer: '1.0'
	      }
		  }
		}

	});

	// Load NPM tasks to be used here
	grunt.loadNpmTasks( 'grunt-contrib-less' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks('grunt-exec');

	// Register tasks
	grunt.registerTask( 'default', [
		'less',
		'cssmin',
		'uglify'
	]);
	
  grunt.registerTask( 'build', [
    'less',
    'cssmin',
    'uglify',
    'exec:tests',
    'exec:buildDir',
    'exec:rsync',
    'exec:composer'
  ]);
  
  grunt.registerTask( 'bundle', ['exec:bundle']);

};