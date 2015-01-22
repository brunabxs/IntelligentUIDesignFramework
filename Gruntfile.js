module.exports = function(grunt) {
  grunt.initConfig({
    jshint: {
      all: ['Gruntfile.js', 'src/test/acceptance/qunit/*.js', 'public/js/*.js']
    },
    qunit : {
      src: ['src/test/acceptance/qunit/qunit.html']
    }
  });

  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-qunit');

  // Default task.
  grunt.registerTask('travis', ['jshint','qunit']);
};
