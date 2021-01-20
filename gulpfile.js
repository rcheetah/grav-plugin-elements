'use strict';

// General
const gulp = require('gulp');
const clean = require('gulp-clean');
const sourcemaps = require('gulp-sourcemaps');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const log = require('gulplog');

// SASS
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
// JS
const browserify = require('browserify');
const babel = require('gulp-babel');




function defaultTask(cb) {
    cleanDist();
    style();
    js();
    watch();
    cb();
}

function watch() {
    gulp.watch("./src/scss/**/*.scss", style);
    gulp.watch("./src/js/**/*.js", js);
}

function cleanDist() {
    return gulp.src([
            "./css/**/*",
            "./js/**/*"
        ], {read:false})
        .pipe(clean());
}

function style() {
    return gulp.src("./src/scss/*.scss")
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({cascade: false}))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest("./css/"))
}

function js() {
    var b = browserify({
        entries: './src/js/footer.js',
        debug: true
    });
    return b.bundle()
        .on('error', function(err){
            console.log(err.message);
            this.emit('end');
        })
        .pipe(source("footer.js"))
        .pipe(buffer())
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(babel({
            presets: ["@babel/preset-env"]
        }))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest("./js/"))
}

exports.default = defaultTask;
exports.clean = cleanDist;