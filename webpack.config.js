const Encore = require('@symfony/webpack-encore');
const path = require("node:path");

Encore.reset();

Encore
    .setOutputPath('contao/themes/contao_ui_53/')
    .setPublicPath('/themes/contao_ui_53')
    .copyFiles({
        from: './assets/contao/themes/contao_ui_53',
        to: '[folder]/[name].[ext]',
        includeSubdirectories: true,
        pattern: /\.(svg|woff|woff2)$/,
    })
    .cleanupOutputBeforeBuild(['*.css', '*.json', '*.map'])
    .disableSingleRuntimeChunk()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureCssLoader(config => {
        config.url = false;
    })
    // Add old Contao 4.13 entries
    .addEntry('hover', './assets/contao/themes/413/hover.js')
    .addEntry('install', './assets/contao/themes/413/install.css')
    .addEntry('switch', './assets/contao/themes/413/switch.css')
    // Add new entries
    .addEntry('ui-backport', './assets/contao/ui-backport.js')
    .addEntry('stimulus', './assets/contao/stimulus.js')
    .addStyleEntry('basic', './assets/contao/themes/contao_ui_53/basic.css')
    .addStyleEntry('main', './assets/contao/themes/contao_ui_53/main.css')
    .addStyleEntry('confirm', './assets/contao/themes/contao_ui_53/confirm.css')
    .addStyleEntry('conflict', './assets/contao/themes/contao_ui_53/conflict.css')
    .addStyleEntry('diff', './assets/contao/themes/contao_ui_53/diff.css')
    .addStyleEntry('help', './assets/contao/themes/contao_ui_53/help.css')
    .addStyleEntry('login', './assets/contao/themes/contao_ui_53/login.css')
    .addStyleEntry('popup', './assets/contao/themes/contao_ui_53/popup.css')
    .addStyleEntry('tinymce', './assets/contao/themes/contao_ui_53/tinymce.css')
    .addStyleEntry('tinymce-dark', './assets/contao/themes/contao_ui_53/tinymce-dark.css')
    .configureFilenames({
        css: '[name].min.css',
        js: '[name].min.js'
    });
;

const config53 = Encore.getWebpackConfig();

Encore.reset();

Encore
    .setOutputPath('contao/themes/contao_ui_54/')
    .setPublicPath('/themes/contao_ui_54')
    .copyFiles({
        from: './assets/contao/themes/contao_ui_54',
        to: '[folder]/[name].[ext]',
        includeSubdirectories: true,
        pattern: /\.(svg|woff|woff2)$/,
    })
    .cleanupOutputBeforeBuild(['*.css', '*.json', '*.map'])
    .disableSingleRuntimeChunk()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureCssLoader(config => {
        config.url = false;
    })
    // Add old Contao 4.13 entries
    .addEntry('hover', './assets/contao/themes/413/hover.js')
    .addEntry('install', './assets/contao/themes/413/install.css')
    .addEntry('switch', './assets/contao/themes/413/switch.css')
    // Add new entries
    .addEntry('ui-backport', './assets/contao/ui-backport.js')
    .addEntry('stimulus', './assets/contao/stimulus.js')
    .addStyleEntry('basic', './assets/contao/themes/contao_ui_54/basic.css')
    .addStyleEntry('main', './assets/contao/themes/contao_ui_54/main.css')
    .addStyleEntry('confirm', './assets/contao/themes/contao_ui_54/confirm.css')
    .addStyleEntry('conflict', './assets/contao/themes/contao_ui_54/conflict.css')
    .addStyleEntry('diff', './assets/contao/themes/contao_ui_54/diff.css')
    .addStyleEntry('help', './assets/contao/themes/contao_ui_54/help.css')
    .addStyleEntry('login', './assets/contao/themes/contao_ui_54/login.css')
    .addStyleEntry('popup', './assets/contao/themes/contao_ui_54/popup.css')
    .addStyleEntry('tinymce', './assets/contao/themes/contao_ui_54/tinymce.css')
    .addStyleEntry('tinymce-dark', './assets/contao/themes/contao_ui_54/tinymce-dark.css')
    .configureFilenames({
        css: '[name].min.css',
        js: '[name].min.js',
    });
;

const config54 = Encore.getWebpackConfig();

module.exports = [config53, config54];
