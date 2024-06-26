// vite.config.js
import { defineConfig } from 'vite';

import { ViteImageOptimizer } from 'vite-plugin-image-optimizer';

export default defineConfig({
  base: '',
  root: 'public/resources',
  build: {
    outDir: '../dist',
    rollupOptions: {
      output: {
        entryFileNames: `js/[name].js`,
        chunkFileNames: `js/[name].js`,
        // assetFileNames: `[name].[ext]`,

        assetFileNames: ({ name }) => {

          if (/\.(gif|jpe?g|png|svg)$/.test(name ?? '')) {
            return 'img/[name].[ext]';
          }

          if (/\.(ttf|otf)$/.test(name ?? '')) {
            return 'fonts/[name].[ext]';
          }

          if (/\.css$/.test(name ?? '') || /\.s[ac]ss$/.test(name ?? '')) {
            return 'css/[name].[ext]';
          }

          // default value
          // ref: https://rollupjs.org/guide/en/#outputassetfilenames
          return '[name].[ext]';
        },
      },

      plugins: [
        process.env.NODE_ENV === 'production' && ViteImageOptimizer({
          jpg: {
            quality: 40
          },
          png: {
            quality: 40
          }
        })
      ],

    },

  }
});