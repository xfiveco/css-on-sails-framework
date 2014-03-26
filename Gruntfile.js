module.exports = function(grunt) {

  grunt.initConfig({

    pkg: grunt.file.readJSON('package.json'),

    // Beautify HTML & CSS files
    jsbeautifier: {
      files: ['project/*.html', 'project/_ui/js/main.js'],
      options : {
        html: {
          indentSize: 2
        },
        js: {
          indentSize: 2
        }
      }
    },

    // Beautify CSS files
    cssbeautifier: {
      files: ['project/_ui/css/*.css'],
      options : {
        indent: '  ',
        openbrace: 'end-of-line',
        autosemicolon: false
      }
    },

    // Validate HTML files
    validation: {
      files: ['project/*.html'],
      options: {
        reset: true
      }
    },

    // Check JS code
    jshint: {
      files: ['project/_ui/js/main.js'],
      options: {
        jshintrc: true,
        reporter: require('jshint-stylish')
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
