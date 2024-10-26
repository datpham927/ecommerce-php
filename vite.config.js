// vite.config.js
import { defineConfig } from 'vite';

export default defineConfig({
  root: '.', // Ensure this is set to the correct directory
  build: {
    outDir: 'dist',
    rollupOptions: {
      input: 'index.html', // Ensure this path is correct
    },
  },
});
