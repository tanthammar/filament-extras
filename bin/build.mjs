import * as esbuild from 'esbuild'
import Path from 'path'
import fs from 'fs'
import postcss from 'esbuild-postcss'
import { exec } from 'child_process'

const shouldWatch = process.argv.includes('--watch')
let tempPath = null

async function compile(options) {
    const context = await esbuild.context(options)
    if (shouldWatch) {
        await context.watch()
    } else {
        await context.rebuild()
        await context.dispose()
    }
}


const esm = {
    define: {
        'process.env.NODE_ENV': shouldWatch ?  `'development'` : `'production'`,
    },
    entryPoints: null,
    outdir: null,
    bundle: true,
    mainFields: ['module', 'main'],
    platform: 'neutral', //output format is set to esm, which uses the export syntax introduced with ECMAScript 2015 (i.e. ES6
    sourcemap: shouldWatch ? 'inline' : false,
    sourcesContent: shouldWatch,
    treeShaking: true, //removes unused code
    target: ['es2020'],
    minify: !shouldWatch,
    drop: shouldWatch ? [] : ['console', 'debugger'],
    loader: { // convert image urls to embedded images, no need to publish css images
        '.jpg': 'dataurl',
        '.png': 'dataurl',
        '.svg': 'text',
        '.gif': 'dataurl',
        '.webp': 'dataurl',
        '.woff': 'file',
        '.woff2': 'file',
        '.data': 'base64',
    },
    plugins: [
        postcss(),
        {
            name: 'watchPlugin',
            setup(build) {
                build.onStart(() => {
                    console.log(`Build started at ${new Date(Date.now()).toLocaleTimeString()}: ${build.initialOptions.outdir}`)
                })

                build.onEnd((result) => {
                    if (result.errors.length > 0) {
                        console.log(`Build failed at ${new Date(Date.now()).toLocaleTimeString()}: ${build.initialOptions.outdir}`, result.errors)
                    } else {
                        console.log(`Build finished at ${new Date(Date.now()).toLocaleTimeString()}: ${build.initialOptions.outdir}`)
                        //only here to test build.mjs for the filament pr and to remember how to run an artisan command from node
                        /*exec('php artisan filament:assets', (error, stdout, stderr) => {
                            if (error) {
                                console.log(`error: ${error.message}`);
                                return;
                            }
                            if (stderr) {
                                console.log(`stderr: ${stderr}`);
                                return;
                            }
                            console.log(`stdout: ${stdout}`);
                        })*/
                    }
                })
            }
        }
    ]
}

const invoked = {
    ...esm,
    target: ['es2020', 'chrome112', 'edge112', 'firefox113', 'safari16'],
    platform: 'browser', //'wraps the generated JavaScript code in an immediately-invoked function expression to prevent variables from leaking into the global scope
}

//Alpine modules
if (fs.existsSync(tempPath = "resources/js/modules/")) {
    fs.readdirSync(tempPath)
        .forEach((filename) => {
            compile({
                ...esm,
                entryPoints: [tempPath + filename],
                outdir: `./dist/${Path.parse(filename).name}`, //removes file name extension
            })
        })
}

//window scripts
if (fs.existsSync(tempPath = "resources/js/invoked/")) {
    fs.readdirSync(tempPath)
        .forEach((filename) => {
            compile({
                ...invoked,
                entryPoints: [tempPath + filename],
                outdir: `./dist`,
            })
        })
}

//css
if (fs.existsSync(tempPath = "resources/css/esbuild/")) {
    fs.readdirSync(tempPath)
        .forEach((filename) => {
            compile({
                ...esm,
                entryPoints: [tempPath + filename],
                outdir: `./dist`,
            })
        })
}

