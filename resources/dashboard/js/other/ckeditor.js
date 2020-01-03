require('./ckeditor/ckeditor.js');

import Alignment from '@ckeditor/ckeditor5-alignment/src/alignment';

// export default class ClassicEditor extends ClassicEditorBase {}

ClassicEditor.builtinPlugins = [
    Alignment
];

ClassicEditor.defaultConfig = {
    toolbar: {
        items: [
            'alignment',
        ]
    },
    language: 'en'
};