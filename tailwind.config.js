module.exports = {
  purge: [
    './src-front/**/*.html',
  ],
  // prefix: 'tw-',
  theme: {
    container: {
      center: true,
    },
    fontFamily: {
      // 'display': ['Helvetica', 'Arial', 'sans-serif'],
      'body': ['Helvetica', 'Arial', 'sans-serif'],
    },
    screens: {
      sm: '512px',
      md: '768px',
      lg: '1024px'
    },
    // fontSize: {
    //   sm: ['14px', '20px'],
    //   base: ['16px', '24px'],
    //   lg: ['20px', '28px'],
    //   xl: ['24px', '32px'],
    // },
    // colors: {
    //   indigo: '#5c6ac4',
    //   blue: '#007ace',
    //   red: '#de3618',
    // },

    extend: {},
  },
  variants: {
    backgroundColor: ['responsive', 'hover', 'focus', 'active'],
  },
  plugins: [],
  // corePlugins: ['margin', 'padding', 'cursor', 'fill'],
}
