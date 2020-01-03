/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    config.font_names = 'Vazir; Tahoma';
    config.uiColor = '#f0f0f0';
    config.height = 300;
    config.language = 'fa';
    config.uiColor = '#ffffff';
    config.allowedContent = {
        script: true,
        $1: {
            // This will set the default set of elements
            elements: CKEDITOR.dtd,
            attributes: true,
            styles: true,
            classes: true
        }
    };
    config.filebrowserBrowseUrl = '/assets/editors/kcfinder/browse.php?opener=ckeditor&type=files';
    config.filebrowserImageBrowseUrl = '/assets/editors/kcfinder/browse.php?opener=ckeditor&type=images';
    config.filebrowserFlashBrowseUrl = '/assets/editors/kcfinder/browse.php?opener=ckeditor&type=flash';
    config.filebrowserUploadUrl = '/assets/editors/kcfinder/upload.php?opener=ckeditor&type=files';
    config.filebrowserImageUploadUrl = '/assets/editors/kcfinder/upload.php?opener=ckeditor&type=images';
    config.filebrowserFlashUploadUrl = '/assets/editors/kcfinder/upload.php?opener=ckeditor&type=flash';
    // config.extraPlugins = 'codesnippet';
    // config.extraPlugins = 'prism,codesnippet';
    config.extraPlugins = "lineutils,widget,codesnippet,prism";

    // config.codeSnippet_languages = {
    //     javascript: 'JavaScript',
    //     php: 'PHP',
    //     css: 'CSS',
    // };
};
