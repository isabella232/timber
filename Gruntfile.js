module.exports = function(grunt) {
	grunt.loadNpmTasks('grunt-release');

	grunt.initConfig({
		release: {
			options: {
				file: 'composer.json'
			}
		}
	});
};