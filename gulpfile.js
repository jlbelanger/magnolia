const gulp = require('gulp');
const autoprefixer = require('autoprefixer');
const concat = require('gulp-concat');
const cssnano = require('cssnano');
const livereload = require('gulp-livereload');
const mergeStream = require('merge-stream');
const postcss = require('gulp-postcss');
const sass = require('gulp-sass')(require('node-sass'));
const rename = require('gulp-rename');
const terser = require('gulp-terser');

const config = {
	css: {
		bundles: [
			{
				src: ['resources/scss/*.scss'],
				dest: 'public/assets/css',
			},
		],
		dest: 'public/assets/css',
		watch: ['node_modules/**/*.scss', 'resources/scss/*.scss', 'resources/scss/**/*.scss'],
	},
	js: {
		bundles: [
			{
				src: ['resources/js/*.js', 'resources/js/**/*.js'],
				dest_folder: 'public/assets/js',
				dest_file: 'functions.min.js',
			},
		],
		dest: 'public/assets/css',
		watch: ['node_modules/**/*.js', 'resources/js/*.js', 'resources/js/**/*.js'],
	},
};

function css() {
	return mergeStream(
		config.css.bundles.map((obj) => (
			gulp.src(obj.src)
				.pipe(sass())
				.pipe(rename({ suffix: '.min' }))
				.pipe(postcss([autoprefixer(), cssnano()]))
				.pipe(gulp.dest(obj.dest))
				.pipe(livereload())
		)),
	);
}

function js() {
	return mergeStream(
		config.js.bundles.map((obj) => (
			gulp.src(obj.src)
				.pipe(concat(obj.dest_file))
				.pipe(terser())
				.pipe(gulp.dest(obj.dest_folder))
				.pipe(livereload())
		)),
	);
}

gulp.task('default', () => {
	(gulp.parallel('css', 'js')());
	gulp.watch(config.css.watch, css);
	gulp.watch(config.js.watch, js);
	livereload.listen();
	gulp.watch([
		`${config.css.dest}/**/*.css`,
		`${config.js.dest}/**/*.js`,
	]).on('change', livereload.changed);
});

gulp.task('css', () => css());
gulp.task('js', () => js());
