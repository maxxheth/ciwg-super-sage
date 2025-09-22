import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";
import laravel from "laravel-vite-plugin";
import { wordpressPlugin, wordpressThemeJson } from "@roots/vite-plugin";
import path from "node:path";

// const __dirname = path.resolve();

export default defineConfig({
    build: {
        outDir: "./public",
        manifest: true,
        sourcemap: true,
    },
    plugins: [
        tailwindcss(),
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.ts",
                "resources/css/editor.css",
                "resources/js/editor.ts",
            ],
            refresh: true,
            publicDirectory: "public",
        }),

        wordpressPlugin(),

        // // Generate the theme.json file in the public/build/assets directory
        // // based on the Tailwind config and the theme.json file from base theme folder
        wordpressThemeJson({
            disableTailwindColors: false,
            disableTailwindFonts: false,
            disableTailwindFontSizes: false,
        }),
    ],
    resolve: {
        alias: {
          "~": path.resolve(__dirname, "./"),
          "@scripts": path.resolve(__dirname, "resources/js"),
          "@styles": path.resolve(__dirname, "resources/css"),
          "@fonts": path.resolve(__dirname, "resources/fonts"),
          "@images": path.resolve(__dirname, "resources/images")
        },
    },
    envDir: path.resolve(__dirname, "./"),
    esbuild: {
        target: "es2020",
    },

});
