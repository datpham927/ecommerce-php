import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true, // Đặt đúng vị trí, đây là tùy chọn của `laravel()`
        }),
    ],
    build: {
        outDir: 'public/build', // Thư mục build phải trùng với Laravel
        manifest: true, // Đảm bảo tạo manifest.json
        rollupOptions: {
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
        },
    },
});
