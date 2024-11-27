import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
    build: {
        outDir: 'public/build', // Ensure the output directory is correct
        manifest: true, // Ensure manifest is enabled
        rollupOptions: {
            input: ['resources/css/app.css', 'resources/js/app.js'],
        },
    },
});
