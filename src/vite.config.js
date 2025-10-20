import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  // 개발환경에서만
  // server: {
  //   host: '0.0.0.0',   // 외부 접근 허용
  //   port: 5173,
  //   strictPort: true,
  //   hmr: {
  //     host: 'localhost', // 또는 127.0.0.1 (Windows 기준)
  //   },
  //   watch:{
  //     usePolling: true,
  //     interval: 500,
  //       ignored: [
  //       '**/vendor/**',
  //       '**/node_modules/**',
  //       '**/storage/**',
  //       '**/public/**',
  //   ],
  //   }
  // },
  //  build: {
  //   manifest: true,
  //   outDir: 'public/build',
  //   rollupOptions: {
  //     input: 'resources/js/app.js',
  //   },
  // },
  plugins: [
    laravel({
      input: ['resources/css/scss/main.scss', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
});
