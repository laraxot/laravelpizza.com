import { createRequire } from 'module';
const require = createRequire(import.meta.url);

export default {
    plugins: {
        'tailwindcss/nesting': 'postcss-nesting',
        'postcss-import': {
            resolve(id) {
                return require.resolve(id);
            },
        },
        tailwindcss: {},
        autoprefixer: {},
    },
};
