module.exports = function(grunt) {

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    jsbeautifier: {
      dist: {
        src: ['project/*.html', 'project/_ui/js/main.js'],
        options : {
          html: {
            indentSize: 2
          },
          js: {
            indentSize: 2
          }
        }
      }
    },

    cssbeautifier: {
      files: ['project/_ui/css/*.css']
    },

    validation: {
      src: ['project/*.html'],
      options: {
        reset: true
      }
    },

    jshint: {
      src: ['project/_ui/js/main.js'],
      options: {
        jshintrc: true
      }
    }

  });

  grunt.loadNpmTasks('grunt-jsbeautifier');
  grunt.loadNpmTasks('grunt-cssbeautifier');
  grunt.loadNpmTasks('grunt-html-validation');
  grunt.loadNpmTasks('grunt-contrib-jshint');

  grunt.registerTask('default', [
    'jsbeautifier',
    'cssbeautifier',
    'validation',
    'jshint'
  ]);
};
