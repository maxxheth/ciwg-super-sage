import { defineConfig } from "eslint/config";
import globals from "globals";
import js from "@eslint/js";
import tseslint from "typescript-eslint";
import prettierConfig from "eslint-config-prettier";
import prettierPlugin from "eslint-plugin-prettier";

export default defineConfig([
  { files: ["**/*.{js,mjs,cjs,ts}"] },
  { 
    files: ["**/*.{js,mjs,cjs,ts}"], 
    languageOptions: { 
      globals: {...globals.browser, ...globals.node} 
    } 
  },
  { 
    files: ["**/*.{js,mjs,cjs,ts}"], 
    plugins: { 
      js,
      prettier: prettierPlugin
    }, 
    rules: {
      "prettier/prettier": "error"
    },
    extends: [
      "js/recommended"
    ]
  },
  tseslint.configs.recommended,
  prettierConfig
]);