import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { resolve } from 'path'

export default defineConfig({
  plugins: [vue()],
  build: {
    outDir: 'public',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: resolve(__dirname, 'resources/js/app.js'),
      output: {
        entryFileNames: 'app.js',
        assetFileNames: 'app.css'
      }
    }
  },
  resolve: {
    alias: {
      '@': resolve(__dirname, 'resources/js')
    }
  }
})