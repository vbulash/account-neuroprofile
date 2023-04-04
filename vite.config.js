import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
	// server: {
	// 	host: true,
	// 	port: 5174,
	// 	https: true
	// },
	plugins: [
		laravel({
			input: [
				'resources/sass/main.scss',
				'resources/sass/dashmix/themes/xsmooth.scss',
				'resources/js/dashmix/app.js',
				'resources/js/app.js',
			],
			refresh: true,
		}),
	],
});
