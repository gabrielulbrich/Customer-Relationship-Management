// http://eslint.org/docs/user-guide/configuring

module.exports = {
  env: {
    node: true,
    commonjs: true
  },
  extends: ['plugin:vue/essential', 'eslint:recommended'],
  parser: 'vue-eslint-parser',
  parserOptions: {
    parser: 'babel-eslint',
    ecmaVersion: 8,
    sourceType: 'module'
  },
  rules: {
    'vue/no-unused-components': ['error'],
    'vue/no-parsing-error': ['warn'],
    'no-console': ['warn', { allow: ['warn', 'error'] }],
    'no-unused-vars': [
      'warn',
      { argsIgnorePattern: 'context|args|parent|info', varsIgnorePattern: 'logger' }
    ]
  }
};
