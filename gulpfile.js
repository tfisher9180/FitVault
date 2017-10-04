/*
 * After npm install, postinstall (inside package.json) runs gulp copy-assets
 *
 * Gulp copy-assets:
 *   Moves all appropriate & needed files from the node_modules folder to the src folder
 *
 * Gulp sass:
 *   Gets the immediate scss file in the /sass folder (child-theme.scss) and compiles it
 *
 *   /sass/child-theme.scss
 *     Entry point for styles - Grab whatever we need from the src folder using partials
 *     Also grabs parent theme styles here since installed with npm (underscores)
 *
 *   /sass/assets/bootstrap4.scss
 *     Separate this out so we can pick what we want to include from Bootstrap 4
 *     Commented out a few lines, and added @import for _functions.scss
*/

// Defining base pathes
var basePaths = {
    bower: './bower_components/',
    node: './node_modules/',
    dev: './src/'
};

// Defining requirements
var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var cssnano = require('gulp-cssnano');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var merge2 = require('merge2');
var ignore = require('gulp-ignore');
var rimraf = require('gulp-rimraf');
var clone = require('gulp-clone');
var merge = require('gulp-merge');
var sourcemaps = require('gulp-sourcemaps');
var del = require('del');

gulp.task('default', ['watch', 'cssnano'], function () { });

// Starts watcher. Watcher runs gulp sass task on changes
gulp.task('watch', function () {
    gulp.watch('./sass/**/*.scss', ['sass']);
    gulp.watch('./css/child-theme.css', ['cssnano']);
    gulp.watch([basePaths.dev + 'js/**/*.js'], ['scripts'])
});

// Compiles SCSS files in CSS
gulp.task('sass', function () {
    var stream = gulp.src('./sass/*.scss')
        .pipe(plumber())
        .pipe(sass())
        .pipe(gulp.dest('./css'))
        .pipe(rename('custom-editor-style.css'))
        .pipe(gulp.dest('./css'));
    return stream;
});

// Minifies CSS files
gulp.task('cssnano', ['cleancss'], function(){
  return gulp.src('./css/*.css')
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(plumber())
    .pipe(rename({suffix: '.min'}))
    .pipe(cssnano({discardComments: {removeAll: true}}))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./css/'));
});

gulp.task('cleancss', function() {
  return gulp.src('./css/*.min.css', { read: false }) // much faster
    .pipe(ignore('theme.css'))
    .pipe(rimraf());
});

// Uglifies and concat all JS files into one
gulp.task('scripts', function() {
    var scripts = [
        basePaths.dev + 'js/tether.js', // Must be loaded before BS4

        // Start - All BS4 stuff
        basePaths.dev + 'js/bootstrap4/bootstrap.js',

        // End - All BS4 stuff

        basePaths.dev + 'js/skip-link-focus-fix.js'
    ];
  gulp.src(scripts)
    .pipe(concat('child-theme.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('./js/'));

  gulp.src(scripts)
    .pipe(concat('child-theme.js'))
    .pipe(gulp.dest('./js/'));
});

// Deleting any file inside the /src folder (just in case we need to)
gulp.task('clean-source', function () {
  return del(['src/**/*',]);
});

// Copy all Bootstrap JS files
gulp.task('copy-assets', function() {

////////////////// All Bootstrap 4 Assets /////////////////////////
// Copy all Bootstrap JS files
    gulp.src(basePaths.node + 'bootstrap/dist/js/**/*.js')
       .pipe(gulp.dest(basePaths.dev + '/js/bootstrap4'));

// Copy all Bootstrap SCSS files
    gulp.src(basePaths.node + 'bootstrap/scss/**/*.scss')
       .pipe(gulp.dest(basePaths.dev + '/sass/bootstrap4'));
////////////////// End Bootstrap 4 Assets /////////////////////////

// Copy all UnderStrap SCSS files
    gulp.src(basePaths.node + 'understrap/sass/**/*.scss')
       .pipe(gulp.dest(basePaths.dev + '/sass/understrap'));

// Copy all Font Awesome Fonts
    gulp.src(basePaths.node + 'font-awesome/fonts/**/*.{ttf,woff,woff2,eof,svg}')
        .pipe(gulp.dest('./fonts'));

// Copy all Font Awesome SCSS files
    gulp.src(basePaths.node + 'font-awesome/scss/*.scss')
        .pipe(gulp.dest(basePaths.dev + '/sass/fontawesome'));

// Copy jQuery
    gulp.src(basePaths.node + 'jquery/dist/*.js')
        .pipe(gulp.dest(basePaths.dev + '/js'));

// _s SCSS files
    gulp.src(basePaths.node + 'undescores-for-npm/sass/**/*.scss')
        .pipe(gulp.dest(basePaths.dev + '/sass/underscores'));

// _s JS files
    gulp.src(basePaths.node + 'undescores-for-npm/js/*.js')
        .pipe(gulp.dest(basePaths.dev + '/js'));


// Copy Tether JS files
    gulp.src(basePaths.node + 'tether/dist/js/*.js')
        .pipe(gulp.dest(basePaths.dev + '/js'));

// Copy Tether CSS files
    gulp.src(basePaths.node + 'tether/dist/css/*.css')
        .pipe(gulp.dest(basePaths.dev + '/css'));

});
