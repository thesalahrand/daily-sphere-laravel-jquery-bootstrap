const path = require('path')
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/js/app.js",
        "resources/js/register.js",
        "resources/js/daily-prayer-tracker.js",
        "resources/js/prayer-leaderboard.js",
        "resources/js/prayer-tracker-history.js"
      ],
      refresh: true,
    }),
  ],
  resolve: {
    alias: {
      '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
    },
  },
});
