var gulp = require('gulp');
//var coffee = require('gulp-coffee');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var imagemin = require('gulp-imagemin');
var sourcemaps = require('gulp-sourcemaps');
var del = require('del');
var sass = require('gulp-sass');
var csslint = require('gulp-csslint');
var wordpress = require("wordpress");
var WPAPI = require('wpapi');
var wp = new WPAPI({endpoint: 'http://src.wordpress-develop.dev/wp-json'});
const wordpressDebug = require('wordpress-debug').default;
const del = require('del');
const jshint = require('gulp-jshint');
const size = require('gulp-size');
const jscs = require('gulp-jscs');
var cssBase64 = require('gulp-css-base64');

var client = wordpress.createClient({
    url: "www.devnet.dev",
    username: "dev",
    password: "dev"
});
wordpressDebug('path/to/wp-config.php'); // Enable debug
wordpressDebug('path/to/wp-config.php', true); // Enable debug
wordpressDebug('path/to/wp-config.php', false); // Disable debug


var paths = {
    //scripts: ['client/js/**/*.coffee', '!client/external/**/*.coffee'],
    images: 'assets/images/**/*'
};

// Not all tasks need to use streams
// A gulpfile is just another node program and you can use any package available on npm
gulp.task('clean', function () {
    // You can use multiple globbing patterns as you would with `gulp.src`
    return del(['build']);
});

gulp.task('scripts', ['clean'], function () {
    // Minify and copy all JavaScript (except vendor scripts)
    // with sourcemaps all the way down
    return gulp.src(paths.scripts)
        .pipe(sourcemaps.init())
        // .pipe(coffee())
        .pipe(uglify())
        .pipe(concat('all.min.js'))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('build/js'));
});

// Copy all static images
gulp.task('images', ['clean'], function () {
    return gulp.src(paths.images)
    // Pass in options to the task
        .pipe(imagemin({optimizationLevel: 5}))
        .pipe(gulp.dest('build/img'));
});

// Rerun the task when a file changes
gulp.task('watch', function () {
    //gulp.watch(paths.scripts, ['scripts']);
    gulp.watch(paths.images, ['images']);
});

gulp.task('sass', function () {
    return gulp.src('./sass/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./css'));
});

gulp.task('sass:watch', function () {
    gulp.watch('./sass/**/*.scss', ['sass']);
});

gulp.task('css', function () {
    gulp.src('client/css/*.css')
        .pipe(csslint())
        .pipe(csslint.formatter());
});
gulp.task('lint', function () {
    return gulp.src('./lib/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('YOUR_REPORTER_HERE'));
});

gulp.task('size', function () {
    gulp.src('fixture.js')
        .pipe(size())
        .pipe(gulp.dest('dist'))
});

gulp.task('jscs:read', function() {
    return gulp.src('src/app.js')
        .pipe(jscs())
        .pipe(jscs.reporter());
});

gulp.task('jscs:fix', function() {
    return gulp.src('src/app.js')
        .pipe(jscs({fix: true}))
        .pipe(gulp.dest('src'));
});

//With options
gulp.task('css:encode', function () {
    return gulp.src('src/css/input.css')
        .pipe(cssBase64({
            baseDir: "../../images",
            maxWeightResource: 100,
            extensionsAllowed: ['.gif', '.jpg']
        }))
        .pipe(gulp.dest('dist'));
});




client.getPosts(function (error, posts) {
    console.log("Found " + posts.length + " posts!");
});

// Callbacks
wp.posts().get(function (err, data) {
    if (err) {
        // handle err
    }
    // do something with the returned posts
});

// Promises
wp.posts().then(function (data) {
    // do something with the returned posts
}).catch(function (err) {
    // handle error
});

/*del(['tmp/*.js', '!tmp/unicorn.js']).then(paths => {
 console.log('Deleted files and folders:\n', paths.join('\n'));
 });*/



// The default task (called when you run `gulp` from cli)
//gulp.task('default', ['watch', 'scripts', 'images']);
gulp.task('default', ['watch', 'images']);
