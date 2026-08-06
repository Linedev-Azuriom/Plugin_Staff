import { defineConfig } from 'vite';
import { viteStaticCopy } from 'vite-plugin-static-copy';

// Glide est charge en global par la vue (script.js ne l'importe pas) : ses
// fichiers dist sont copies tels quels, comme le core Azuriom le fait pour ses
// propres vendors.
const glide = 'node_modules/@glidejs/glide/dist';

export default defineConfig(({ mode }) => ({
    build: {
        // `vite build --mode development` ne desactive pas la minification a
        // lui seul : on la pilote explicitement pour que `pnpm dev` produise
        // un fichier lisible et une sourcemap.
        minify: mode !== 'development',
        sourcemap: mode === 'development',

        // Les vues appellent plugin_asset('staff', 'js/script.js'), qui resout
        // un chemin statique sans manifest : la sortie ne doit donc jamais etre
        // hachee. Meme contrainte que le vite.config.js du core.
        outDir: '../assets',

        // assets/ contient aussi image/ et les fichiers Glide : on ne vide pas
        // le dossier avant build.
        emptyOutDir: false,

        rollupOptions: {
            input: {
                script: 'js/script.js',
                style: 'scss/style.scss',
            },
            output: {
                entryFileNames: 'js/[name].js',
                chunkFileNames: 'js/[name].js',
                assetFileNames: 'css/[name][extname]',
            },
        },
    },

    plugins: [
        viteStaticCopy({
            // stripBase aplatit la copie : sans lui, le plugin recree
            // l'arborescence node_modules/@glidejs/... dans assets/.
            targets: [
                { src: `${glide}/glide.min.js`, dest: 'js', rename: { stripBase: true } },
                { src: `${glide}/css/glide.core.min.css`, dest: 'css', rename: { stripBase: true } },
                { src: `${glide}/css/glide.theme.min.css`, dest: 'css', rename: { stripBase: true } },
            ],
        }),
    ],

    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: ['import', 'global-builtin'],
            },
        },
    },
}));
