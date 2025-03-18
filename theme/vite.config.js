import path from "path";
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { visualizer } from "rollup-plugin-visualizer";
import vue from "@vitejs/plugin-vue";
export default defineConfig({
  plugins: [
    laravel({
      input: [
        "../theme/sass/main.scss",
        "../theme/sass/custom/_main.scss",
        "../theme/sass/dashmix/themes/xeco.scss",
        "../theme/sass/dashmix/themes/xinspire.scss",
        "../theme/sass/dashmix/themes/xmodern.scss",
        "../theme/sass/dashmix/themes/xsmooth.scss",
        "../theme/sass/dashmix/themes/xwork.scss",
        "../theme/sass/dashmix/themes/xdream.scss",
        "../theme/sass/dashmix/themes/xpro.scss",
        "../theme/sass/dashmix/themes/xplay.scss",
        "../theme/js/dashmix/app.js",
        "../theme/js/app.js",
        "../theme/pages/map/default/index.js",
        "../theme/pages/auth/cms/icon/index.js",
      ],
      refresh: [
        "../views/**",
        "../assets/**",
        "../modules/**",
        "../config/**",
        "../controllers/**",
      ],
      publicDirectory: "../web",
      buildDirectory: "dist",
    }),
    vue({
      template: {
        transformAssetUrls: {
          // The Vue plugin will re-write asset URLs, when referenced
          // in Single File Components, to point to the Laravel web
          // server. Setting this to `null` allows the Laravel plugin
          // to instead re-write asset URLs to point to the Vite
          // server instead.
          base: null,

          // The Vue plugin will parse absolute URLs and treat them
          // as absolute paths to files on disk. Setting this to
          // `false` will leave absolute URLs un-touched so they can
          // reference assets in the public directory as expected.
          includeAbsolute: false,
        },
      },
    }),
    visualizer({ open: true }),
  ],
  resolve: {
    alias: {
      bootstrap: path.resolve(__dirname, "node_modules/bootstrap"),
      "~": path.resolve(__dirname, "js"),
    },
  },
});
