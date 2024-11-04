import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Warna Utama
                white: '#FFFFFF',
                black: '#000000',

                // Hijau Pastel/Muda
                'pastel': {
                    50: '#F0FFF4',
                    100: '#BCF0DA',  // Hijau Pastel Utama
                    200: '#98E5C9',
                    300: '#74DAB7',
                    400: '#50CFA6',
                },

                // Hijau Tua
                'forest': {
                    500: '#2D5A45',  // Hijau Tua Medium
                    600: '#224433',  // Hijau Tua
                    700: '#1A332B',  // Hijau Tua Gelap
                    800: '#132A20',
                    900: '#0C1F17',
                },

                // Warna untuk Actions/Buttons
                'action': {
                    'primary': '#2D5A45',    // Tombol Primary (Hijau Tua)
                    'secondary': '#BCF0DA',   // Tombol Secondary (Hijau Pastel)
                    'danger': '#DC2626',      // Tombol Delete
                    'warning': '#F59E0B',     // Tombol Warning/Edit
                    'info': '#3B82F6',        // Tombol Info
                }
            },
        },
    },
    plugins: [],
};
