import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
		"resources/css/auth.css",
		"resources/css/preloader.css",
		"resources/css/admin/fonts/phosphor/phosphor-fill.css",           
		"resources/css/orpawnage-animation.css", 
		"resources/css/admin/fonts/phosphor/phosphor.css",
		"resources/css/style.css",
		"resources/css/admin/style.css",
		"resources/css/admin/fonts/phosphor/phosphor-bold.css",
		"resources/css/admin/fonts/remix/remixicon.css",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
