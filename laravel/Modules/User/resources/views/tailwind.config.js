/** @type {import('tailwindcss').Config} */
import preset from "./vendor/filament/support/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./assets/**/*.js",
        "./assets/**/*.css",
        "../../app/Filament/**/*.php",
        "../../resources/views/**/*.blade.php",
        "../../vendor/filament/**/*.blade.php",
        "../../Modules/**/Filament/**/*.php",
        "../../Modules/**/resources/views/**/*.blade.php",
        "../../storage/framework/views/*.php",
        "../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./node_modules/flowbite/**/*.js",
        "../../../public_html/vendor/**/*.blade.php",
    ],
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                primary: {
                    50: "#f0f9ff",
                    100: "#e0f2fe",
                    200: "#bae6fd",
                    300: "#7dd3fc",
                    400: "#38bdf8",
                    500: "#0ea5e9",
                    600: "#0284c7",
                    700: "#0369a1",
                    800: "#075985",
                    900: "#0c4a6e",
                    950: "#082f49",
                },
                secondary: {
                    50: "#f8fafc",
                    100: "#f1f5f9",
                    200: "#e2e8f0",
                    300: "#cbd5e1",
                    400: "#94a3b8",
                    500: "#64748b",
                    600: "#475569",
                    700: "#334155",
                    800: "#1e293b",
                    900: "#0f172a",
                },
                header: {
                    700: "#1A467F",
                },
            },
            fontFamily: {
                sans: ["Figtree", "sans-serif"],
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("flowbite/plugin"),
    ],
};
