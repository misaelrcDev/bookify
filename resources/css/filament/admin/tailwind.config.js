import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#1d4ed8', // Azul padrão
                    light: '#60a5fa',  // Azul claro
                    dark: '#1e40af',   // Azul escuro
                },
            },
        },
    },

    fontSize: {
        'xs': '0.75rem',
        'sm': '1rem',
        'base': '1.1rem',
        'md': '1.2rem',
        'xl': '1.3rem',
        '2xl': '1.5rem',
        '3xl': '1.9rem',
        '4xl': '2.4rem',
        '5xl': '3.0rem',
    },
}
