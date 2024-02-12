import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'

// const host = 'pruebadom.dmtech.cl';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                // 'resources/dist/js/adminlte.min.js',
                // 'resources/dist/css/adminlte.min.css',
                // 'resources/plugins/bootstrap/js/bootstrap.bundle.min.js',
                // 'resources/plugins/fontawesome-free/css/all.min.css',
                // 'resources/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
                // 'resources/plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
                // 'resources/plugins/datatables-buttons/css/buttons.bootstrap4.min.css',
                // 'resources/plugins/datatables/jquery.dataTables.min.js',
                // 'resources/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js', 
                // 'resources/plugins/datatables-responsive/js/dataTables.responsive.min.js', 
                // 'resources/plugins/datatables-responsive/js/responsive.bootstrap4.min.js', 
                // 'resources/plugins/datatables-buttons/js/dataTables.buttons.min.js'
            ],
            // detectTls: host,
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    }
    // server: {
    //     port: 5173,
    //     host,
    //     hmr: { host },
    //     https: false
    // }
});
