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
    host: '0.0.0.0',        // allow external access
    port: 5173,
    cors: true,
    hmr: {
      host: '192.168.0.63', // 👈 your local IP
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
  },
    }
});
