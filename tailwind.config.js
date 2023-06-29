/** @type {import('tailwindcss').Config} */

import colors from "tailwindcss/colors";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

export default {
    content: ["./resources/**/*.blade.php", "./vendor/filament/**/*.blade.php"],
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                success: colors.green,
                warning: colors.yellow,
                primary: {
                    50: "#fff7ed",
                    100: "#ffedd5",
                    200: "#fed7aa",
                    300: "#fdba74",
                    400: "#fb923c",
                    500: "#ED8223",
                    600: "#ED8223",
                    700: "#c2410c",
                    800: "#9a3412",
                    900: "#7c2d12",
                },
            },
        },
    },
    plugins: [forms, typography],
};
