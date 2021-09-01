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

const likeButton = document.getElementById("like-button");

if (likeButton) {
  const postIdInput = document.getElementById("post-id");
  const postId = postIdInput.value;

  async function fetchPostLikesNumber() {
    const response = await fetch(`/post-likes?id=${postId}`);
    const data = await response.json();
    return data.likes;
  }

  async function fetchIsLike() {
    const response = await fetch(`/post-like?id=${postId}`);
    const data = await response.json();
    return data.like;
  }

  async function setLikesValue() {
    const likesNode = document.getElementById("likes-number");
    const likes = await fetchPostLikesNumber();
    likesNode.textContent = likes;
  }

  async function setIsLike() {
    const likeThumbNode = document.getElementById("like-thumb");
    const like = await fetchIsLike();
    if (like) {
      likeThumbNode.className = "bi-hand-thumbs-up-fill";
    } else {
      likeThumbNode.className = "bi-hand-thumbs-up";
    }
  }

  async function like() {
    const response = await fetch(`/post-like?id=${postId}`, {
      method: "POST",
      body: JSON.stringify({ id: postId }),
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
    });

    const data = await response.json();

    if (data.error && data.error === "notAuthenticated") {
      alert("You have to be authenticated");
    }
    if (data.success) {
      setLikesValue();
      setIsLike();
    }
  }

  setLikesValue();
  setIsLike();

  likeButton.addEventListener("click", like);
}

const commentsButton = document.getElementById("comments-button");

if (commentsButton) {
  const closeButton = document.getElementById("comments-close-button");
  const modal = document.getElementById("comments-modal");
  const wrapper = document.getElementById("comments-wrapper");

  function toggleCommentsModalVisibility() {
    modal.classList.toggle("hidden");
  }

  function toggleCommentsWrapperTransform() {
    wrapper.classList.toggle("comments-wrapper-hidden");
  }

  commentsButton.addEventListener("click", function () {
    toggleCommentsModalVisibility();
    toggleCommentsWrapperTransform();
  });

  closeButton.addEventListener("click", function () {
    toggleCommentsModalVisibility();
    toggleCommentsWrapperTransform();
  });
}
