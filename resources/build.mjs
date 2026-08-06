/**
 * Build des assets du plugin Staff.
 *
 * Remplace laravel-mix, qui n'est plus maintenu et imposait webpack ainsi
 * qu'une configuration pnpm dediee (node_modules a plat, scripts
 * d'installation autorises, webpack epingle a 5.66).
 *
 * Le plugin n'a qu'une feuille SCSS et un script JS autonome : Glide est
 * charge separement en global par la vue, `script.js` n'importe donc rien.
 * Aucun bundler n'est necessaire.
 *
 * Le JS n'est pas minifie : la source fait 600 octets, la ou le bundle
 * webpack minifie en faisait 1,3 Kio une fois son runtime ajoute. Ajouter un
 * minifieur couterait une dependance pour un fichier plus gros.
 *
 *   node build.mjs           developpement : CSS lisible + sourcemap
 *   node build.mjs --prod    production : CSS compresse, sans sourcemap
 *   node build.mjs --watch   recompile a chaque modification
 */
import { copyFile, cp, mkdir, rm, writeFile } from 'node:fs/promises';
import { existsSync, watch } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';
import * as sass from 'sass';

const ROOT = dirname(fileURLToPath(import.meta.url));
const ASSETS = join(ROOT, '..', 'assets');
const GLIDE = join(ROOT, 'node_modules', '@glidejs', 'glide', 'dist');

const isProd = process.argv.includes('--prod');
const isWatch = process.argv.includes('--watch');

const size = (content) => `${(Buffer.byteLength(content) / 1024).toFixed(2)} KiB`;

async function buildCss() {
    const target = join(ASSETS, 'css', 'style.css');
    const result = sass.compile(join(ROOT, 'scss', 'style.scss'), {
        style: isProd ? 'compressed' : 'expanded',
        sourceMap: !isProd,
        quietDeps: true,
    });

    let css = result.css;

    await mkdir(dirname(target), { recursive: true });

    if (isProd) {
        await rm(`${target}.map`, { force: true });
    } else {
        css += '\n/*# sourceMappingURL=style.css.map */\n';
        await writeFile(`${target}.map`, JSON.stringify(result.sourceMap));
    }

    await writeFile(target, css);

    return `css/style.css  ${size(css)}`;
}

async function buildJs() {
    const source = join(ROOT, 'js', 'script.js');
    const target = join(ASSETS, 'js', 'script.js');

    await mkdir(dirname(target), { recursive: true });
    await rm(`${target}.map`, { force: true });
    await copyFile(source, target);

    return 'js/script.js';
}

async function copyVendor() {
    const files = [
        ['glide.min.js', join(ASSETS, 'js', 'glide.min.js')],
        [join('css', 'glide.core.min.css'), join(ASSETS, 'css', 'glide.core.min.css')],
        [join('css', 'glide.theme.min.css'), join(ASSETS, 'css', 'glide.theme.min.css')],
    ];

    for (const [from, target] of files) {
        await mkdir(dirname(target), { recursive: true });
        await cp(join(GLIDE, from), target);
    }

    return `${files.length} fichiers Glide copies`;
}

async function copyImages() {
    const source = join(ROOT, 'image');

    if (!existsSync(source)) {
        return null;
    }

    await cp(source, join(ASSETS, 'image'), { recursive: true });

    return 'image/ copie';
}

async function build() {
    const start = Date.now();

    try {
        const results = await Promise.all([buildCss(), buildJs(), copyVendor(), copyImages()]);

        console.log(`\n  Staff — build ${isProd ? 'production' : 'developpement'}`);
        results.filter(Boolean).forEach((line) => console.log(`    ${line}`));
        console.log(`  Termine en ${Date.now() - start} ms\n`);
    } catch (error) {
        console.error(`\n  Echec du build : ${error.message}\n`);

        if (!isWatch) {
            process.exitCode = 1;
        }
    }
}

await build();

if (isWatch) {
    let pending = null;

    for (const dir of ['scss', 'js', 'image']) {
        const source = join(ROOT, dir);

        if (!existsSync(source)) {
            continue;
        }

        watch(source, { recursive: true }, () => {
            clearTimeout(pending);
            pending = setTimeout(build, 50);
        });
    }

    console.log('  En attente de modifications… (Ctrl+C pour quitter)\n');
}
