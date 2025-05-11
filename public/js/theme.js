// tailwind.config.js
tailwind.config = {
  theme: {
    extend: {
      colors: {
        black: '#151d13',
        orange: {
          400: '#ff7206',
          500: '#ff6600',
        },
        yellow: {
          300: '#fff9db',
          400: '#fadb6b',
          500: '#ffc800',
        },
      },
      keyframes: {
        pingSlow: {
          '0%': {
            transform: 'scale(1)',
            opacity: '1',
          },
          '75%, 100%': {
            transform: 'scale(1.3)',
            opacity: '0',
          },
        },
      },
      animation: {
        'ping-slow': 'pingSlow 2s cubic-bezier(0, 0, 0.2, 1) infinite',
      },
    },
  },
};
