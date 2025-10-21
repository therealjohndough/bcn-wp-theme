module.exports = {
  testEnvironment: 'jsdom',
  setupFilesAfterEnv: ['<rootDir>/tests/setup.js'],
  testMatch: [
    '<rootDir>/tests/**/*.test.js',
    '<rootDir>/assets/js/**/*.test.js'
  ],
  collectCoverageFrom: [
    'assets/js/**/*.js',
    '!assets/js/vendor/**',
    '!**/node_modules/**'
  ],
  coverageDirectory: 'coverage',
  coverageReporters: ['text', 'lcov', 'html'],
  moduleNameMapping: {
    '^@/(.*)$': '<rootDir>/assets/$1',
    '^@js/(.*)$': '<rootDir>/assets/js/$1',
    '^@css/(.*)$': '<rootDir>/assets/css/$1',
    '^@images/(.*)$': '<rootDir>/assets/images/$1'
  },
  globals: {
    jQuery: require('jquery'),
    $: require('jquery'),
    wp: {
      ajax: {
        settings: {
          url: 'http://localhost/wp-admin/admin-ajax.php'
        }
      }
    },
    ajaxurl: 'http://localhost/wp-admin/admin-ajax.php',
    bcn_ajax: {
      nonce: 'test-nonce'
    }
  },
  transform: {
    '^.+\\.js$': 'babel-jest'
  },
  testTimeout: 10000
};