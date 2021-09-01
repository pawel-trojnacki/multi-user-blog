export function editor() {
    function initialSetup(editor) {
        editor.on("init", function (e) {
          editor.setContent("<p>Your content goes here...</p>");
        });
      }
      
      const isEditor = document.getElementById("content");
      
      if (isEditor) {
        tinymce.init({
          selector: "#content",
          plugins:
            "lists link image fullscreen emoticons codesample wordcount autosave paste",
          codesample_languages: [
            { text: "HTML", value: "markup" },
            { text: "CSS", value: "css" },
            { text: "JavaScript", value: "javascript" },
            { text: "Python", value: "python" },
            { text: "PHP", value: "php" },
            { text: "Ruby", value: "ruby" },
            { text: "Java", value: "java" },
            { text: "C#", value: "csharp" },
            { text: "C", value: "c" },
            { text: "C++", value: "cpp" },
          ],
          menubar: "file edit insert",
          toolbar:
            "undo redo | restoredraft | fullscreen |formatselect | bold italic underline | bullist numlist | link image emoticons | codesample | wordcount",
          block_formats: "Paragraph=p; Heading=h2; Subheading=h3",
          height: 400,
          preview_styles: false,
          placeholder: "Your content goes here...",
          codesample_global_prismjs: true,
          paste_as_text: true,
        });
      }
}