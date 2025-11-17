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
    base: isProduction ? '/build/' : '/',
    build: {
        manifest: true,
        outDir: 'public/build/',
        emptyOutDir: true,
        minify: 'esbuild',
        sourcemap: false,
        cssCodeSplit: true, // Enable CSS code splitting
        rollupOptions: {
            input: {
                app: path.resolve(__dirname, 'resources/js/app.ts'),
            },
            output: {
                manualChunks: (id) => {
                    // Vendor chunk for large libraries
                    if (id.includes('node_modules')) {
                        if (id.includes('vue') || id.includes('inertia') || id.includes('@inertiajs')) {
                            return 'vue-vendor';
                        }
                        if (id.includes('axios') || id.includes('lodash')) {
                            return 'http-vendor';
                        }
                        if (id.includes('jquery') || id.includes('bootstrap') || id.includes('owl.carousel')) {
                            return 'ui-vendor';
                        }
                        if (id.includes('sweetalert2') || id.includes('flatpickr')) {
                            return 'plugins-vendor';
                        }
                        return 'vendor';
                    }

                    // Separate chunk for large CSS files
                    if (id.includes('.css')) {
                        return 'styles';
                    }
                },
                // Optimize chunk file names
                chunkFileNames: 'assets/[name]-[hash].js',
                entryFileNames: 'assets/[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name?.endsWith('.css')) {
                        return 'assets/[name]-[hash][extname]';
                    }
                    return 'assets/[name]-[hash][extname]';
                },
            },
        },
        // Increase chunk size warning limit
        chunkSizeWarningLimit: 1000,
    },
    }
});
