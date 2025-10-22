import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig(({mode}) => {
    const isProduction = mode === 'production';

    return {
        plugins: [
        laravel({
            input: ['resources/js/app.ts', 'resources/css/app.css'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        wayfinder({
            formVariants: true,
        }),
    ],
    base: isProduction ? '/public/build/' : '/',
    server: {
        // For local development with Laravel served at http://localhost:8000
        // bind to localhost only and advertise localhost as the origin
        host: 'localhost',
        port: 5173,
        cors: true,
        strictPort: true,
        origin: 'http://localhost:5173',
        hmr: {
            host: 'localhost',
            port: 5173,
            protocol: 'ws'
        }
    },
    build: {
        manifest: true,
        outDir: 'public/build/',
        emptyOutDir: true,
        rollupOptions: {
            input: {
                app: path.resolve(__dirname, 'resources/js/app.ts'),
            },
        },
    },
    }
});
