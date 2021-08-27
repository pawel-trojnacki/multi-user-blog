function initialSetup(editor) {
    editor.on('init', function(e) {
        editor.setContent('<p>Your content goes here...</p>');
    });
}

const isEditor = document.getElementById('content');

if(isEditor) {
    tinymce.init({
        selector: '#content',
        menubar: '',
        height: 400,
        setup: initialSetup,
    });
}

