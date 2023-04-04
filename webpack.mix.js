const mix = require('laravel-mix');

mix
	.sass('resources/sass/main.scss', 'public/css/app.css')
	.sass('resources/sass/dashmix/themes/xsmooth.scss', 'public/css/xsmooth.css')

	.js([
		'resources/js/dashmix/app.js',
		'resources/js/app.js'
	], 'public/js/app.js')

	// Tools
	// .browserSync('localhost:8000')
	// .disableNotifications()
	.disableSuccessNotifications()

	// Options
	.options({
		processCssUrls: false
	})
