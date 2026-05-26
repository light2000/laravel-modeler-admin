import eslint from '@eslint/js'
import eslintConfigPrettier from 'eslint-config-prettier'
import eslintPluginVue from 'eslint-plugin-vue'
import globals from 'globals'
import typescriptEslint from 'typescript-eslint'
import unusedImports from 'eslint-plugin-unused-imports'

export default typescriptEslint.config(
  // 可选：忽略项（按你项目调整）
  { ignores: ['**/dist/**', '**/coverage/**', '**/node_modules/**'] },

  // 主配置：只 lint ts / vue（你的生成物）
  {
    files: ['**/*.{ts,vue}'],
    extends: [
      eslint.configs.recommended,
      ...typescriptEslint.configs.recommended,
      ...eslintPluginVue.configs['flat/recommended'],
    ],
    languageOptions: {
      ecmaVersion: 'latest',
      sourceType: 'module',
      globals: globals.browser,
      parserOptions: {
        // 关键：Vue 文件由 vue-eslint-parser 解析，TS 由这里指定
        parser: typescriptEslint.parser,
      },
    },
    plugins: {
      'unused-imports': unusedImports,
    },
    rules: {
      // 删除未使用 import（你要的“大胆引用然后清理”）
      'unused-imports/no-unused-imports': 'error',

      // 变量未使用：交给 unused-imports 处理即可
      'no-unused-vars': 'off',
      'unused-imports/no-unused-vars': [
        'warn',
        { vars: 'all', varsIgnorePattern: '^_', args: 'after-used', argsIgnorePattern: '^_' },
      ],
    },
  },

  // 关闭与 Prettier 冲突的规则（可选但建议）
  eslintConfigPrettier,
)
