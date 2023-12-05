import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import symfonyPlugin from "vite-plugin-symfony";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    symfonyPlugin()
  ],
  build: {
    rollupOptions: {
      input: {
        app: "./assets/app.ts"
      }
    }
  },
  server: {
    proxy: {
      '/api': {
        target: "http://host.docker.internal:8087",
        changeOrigin: true,
        secure: false,
      }
    }
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  }
})
