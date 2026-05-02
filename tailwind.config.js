import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, require('daisyui')],
    daisyui: {
        themes: [
            {
                mytheme: {
                    "primary": "#2563eb",
                    "primary-content": "#ffffff",
                    "secondary": "#64748b",
                    "secondary-content": "#ffffff",
                    "accent": "#f59e0b",
                    "accent-content": "#000000",
                    "neutral": "#1e293b",
                    "neutral-content": "#f8fafc",
                    "base-100": "#ffffff",
                    "base-200": "#f1f5f9",
                    "base-300": "#e2e8f0",
                    "base-content": "#1e293b",
                    "info": "#3b82f6",
                    "success": "#22c55e",
                    "warning": "#f59e0b",
                    "error": "#ef4444",
                },
            },
        ],
    },
};
