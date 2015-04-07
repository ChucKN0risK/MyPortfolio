var gulp         = require('gulp');
var sass         = require('gulp-sass');
var sourcemaps   = require('gulp-sourcemaps');
var browserSync  = require('browser-sync'); 
var reload       = browserSync.reload;
var autoprefixer = require('gulp-autoprefixer');


var sassPath = './public/src/scss/**/*.scss';
var htmlPath = './*.html';


gulp.task('serve', function() {
  browserSync({
    proxy: "http://localhost:8888/Perso/Portfolio_2015/MyPortfolio/"
  });

  gulp.watch(sassPath, ['sass']);
  gulp.watch(htmlPath).on('change', reload);
});


gulp.task('sass', function () {
  gulp.src(sassPath)
    .pipe(sourcemaps.init())
    .pipe(sass({
      onError: console.error.bind(console, 'SASS error')
    }))
    .pipe(autoprefixer({
      browsers: ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1']
    }))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./public/build/css/'))
    .pipe(reload({stream: true}));
});


// gulp.task('sass-prod', function () {
//   gulp.src(sassPath)
//     .pipe(sass())
//     // minify
//     // autoprefixer
//     .pipe(gulp.dest('./assets/build/'))
//     .pipe(reload({stream: true}));
// });


gulp.task('default', ['sass','serve'], function () {
  gulp.watch(sassPath, ['sass']);
  gulp.watch(htmlPath).on('change', reload);
});

gulp.task('prod', ['sass-prod', 'uglify']);

